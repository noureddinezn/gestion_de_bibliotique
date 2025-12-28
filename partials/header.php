<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!function_exists('isLoggedIn')) {
    require_once __DIR__ . '/../functions.php';
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bibliothèque</title>
    <link rel="stylesheet" href="/breif10/public/css/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <a href="/breif10/public/index.php" class="logo">📚 Bibliothèque</a>
            <ul class="nav-links">
                <li><a href="/breif10/public/index.php">Accueil</a></li>
                <li><a href="/breif10/public/index.php?url=about">À propos</a></li>
                <li><a href="/breif10/public/index.php?url=contact">Contact</a></li>
                
                <?php if (isLoggedIn()): ?>
                    <?php if (isAdmin()): ?>
                        <li><a href="/breif10/public/index.php?url=admin">Dashboard Admin</a></li>
                    <?php else: ?>
                        <li><a href="/breif10/public/index.php?url=profile">Mon Profil</a></li>
                    <?php endif; ?>
                    
                    <li class="user-info">
                        👤 <?php echo htmlspecialchars($_SESSION['user_name']); ?>
                        <span class="badge"><?php echo isAdmin() ? 'Admin' : 'Lecteur'; ?></span>
                    </li>
                    <li><a href="/breif10/public/index.php?url=logout" class="btn-logout">Déconnexion</a></li>
                <?php else: ?>
                    <li><a href="/breif10/public/index.php?url=login">Connexion</a></li>
                    <li><a href="/breif10/public/index.php?url=signup" class="btn-primary">Inscription</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
    <main class="container">
        