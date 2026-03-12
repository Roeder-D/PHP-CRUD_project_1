<?php
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/logger.php';

// create tuple in person table
function create_person($name, $surname, $email){
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO person (name, surname, email) VALUES (?, ?, ?)");
    return $stmt->execute([$name, $surname, $email]);
}

// validate input and create person
function process_add_person(): array{
    $errors = [];
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    // validate input
    $name = trim($_POST['crName'] ?? '');
    $surname = trim($_POST['crSurname'] ?? '');
    $email = trim($_POST['crEmail'] ?? '');

    if (strlen($name) < 2 || strlen($name) > 50) {
        $errors[] = "Der Name muss 2-50 Zeichen lang sein.";
    }
    if (strlen($surname) < 2 || strlen($surname) > 50) {
        $errors[] = "Der Nachname muss 2-50 Zeichen lang sein.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Bitte eine gültige E-Mail-Adresse angeben.";
    }

    // SQL
    if (empty($errors)) {
        try{
            create_person($name, $surname, $email);
            // redirect with success message
            header("Location: createPage.php?success=1");
            exit();
        }catch(PDOException $e){
            writeLog('DB-Error: ' . $e->getMessage());
            $errors[] = "Datenbankfehler: " . $e->getMessage(); 
        
        }
    }
    }
    return $errors;

}


?>