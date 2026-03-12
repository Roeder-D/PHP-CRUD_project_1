<?php
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/logger.php';

function update_person($id, $name, $surname, $email){
    global $pdo;
    $stmt = $pdo->prepare("UPDATE person SET name = ?, surname = ?, email = ? WHERE id = ?");
    return $stmt->execute([$name, $surname, $email, $id]);
}

function process_update_person(): array{
    $errors = [];
  if($_SERVER['REQUEST_METHOD'] === 'POST'){
// validate input
    $id = trim($_POST['upId']);
    $name = trim($_POST['upName']?? '');    
    $surname = trim($_POST['upSurname']?? '');
    $email = trim($_POST['upEmail']?? '');
    
    if (!filter_var($_POST['upId'], FILTER_VALIDATE_INT)) {
        $errors[] = "Die ID muss eine Ganzzahl sein.";
    }
    if(strlen($name) < 2 || strlen($name) > 50) {
        $errors[] = "Der Name muss 2-50 Zeichen lang sein.";
    }
    if(strlen($surname) < 2 || strlen($surname) > 50) {
        $errors[] = "Der Nachname muss 2-50 Zeichen lang sein.";
    }
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Bitte eine gültige E-Mail-Adresse angeben.";
    }
    // SQL
    if (empty($errors)) {

    try{
        update_person($id, $name, $surname, $email);
        // redirect with success message
        header("Location: updatePage.php?success=1");
        exit();
    }catch(PDOException $e){
        writeLog('DB-Error: ' . $e->getMessage());
        $errors[] = "Datenbankfehler: " . $e->getMessage(); 
    }
    }}
 return $errors;

}
  

?>