<?php
require_once __DIR__ . '/../helpers.php';
require_once __DIR__ . '/../models/user_model.php';

function auth_show_login()
{
    if (is_logged_in()) {
        redirect('/todos');
    }
    view('auth/login');
}

function auth_show_register()
{
    if (is_logged_in()) {
        redirect('/todos');
    }
    view('auth/register');
}

function auth_register()
{
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $password_confirm = $_POST['password_confirm'] ?? '';

    if ($password !== $password_confirm) {
        flash('error', 'Passwords do not match.');
        redirect('/register');
    }

    if ($name === '' || $email === '' || $password === '') {
        flash('error', 'All fields are required.');
        redirect('/register');
    }

    $result = user_create($name, $email, $password);

    if (!$result['success']) {
        flash('error', $result['error']);
        redirect('/register');
    }

    flash('success', 'Registration successful. Please login.');
    redirect('/login');
}

function auth_login()
{
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === '' || $password === '') {
        flash('error', 'Email & password are required.');
        redirect('/login');
    }

    $user = user_find_by_email($email);

    if (!$user || !password_verify($password, $user['password'])) {
        flash('error', 'Invalid credentials.');
        redirect('/login');
    }

    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_name'] = $user['name'];

    flash('success', 'Logged in successfully.');
    redirect('/todos');
}

function auth_logout()
{
    session_destroy();
    session_start();
    flash('success', 'Logged out successfully.');
    redirect('/login');
}
