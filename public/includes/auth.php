<?php
require_once 'db.php';
// secure = true in production (HTTPS)
session_set_cookie_params([
    'httponly' => true,
    'secure' => false,
    'samesite' => 'Lax'
]);
if(session_status() === PHP_SESSION_NONE) {
    session_start();
}

function login_user(string $username, string $password): bool
{
    global $pdo;
    $stmt = $pdo->prepare('SELECT id, password_hash, permissions FROM permittedUsers WHERE username = :user LIMIT 1');
    $stmt->execute([':user' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$user) {
        return false;
    }

    if (!password_verify($password, $user['password_hash'])) {
        return false;
    }

    session_regenerate_id(true);
    $_SESSION['user_id'] = (int)$user['id'];
    $_SESSION['username'] = $username;
    $_SESSION['permissions_level'] = (int)$user['permissions'];

    return true;
}

function logout_user(): void
{
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
    }
    session_destroy();
}

function current_user_id(): ?int
{
    return isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : null;
}

function current_user_permission_level(): ?int
{
    return isset($_SESSION['permissions_level']) ? (int)$_SESSION['permissions_level'] : null;
}

// Überprüfe Berechtigungen
function current_user_has($perm): bool
{
    $level = current_user_permission_level();
    if (is_null($level)) {
        return false;
    }
    if (is_int($perm) || (is_string($perm) && ctype_digit($perm))) {
        return $level >= (int)$perm;
    }
    return false;
}

function require_login(): void
{
    if (!current_user_id()) {
        header('Location: ../includes/login.php');
        exit;
    }
}

function require_permission($perm): void
{
    if (!current_user_has($perm)) {
        http_response_code(403);
        echo 'Forbidden';
        exit;
    }
}