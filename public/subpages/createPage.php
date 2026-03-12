<?php 
require_once __DIR__ . '/../includes/escape.php';
require_once __DIR__ . '/../includes/auth.php';
require_login();
require_permission(2);
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/create.php';
// handle form submission and get errors if any
$errors = process_add_person();
?>
<!--PRG target (start HTML)-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create User</title>
    <link rel="stylesheet" href="../includes/style.css">
</head>


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
    <h2>Create User</h2>
    <form action="#" method="POST">
        <label for="crName">name</label>
        <input type="text" name="crName" id="name" required>
        <label for="crSurname">surname</label>
        <input type="text" name="crSurname" id="surname" required>        
        <label for="crEmail">email</label>
        <input type="text" name="crEmail" id="email" required>
        <label for="crBirthdate">birthdate</label>
        <input type="date" name="crBirthdate" id="birthdate" required>
        <button type="submit">Create</button>
    </form>
</div>

<?php
echo '<div>';
// error display
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