<?php
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/loadPepper.php';

function addUser($name, $password, $permissions) {
    $peppered_password = hash_hmac('sha256', $password, $_ENV['APP_PEPPER']); //hash pw with pepper
    $passwordHash = password_hash($peppered_password, PASSWORD_DEFAULT);
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO permittedUsers (username, password_hash, permissions) VALUES (?, ?, ?)");
    return $stmt->execute([$name, $passwordHash, $permissions]);
}


function process_add_user(): array{
    //Validierung
    $errors = [];
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $permissions = $_POST['permissions'] ?? '';

    if (strlen($username) < 2 || strlen($username) > 50) {
        $errors[] = 'Username must be between 2 and 50 characters.';
    }
    if ($password === '') {
        $errors[] = 'Password is required.';
    }
    if ($permissions === '' || !ctype_digit((string)$permissions)) {
        $errors[] = 'Permissions must be a numeric level.';
    }

    if (!empty($errors)) {
        return ['errors' => $errors];
    }
    // SQL
    
    try {
        if (addUser($username, $password, (int)$permissions)) {
            header('Location: ?success=1');
            exit;
        }
        $errors[] = 'Failed to create user (database error).';
    } catch (PDOException $e) {
        $errors[] = 'Database error: ' . $e->getMessage();
    }
    }
    return $errors;
}

?>