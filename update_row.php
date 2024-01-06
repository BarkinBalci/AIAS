<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Veritabanı bağlantısı
    require_once "db_connection.php"; // Bağlantı dosyasını buraya dahil edin

    // Form alanlarının kontrolü
    $expected_fields = ['id', 'name', 'surname', 'title', 'department', 'basic_field', 'scientific_field', 'academic_activity_type', 'activity', 'work_name', 'doi_number', 'persons'];
    $data = [];
    $valid = true;

    foreach ($expected_fields as $field) {
        if (!isset($_POST[$field])) {
            $valid = false;
            break;
        }
        // Veriyi temizleme işlemi - Örnek olarak htmlspecialchars kullanılıyor
        $data[$field] = htmlspecialchars($_POST[$field]);
    }

    if ($valid) {
        // Prepare and execute SQL to update row with the specified ID using prepared statements
        $sql = "UPDATE tesvik SET 
                name = ?, 
                surname = ?, 
                title = ?, 
                department = ?, 
                basic_field = ?, 
                scientific_field = ?, 
                academic_activity_type = ?, 
                activity = ?, 
                work_name = ?, 
                doi_number = ?,
                persons = ?
                WHERE id = ?";

        $stmt = $conn->prepare($sql);
        if ($stmt) {
            // Verileri bağlama işlemi
            $stmt->bind_param("sssssssssssi", $data['name'], $data['surname'], $data['title'], $data['department'], $data['basic_field'], $data['scientific_field'], $data['academic_activity_type'], $data['activity'], $data['work_name'], $data['doi_number'], $data['persons'], $data['id']);
            
            if ($stmt->execute()) {
                echo "Satır başarıyla güncellendi";
            } else {
                echo "Satır güncelleme hatası: " . $stmt->error;
            }
        } else {
            echo "SQL hazırlama hatası: " . $conn->error;
        }

        // Bağlantıyı kapat
        $stmt->close();
    } else {
        echo "Geçersiz form verisi alındı";
    }

    // Bağlantıyı kapat
    $conn->close();
} else {
    echo "Geçersiz istek metodu";
}
?>
