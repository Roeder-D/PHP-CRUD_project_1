<?php
require_once __DIR__ . '/loadEnv.php';
$host = $_ENV['DB_HOST'];
$dbname = $_ENV['DB_NAME'];
$user = $_ENV['DB_USER'];
$password = $_ENV['DB_PASSWORD'];

try{
    $pdo = new PDO(
        'mysql:host=' . $host . ';dbname=' .$dbname . ';charset=utf8mb4',
        $user,
        $password
    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // echo 'Verbindung Erfolgreich';
}
catch(PDOException $e){
    echo 'Fehler: ' . $e->getMessage();
}

?>