<?php
include "baglan.php";

header('Content-Type: application/json');

// JSON verisini al
$jsonData = file_get_contents("php://input");
$data = json_decode($jsonData, true); // JSON'u diziye çevir

// Başarılı veya hatalı işlem durumu
$status = "success";

// Sepet verisini kontrol et ve işleme
if (is_array($data) && !empty($data)) {
    // Gelen sepet verilerini tek tek işleme
    foreach ($data as $item) {
        $name = $item['name'] ?? 'Unknown'; // Varsayılan değerler
        $price = $item['price'] ?? 0;
        $quantity = $item['quantity'] ?? 0;
        $size = $item['size'] ?? 'Unknown';

        // SQL sorgusu
        $sql = "INSERT INTO siparis (name, price, quantity, size) VALUES (:name, :price, :quantity, :size)";

        // Hazırlanan sorgu
        $deger = $conn->prepare($sql);

        // Parametreleri bağla
        $deger->bindParam(':name', $name);
        $deger->bindParam(':price', $price);
        $deger->bindParam(':quantity', $quantity);
        $deger->bindParam(':size', $size);

        // Sorguyu çalıştır
        if (!$deger->execute()) {
            // Eğer bir hata oluşursa, durum değişir
            $status = "error";
            break; // Hata durumunda daha fazla işlem yapma
        }
    }

    // JSON olarak sonuç döndür
    echo json_encode(['status' => $status, 'message' => $status == 'success' ? 'Sipariş başarıyla alındı' : 'Bir hata oluştu']);
} else {
    // Eğer sepet verisi eksik veya hatalıysa
    echo json_encode(['status' => 'error', 'message' => "Sepet verisi eksik veya hatalı"]);
}
?>
