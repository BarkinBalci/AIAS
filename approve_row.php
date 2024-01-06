<?php
// Veritabanı bağlantısı
require_once "db_connection.php";

// Check if 'id' parameter exists in POST request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = $_POST['id']; // Get ID value from POST data
    
    // SQL sorgusu ile 'onay_durum' değerini 'Onaylandı' olarak güncelle
    $updateSql = "UPDATE tesvik SET onay_durum = 'Onaylandı' WHERE id = $id";

    if ($conn->query($updateSql) === TRUE) {
        echo "Onay durumu başarıyla güncellendi.";
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

