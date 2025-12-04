<?php
require_once __DIR__ . '/database.php';

function logToDatabase($level, $message, $context = [])
{
    $pdo = db();

    $userId = $_SESSION['user_id'] ?? null;

    $stmt = $pdo->prepare("
        INSERT INTO logs (level, message, context, user_id, ip_address, created_at)
        VALUES (:level, :message, :context, :user_id, :ip, NOW())
    ");

    $stmt->execute([
        'level' => $level,
        'message' => $message,
        'context' => json_encode($context),
        'user_id' => $userId,
        'ip' => $_SERVER['REMOTE_ADDR'] ?? 'CLI'
    ]);
}

function logToFile($level, $message, $context = [])
{
    $logDir = __DIR__ . '/../logs';
    if (!is_dir($logDir)) mkdir($logDir, 0777, true);

    $logFile = $logDir . '/app.log';
    $userId = $_SESSION['user_id'] ?? null;
    $entry = "[" . date('Y-m-d H:i:s') . "] {$level}: {$message} " . json_encode($context) . " {$userId}" . PHP_EOL;
    file_put_contents($logFile, $entry, FILE_APPEND);
}

logToDatabase('info', 'Route Request', [
    'uri' => $_SERVER['REQUEST_URI'] ?? '',
    'method' => $_SERVER['REQUEST_METHOD'] ?? '',
    'get' => $_GET,
    'post' => $_POST
]);

logToFile('info', 'Route Request', [
    'uri' => $_SERVER['REQUEST_URI'] ?? '',
    'method' => $_SERVER['REQUEST_METHOD'] ?? '',
    'get' => $_GET,
    'post' => $_POST
]);
