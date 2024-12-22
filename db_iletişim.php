<?php
include "baglan.php";
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Form verilerini al
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $message = $_POST['message'];

        // sql sorgusu
        $sql = "INSERT INTO iletişim (name, email, mesaj) VALUES (:name, :email, :mesaj)";
        
        // Hazırlanan sorgu
        $deger = $conn->prepare($sql);

        // Parametreleri bağla
        $deger->bindParam(':name', $name);
        $deger->bindParam(':email', $email);
        $deger->bindParam(':mesaj', $message);

        // Sorguyu çalıştır
        if ($deger->execute()) {
            header("Location: iletisim.php?status=success");
        } else {
            header("Location: iletisim.php?status=error");
        }
    }

} catch (PDOException $e) {
    echo "Bağlantı hatası: " . $e->getMessage();
}

?>