<?php
require_once __DIR__ . '/database.php';

function rateLimiter($maxRequests = 5, $windowSeconds = 60)
{
    $pdo = db();
    $ip = $_SERVER['REMOTE_ADDR'];
    $now = time();
    $windowStart = $now - $windowSeconds;

    $stmt = $pdo->prepare("SELECT request_count, UNIX_TIMESTAMP(window_start) as window_start_ts FROM rate_limit WHERE ip_address = :ip");
    $stmt->execute(['ip' => $ip]);
    $row = $stmt->fetch();

    if ($row) {
        $requestCount = (int)$row['request_count'];
        $lastWindow = (int)$row['window_start_ts'];

        if ($lastWindow < $windowStart) {
            $stmt = $pdo->prepare("UPDATE rate_limit SET request_count = 1, window_start = NOW() WHERE ip_address = :ip");
            $stmt->execute(['ip' => $ip]);
        } else {
            $requestCount++;
            if ($requestCount > $maxRequests) {
                $retryAfter = ($lastWindow + $windowSeconds) - $now;
                http_response_code(429);
                die("Error: Too many requests. Please try again after $retryAfter seconds.");
            }

            $stmt = $pdo->prepare("UPDATE rate_limit SET request_count = :count WHERE ip_address = :ip");
            $stmt->execute(['count' => $requestCount, 'ip' => $ip]);
        }
    } else {
        $stmt = $pdo->prepare("INSERT INTO rate_limit (ip_address, request_count, window_start) VALUES (:ip, 1, NOW())");
        $stmt->execute(['ip' => $ip]);
    }
}

rateLimiter(5, 60);
