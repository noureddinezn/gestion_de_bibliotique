<?php
require_once __DIR__ . '/../config/connection.php';
require_once __DIR__ . '/../models/Reader.php';
require_once __DIR__ . '/../models/Admin.php';
require_once __DIR__ . '/../functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = clean($_POST['email']);
    $password = $_POST['password'];
    
    $user = new Reader($pdo);
    if ($user->findByEmail($email) && $user->verifyPassword($password)) {
        if ($user->getRole() === 'admin') {
            $user = new Admin($pdo);
            $user->findByEmail($email);
        }
        $_SESSION['user_id'] = $user->getId();
        $_SESSION['user_name'] = $user->getFullName();
        $_SESSION['user_role'] = $user->getRole();
        setMessage("Bienvenue " . $user->getFirstName() . " !");
        redirect($user->getRole() === 'admin' ? 'admin' : '');
    } else {
        setMessage("Email ou mot de passe incorrect", "error");
    }
}

require __DIR__ . '/../views/login.view.php';
?>