<?php
function writeLog($message) {
    $logDir = __DIR__ . '/../private/logs';
    $logFile = $logDir . '/app.log';

    // Falls der Ordner nicht existiert, erstelle ihn
    if (!is_dir($logDir)) {
        mkdir($logDir, 0777, true);
    }
    
    $timestamp = date('Y-m-d H:i:s');
    $entry = "[$timestamp] $message" . PHP_EOL;

    file_put_contents($logFile, $entry, FILE_APPEND);
}