<?php
require_once __DIR__ . '/../functions.php';

$url = $_GET['url'] ?? '';

switch ($url) {
    case '':
    case 'home':
        require __DIR__ . '/../views/home.view.php';
        break;

    case 'about':
        require __DIR__ . '/../views/about.view.php';
        break;

    case 'contact':
        require __DIR__ . '/../views/contact.view.php';
        break;

    case 'login':
        require __DIR__ . '/../controllers/login.php';
        break;

    case 'signup':
        require __DIR__ . '/../controllers/signup.php';
        break;

    case 'profile':
        require __DIR__ . '/../views/profile.view.php';
        break;

    case 'admin':
        require __DIR__ . '/../views/admin.view.php';
        break;

    case 'borrow':
        require __DIR__ . '/../controllers/borrow.php';
        break;

    case 'add_book':
    case 'delete_book':
        require __DIR__ . '/../controllers/books.php';
        break;

    case 'logout':
        session_destroy();
        setMessage("Vous êtes déconnecté");
        redirect('login');
        break;

    default:
        require __DIR__ . '/../views/404.php';
        break;
}
?>