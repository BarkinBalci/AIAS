<?php
// Veritabanı bağlantısı
require_once "db_connection.php";

// 'id' parametresini kontrol et ve reddetme işlemini gerçekleştir
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = $_POST['id']; // POST isteğinden 'id' değerini al
    
    // 'onay_durum' değerini 'Reddedildi' olarak güncelle
    $updateSql = "UPDATE tesvik SET onay_durum = 'Reddedildi' WHERE id = $id";

    if ($conn->query($updateSql) === TRUE) {
        echo "Reddetme işlemi başarıyla gerçekleştirildi.";
        // JavaScript ile sayfanın yenilenmesi
        echo "<script>location.reload();</script>";
    } else {
        echo "Hata oluştu: " . $conn->error;
    }
} else {
    echo "Geçersiz istek veya eksik parametre.";
}

// Veritabanı bağlantısını kapat
$conn->close();
?>
