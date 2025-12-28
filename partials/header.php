<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!function_exists('isLoggedIn')) {
    require_once __DIR__ . '/../functions.php';
}