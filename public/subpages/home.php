<?php
require_once __DIR__ . '/../includes/escape.php';
require_once __DIR__ . '/../includes/auth.php';
require_login();
require_once __DIR__ . '/../includes/db.php';

$errors = [];
require_once __DIR__ . '/../includes/create.php';
require_once __DIR__ . '/../includes/update.php';
require_once __DIR__ . '/../includes/delete.php';
require_once __DIR__ . '/../includes/pagination.php';


//PRG-Ziel
//Start von HTML
require __DIR__ . '/../includes/header.php';    
?>

<html>
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
<main>

<!-- Suchfunktion -->
<form method="GET" action="" style="margin-bottom: 20px;">
    <input type="text" name="search" placeholder="Search name or email..." 
           value="<?php echo e($search); ?>">
    <button type="submit">Search</button>
    <?php if($search): ?>
        <a href="home.php">Clear</a>
    <?php endif; ?>
</form>

<!-- Pagination Pfeile -->
<div class="pagination">
    <?php 
    // Helper to keep the search term in the links
    $searchQuery = $search ? "&search=" . urlencode($search) : ""; 
    ?>

    <?php if ($page > 1): ?>
        <a href="?page=<?php echo $page - 1 . $searchQuery; ?>">&laquo; Previous</a>
    <?php endif; ?>

    <span>Page <?php echo $page; ?> of <?php echo $totalPages; ?></span>

    <?php if ($page < $totalPages): ?>
        <a href="?page=<?php echo $page + 1 . $searchQuery; ?>">Next &raquo;</a>
    <?php endif; ?>
</div>

<!-- Pagination Ausgabe -->
<?php
echo '<div><table>';
echo '<tr> <td> ID </td> <td> Name </td> <td> Surname </td><td> Email </td>';
    if(current_user_has(2)){ echo '<td> Edit </td>';}
    if(current_user_has(3)){ echo '<td> Delete </td>';}
echo '</tr>';
while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    echo '<tr> <td> ' . e($row['id']) . '</td><td> ' . e($row['name']) .' </td><td> ' . e($row['surname']) . '</td><td> ' . e($row['email']??'') . ' </td>';
    if(current_user_has(2)){ echo '<td> <a class="table_link" href="updatePage.php?id=' . e($row['id']) . '">Edit</a> </td>';}
    if(current_user_has(3)){ echo '<td> <a class="table_link" href="confirmDelete.php?id=' . e($row['id']) . '">Delete</a> </td>';}
    echo '</tr>';
    }
    echo '</table></div>';
?>

<!-- Pagination Pfeile-->
<div class="pagination">
    <?php 
    // Helper to keep the search term in the links
    $searchQuery = $search ? "&search=" . urlencode($search) : ""; 
    ?>

    <?php if ($page > 1): ?>
        <a href="?page=<?php echo $page - 1 . $searchQuery; ?>">&laquo; Previous</a>
    <?php endif; ?>

    <span>Page <?php echo $page; ?> of <?php echo $totalPages; ?></span>

    <?php if ($page < $totalPages): ?>
        <a href="?page=<?php echo $page + 1 . $searchQuery; ?>">Next &raquo;</a>
    <?php endif; ?>
</div>

</main>
</body>
</html>