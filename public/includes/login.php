<?php
require_once 'db.php';
require_once 'auth.php';



$error = '';
// CSRF token (Cross-Site Request Forgery)
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(24));
    }
    
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['csrf_token'] ?? '';
    if (!hash_equals($_SESSION['csrf_token'], $token)) {
        $error = 'Invalid request (CSRF)';
    } else {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        if ($username === '' || $password === '') {
            $error = 'Please provide username and password';
        } else {
            if (login_user($pdo, $username, $password)) {
                header('Location: subpages/home.php');
                exit;
            } else {
                $error = 'Invalid credentials';
            }
        }
    }
}
                
// bereits eingeloggt -> direkt weiterleiten
if (current_user_id()) {
header('Location: subpages/home.php');
exit;
}
?>
