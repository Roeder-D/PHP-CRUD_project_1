<?php

//get pepper from .env
$lines = file(__DIR__ .'/../../private/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
foreach ($lines as $line) {
    if (strpos(trim($line), '#') === 0) continue; // Skip comments
    list($name, $value) = explode('=', $line, 2);
    $_ENV[$name] = trim($value);
    putenv("$name=$value");
}

?>