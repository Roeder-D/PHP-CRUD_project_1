<?php

$envFile = __DIR__ . '/../../private/.env';

if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    
    foreach ($lines as $line) {
        $line = trim($line);
        
        // Skip empty lines and comments
        if (empty($line) || $line[0] === '#') {
            continue;
        }
        
        // Skip lines without '='
        if (strpos($line, '=') === false) {
            continue;
        }
        
        [$key, $value] = explode('=', $line, 2);
        
        $key = trim($key);
        $value = trim($value, " \t\n\r\0\x0B\"'");
        
        if (!empty($key)) {
            $_ENV[$key] = $value;
            putenv("$key=$value");
        }
    }
}

?>