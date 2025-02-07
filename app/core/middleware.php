<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function requireLogin() {
    if (!isset($_SESSION['user'])) {
        header("Location: /Lash_reservation/public/login.php");
        exit;
    }
}

function requireAdmin() {
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
        header("Location: /Lash_reservation/public/index.php");
        exit;
    }
}
?>
