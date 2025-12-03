<?php
require_once __DIR__ . '/app/helpers.php';
require_once __DIR__ . '/app/routes.php';
require_once __DIR__ . '/app/middlewares.php';
require_once __DIR__ . '/app/logger.php';

logToDatabase('info', 'Page requested', [
    'uri' => $_SERVER['REQUEST_URI'] ?? '',
    'method' => $_SERVER['REQUEST_METHOD'] ?? '',
    'get' => $_GET,
    'post' => $_POST
]);

logToFile('info', 'Page requested', [
    'uri' => $_SERVER['REQUEST_URI'] ?? '',
    'method' => $_SERVER['REQUEST_METHOD'] ?? '',
    'get' => $_GET,
    'post' => $_POST
]);


dispatch();
