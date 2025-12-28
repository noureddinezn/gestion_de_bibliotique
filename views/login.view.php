<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="auth-container">
    <div class="auth-card">
        <h1>Connexion</h1>
        <p class="subtitle">Connectez-vous à votre compte</p>
        <form method="POST" action="/breif10/public/index.php?url=login" class="form">
            <div class="form-group">
                <label>Email *</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group">
                <label>Mot de passe *</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Se connecter</button>
        </form>
        <p class="auth-link">
            Pas de compte ? <a href="/breif10/public/index.php?url=signup">S'inscrire</a>
        </p>
        <div class="demo-info">
            <p><strong>Compte Admin :</strong></p>
            <p>Email: admin@library.com</p>
            <p>Mot de passe: password</p>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>