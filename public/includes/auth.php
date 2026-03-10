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

// Login (Brute-Force protection, Session fixation prevention, CSRF protection)
function login_user(string $username, string $password): bool
{
    global $pdo;
    $pdo->query("DELETE FROM login_attempts WHERE last_attempt < NOW() - INTERVAL 1 DAY"); //clean old attempts
    $ip = $_SERVER['REMOTE_ADDR'];
    $limit = 5; //max attempts
    $lockoutTime = 1; //in minutes
    
    $stmt = $pdo->prepare('SELECT MAX(attempts) as max_attempts, MAX(last_attempt) as last_attempt FROM login_attempts WHERE ip_address = :ip OR username = :user');
    $stmt->execute([':ip'  => $ip, ':user' => $username]);
    $throttle = $stmt->fetch();

    if($throttle && $throttle['max_attempts'] >= $limit){
        $lastUpdate = new DateTime($throttle['last_attempt']);
        $diff = (time() - strtotime($throttle['last_attempt'])) / 60;
    
        if($diff < $lockoutTime){
            return false;
        }else{
        $pdo->prepare('DELETE FROM login_attempts WHERE ip_address = :ip OR username = :user')->execute([':ip' => $ip, ':user' => $username]);
        }
    }

    $stmt = $pdo->prepare('SELECT id, password_hash, permissions FROM permittedUsers WHERE username = :user LIMIT 1');
    $stmt->execute([':user' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    $password_hash = $user ? $user['password_hash'] : '$2y$10$abcdefghijklmnopqrstuv'; //user_hash or if doesn't exist dummy_hash 
    $validPW = password_verify($password, $password_hash); // prevent timing attacks (hide existence of user)

    //login
    if($user && $validPW){
        $pdo->prepare('DELETE FROM login_attempts WHERE ip_address = :ip OR username = :user')->execute([':ip' => $ip, ':user' => $username]);
        
        session_regenerate_id(true);
        $_SESSION['user_id'] = (int)$user['id'];
        $_SESSION['username'] = $username;
        $_SESSION['permissions_level'] = (int)$user['permissions'];
    
        return true;
    }

    // failed login
    $pdo->prepare('INSERT INTO login_attempts (ip_address, username, last_attempt,attempts) VALUES (:ip, :user, NOW(), 1) ON DUPLICATE KEY UPDATE  attempts = attempts +1, last_attempt = NOW()')->execute([':ip' => $ip, ':user' => $username]);

    return false;
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