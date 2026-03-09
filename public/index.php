<?php
require_once './includes/escape.php';
require_once './includes/db.php';
require_once './includes/login.php';
?>


<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>Login</title>
    <link rel="stylesheet" href="includes/style.css">
</head>
<body>


<h1>Login</h1>
<?php if ($error): ?>
    <div style="color:red"><?php echo e($error); ?></div>
<?php endif; ?>
<form method="post" action="">
    <input type="hidden" name="csrf_token" value="<?php echo e($_SESSION['csrf_token']); ?>">
    <label for="username">Username</label>
    <input id="username" type="text" name="username" required>

    <label for="password">Password</label>
    <input id="password" type="password" name="password" required>

    <button type="submit" style="margin-top:12px">Sign in</button>
</form>

</body>
</html>