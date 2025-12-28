<?php
require_once __DIR__ . '/../config/connection.php';
require_once __DIR__ . '/../models/Reader.php';
require_once __DIR__ . '/../functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = clean($_POST['firstName']);
    $lastName = clean($_POST['lastName']);
    $email = clean($_POST['email']);
    $password = $_POST['password'];
    $confirm = $_POST['confirmPassword'];
    
    if ($password === $confirm && strlen($password) >= 6) {
        $reader = new Reader($pdo);
        if (!$reader->findByEmail($email)) {
            $reader->setFirstName($firstName);
            $reader->setLastName($lastName);
            $reader->setEmail($email);
            $reader->setPassword($password);
            if ($reader->save()) {
                setMessage("Inscription réussie ! Connectez-vous maintenant");
                redirect('login');
            }
        } else {
            setMessage("Cet email est déjà utilisé", "error");
        }
    } else {
        setMessage("Les mots de passe ne correspondent pas ou sont trop courts (6 min)", "error");
    }
}

require __DIR__ . '/../views/signup.view.php';
?>