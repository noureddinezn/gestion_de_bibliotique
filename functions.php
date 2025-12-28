<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function redirect($page) {
    header("Location: /breif10/public/index.php?url=" . $page);
    exit;
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function isAdmin() {
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
}

function getCurrentUserId() {
    return $_SESSION['user_id'] ?? null;
}

function requireLogin() {
    if (!isLoggedIn()) {
        redirect('login');
    }
}

function requireAdmin() {
    if (!isAdmin()) {
        redirect('');
    }
}

function clean($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

function flashMessage() {
    if (isset($_SESSION['message'])) {
        $type = $_SESSION['message_type'] ?? 'success';
        echo "<div class='alert alert-$type'>{$_SESSION['message']}</div>";
        unset($_SESSION['message'], $_SESSION['message_type']);
    }
}

function setMessage($msg, $type = 'success') {
    $_SESSION['message'] = $msg;
    $_SESSION['message_type'] = $type;
}
?>