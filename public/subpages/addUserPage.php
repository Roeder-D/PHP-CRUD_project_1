<?php
require_once '../includes/escape.php';
require_once '../includes/auth.php';
require_login();
require_permission(3);
require_once '../includes/db.php';
require_once '../includes/addUser.php';
// Auslagern der Logik
$errors = process_add_user();

require_once '../includes/header.php';
?>
<!--PRG ZIEL (Beginn HTML)-->
<body>
    <header>
    <nav class="nav">
        <a href="home.php" class="nav_link">home</a>
        <a href="createPage.php" class="nav_link">create</a>
        <a href="updatePage.php" class="nav_link">update</a>
        <a href="deletePage.php" class="nav_link">delete</a>
        <a href="../includes/logout.php" class="nav_link">logout</a>
    </nav>
</header>

<?php if (isset($_GET['success']) && empty($errors)): ?>
        <div class="alert alert-success">
            <strong>Success!</strong> User has been created successfully.
        </div>
    <?php endif; ?>

<div>
    <h2>Add User</h2>
        <form action="#" method="POST">
        <label for="username">name</label>
        <input type="text" name="username" id="name" required>
        <label for="password">password</label>
        <input type="password" name="password" id="password" required>
        <label for="permissions">permissions</label>
        <input type="text" name="permissions" id="permissions" required>
        <button type="submit">Add</button>
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