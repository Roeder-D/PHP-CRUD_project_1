<?php
$host = 'mysql';
$dbname = 'justShootMe';
$user = 'root';
$password = '1234';

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