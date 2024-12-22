<?php
$servername = "localhost"; // Veritabanı sunucusu
$username = "root"; // Veritabanı kullanıcı adı
$password = ""; // Veritabanı şifresi
$dbname = "nesro"; // Veritabanı adı

try {
    // PDO bağlantısı
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    
    // Bağlantıyı aktif etme işlemi
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e) {
    echo "Bağlantı başarısız: " . $e->getMessage();
}
?>