<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $env = parse_ini_file('.env');
    $admin_user = $env['ADMIN_USER'];
    $admin_pass = $env['ADMIN_PASS'];

    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username === $admin_user && $password === $admin_pass) {
        $_SESSION['admin'] = $username;
        header('Location: dashboard.php');
        exit;
    } else {
        header('Location: index.php?error=1');
        exit;
    }
} else {
    header('Location: index.php');
    exit;
}
?>