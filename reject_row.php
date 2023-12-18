<?php
function handleFormSubmission()
{
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $requiredFields = ['id', 'name', 'surname', 'title', 'department', 'basic_field', 'scientific_field', 'academic_activity_type', 'activity', 'work_name', 'persons'];

        // Gerekli form alanlarının varlığı ve geçerliliği kontrol ediliyor
        if (areFieldsValid($requiredFields)) {
            // Veritabanı bağlantı detayları
            $servername = "localhost"; // Farklı bir sunucu adı varsa değiştirin
            $username = "root"; // MySQL kullanıcı adınızla değiştirin
            $password = ""; // MySQL şifrenizle değiştirin
            $dbname = "aias"; // Veritabanı adınızla değiştirin

            // Bağlantı oluşturuluyor
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Bağlantı kontrol ediliyor
            if ($conn->connect_error) {
                die("Bağlantı hatası: " . $conn->connect_error);
            }

            // Form verileri alınıyor
            $id = $_POST['id'];

            // 'onay_durumu' sütununu istenen bir değere (örneğin, 'Reddedildi') güncellemek için SQL hazırlanıyor ve çalıştırılıyor
            $onayDurumu = 'Reddedildi'; // İstenilen değere göre bu değeri değiştirin
            $sql = "UPDATE tesvik SET onay_durumu = ? WHERE id = ?";

            // Prepared statement oluşturuluyor
            $stmt = $conn->prepare($sql);

            if ($stmt) {
                // Değerler parametrelerle bağlanıyor
                $stmt->bind_param("si", $onayDurumu, $id);

                // Sorgu çalıştırılıyor
                if ($stmt->execute()) {
                    echo "Satır başarıyla reddedildi";
                } else {
                    echo "Satır reddedilirken hata oluştu: " . $stmt->error;
                }

                // PreparedStatement kapatılıyor
                $stmt->close();
            } else {
                echo "Hazırlanan sorgu oluşturulamadı";
            }

            // Veritabanı bağlantısı kapatılıyor
            $conn->close();
        } else {
            echo "Geçersiz form verisi alındı";
        }
    } else {
        echo "Geçersiz istek metodu";
    }
}

function areFieldsValid($fields)
{
    foreach ($fields as $field) {
        if (!isset($_POST[$field])) {
            return false;
        }
    }
    return true;
}

// Form verilerini işle
handleFormSubmission();
?>
