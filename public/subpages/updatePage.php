<?php 
require_once __DIR__ . '/../includes/escape.php';
require_once __DIR__ . '/../includes/auth.php';
require_login();
require_permission(2);
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/update.php';
// Auslagern der Logik
$errors = process_update_person();
?>
<!--PRG ZIEL (Beginn HTML)-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title>
    <link rel="stylesheet" href="../includes/style.css">
</head>

<?php 
if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])){
    $stmt = $pdo->prepare("SELECT * FROM person WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    $person = $stmt->fetch(PDO::FETCH_ASSOC);
    if($person){
        $_POST['upId'] = $person['id'];
        $_POST['upName'] = $person['name'];
        $_POST['upSurname'] = $person['surname'];
        $_POST['upEmail'] = $person['email'];
    } else {
        echo '<div style="color: red;">User not found.</div>';
    }
}


?>


<body>
    <header>
    <nav class="nav">
        <a href="home.php" class="nav_link">home</a>
        <?php if(current_user_has(2)): ?>
        <a href="createPage.php" class="nav_link">create</a>
        <a href="updatePage.php" class="nav_link">update</a>
        <?php endif; ?>
        <?php if(current_user_has(3)): ?>
        <a href="deletePage.php" class="nav_link">delete</a>
        <a href="addUserPage.php" class="nav_link">add user</a>
        <?php endif; ?>
        <a href="../includes/logout.php" class="nav_link">logout</a>
    </nav>
</header>

<?php if (isset($_GET['success']) && empty($errors)): ?>
        <div class="alert alert-success">
            <strong>Success!</strong> User has been created successfully.
        </div>
    <?php endif; ?>

<div>
    <h2>Update User</h2>
    <form action="#" method="POST">
        <label for="upId">ID</label>
        <input type="text" name="upId" id="name" value="<?php if(isset($person['id'])){ echo e($person['id']); } ?>" <?php if(isset($person['id'])){ echo 'disabled';} else echo 'required' ;?>>
        <label for="upName">name</label>
        <input type="text" name="upName" id="name" value="<?php if(isset($person['name'])){ echo e($person['name']); } ?>" required>
        <label for="upSurname">surname</label>
        <input type="text" name="upSurname" id="surname" value="<?php if(isset($person['surname'])){ echo e($person['surname']); } ?>" required>        
        <label for="upEmail">email</label>
        <input type="text" name="upEmail" id="email" value="<?php if(isset($person['email'])){ echo e($person['email']); } ?>" required>
        <button type="submit">Update</button>
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
}

echo '</div>';
?>
</body>
</html>