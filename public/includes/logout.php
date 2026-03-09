<?php
require_once 'auth.php';

// Log out and redirect to login
logout_user();
header('Location: ../index.php');
exit;
