<?php
require_once __DIR__ . '/escape.php';
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/logger.php';

function delete_person($id){
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM person WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->rowCount() > 0;
}

function process_delete_person(): array{
    $errors = [];
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirmDelete']) && isset($_POST['delId'])){
    $id = trim($_POST['delId']);
    if (!filter_var($_POST['delId'], FILTER_VALIDATE_INT)) {
        $errors[] = "Die ID muss eine Ganzzahl sein.";
        }
    if (empty($errors)) {
        try{
            $wasDeleted = delete_person($id);

                if ($wasDeleted) {
                    header("Location: deletePage.php?success=1");
                    exit();
                } else {
                    // Wenn id nicht existiert
                    $errors[] = "No user found with ID: " . e($id);
                }
        }catch(PDOException $e){
            writeLog('DB-Error on delete: ' . $e->getMessage());
            $errors[] = "Datenbankfehler: " . $e->getMessage();
        }
    }}
    return $errors;
}


?>