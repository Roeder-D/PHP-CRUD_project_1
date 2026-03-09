<?php 
require_once '../includes/escape.php';
require_once '../includes/auth.php';
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
        <a href="createPage.php" class="nav_link">create</a>
        <a href="updatePage.php" class="nav_link">update</a>
        <a href="#" class="nav_link">delete</a>
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