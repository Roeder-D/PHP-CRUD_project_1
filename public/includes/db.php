<?php
require_once __DIR__ . '/loadEnv.php';

// Database connection
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

}
catch(PDOException $e){
    echo 'Fehler: ' . $e->getMessage();
}

?>