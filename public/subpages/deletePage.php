<?php 
require_once __DIR__ . '/../includes/escape.php';
require_once __DIR__ . '/../includes/auth.php';
require_login();
require_permission(3);
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
    <h2>Delete User</h2>
    <form action="confirmDelete.php" method="POST">
        <label for="delId">ID</label>
        <input type="text" name="delId" id="name" required>
        <button type="submit">Delete</button>
    </form>
</div>


</body>
</html>