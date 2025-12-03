<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function base_url($path = '')
{
    $config = require __DIR__ . '/config.php';
    $base = rtrim($config['app']['base_url'], '/');
    $path = ltrim($path, '/');
    return $base . ($path ? '/' . $path : '');
}

function flash($key, $message)
{
    $_SESSION['flash'][$key] = $message;
}

function get_flash($key)
{
    if (!isset($_SESSION['flash'][$key])) {
        return null;
    }
    $msg = $_SESSION['flash'][$key];
    unset($_SESSION['flash'][$key]);
    return $msg;
}

function current_user_id()
{
    return isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : null;
}

function is_logged_in()
{
    return current_user_id() !== null;
}

function require_auth()
{
    if (!is_logged_in()) {
        flash('error', 'Please login first.');
        redirect('/login');
        exit;
    }
}

function redirect($path)
{
    header('Location: ' . base_url($path));
    exit;
}

function view($template, $data = [])
{
    extract($data);
    $viewPath = __DIR__ . '/views/' . $template . '.php';
    include __DIR__ . '/views/layout.php';
}

function e($value)
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}
