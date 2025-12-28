<?php
require_once __DIR__ . '/../functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = clean($_POST['name'] ?? '');
    $email = clean($_POST['email'] ?? '');
    $message = clean($_POST['message'] ?? '');

    $errors = [];

    if (empty($name)) {
        $errors[] = "Le nom est requis";
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email invalide";
    }

    if (empty($message)) {
        $errors[] = "Le message est requis";
    }

    if (empty($errors)) {
        // Ici vous pouvez envoyer un email ou sauvegarder dans la DB
        // Exemple avec email:
        // $to = "contact@bibliotheque.ma";
        // $subject = "Nouveau message de contact";
        // $body = "Nom: $name\nEmail: $email\n\nMessage:\n$message";
        // $headers = "From: $email";
        // mail($to, $subject, $body, $headers);

        // Ou sauvegarder dans la base de données:
        // require_once __DIR__ . '/../config/connection.php';
        // $stmt = $pdo->prepare("INSERT INTO contacts (name, email, message, created_at) VALUES (?, ?, ?, NOW())");
        // $stmt->execute([$name, $email, $message]);

        setMessage("Message envoyé avec succès ! Nous vous répondrons bientôt.");
        redirect('contact');
    } else {
        setMessage(implode('<br>', $errors), "error");
    }
}

require __DIR__ . '/../views/contact.view.php';
?>