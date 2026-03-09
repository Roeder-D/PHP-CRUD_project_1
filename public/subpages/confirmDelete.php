<?php 
require_once '../includes/escape.php';
require_once '../includes/auth.php';
require_login();
require_permission(3);
require_once '../includes/db.php';
require_once '../includes/delete.php';
// Auslagern der Logik
$errors = process_delete_person();
?>
<!--PRG ZIEL (Beginn HTML)-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete User</title>
    <link rel="stylesheet" href="../includes/style.css">
</head>

<h2>Confirm Delete User</h2>
<div>
    <p>Are you sure you want to delete this user?</p>
    <form action="#" method="POST">
        <input type="hidden" name="delId" value="<?php echo e($_POST['delId'] ?? ''); ?>">
        <button type="submit" name="confirmDelete">Yes, Delete</button>
        <a href="deletePage.php"><button type="button">No, Cancel</button></a>
    </form>
</div>

<?php
echo '<div>';
// Ausgabe der Fehler
if (!empty($errors)) {
    echo '<div style="color: red; border: 1px solid red; padding: 10px;">';
    foreach ($errors as $error) {
        echo '<p>' . e($error) . '</p>';
    }
    echo '</div>';
    // $errors = [];
}

echo '</div>';
?>