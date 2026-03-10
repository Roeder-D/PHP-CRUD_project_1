<?php
require_once __DIR__ . '/auth.php';

// Log out and redirect to login
logout_user();
header('Location: ../index.php');
exit;
