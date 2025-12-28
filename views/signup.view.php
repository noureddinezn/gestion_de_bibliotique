<?php require_once __DIR__ . '/../partials/header.php'; ?>

<div class="auth-container">
    <div class="auth-card">
        <h1>Inscription</h1>
        <p class="subtitle">Créez votre compte pour emprunter des livres</p>
        <form method="POST" action="/breif10/public/index.php?url=signup" class="form">
            <div class="form-group">
                <label>Prénom *</label>
                <input type="text" name="firstName" required>
            </div>
            <div class="form-group">
                <label>Nom *</label>
                <input type="text" name="lastName" required>
            </div>
            <div class="form-group">
                <label>Email *</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group">
                <label>Mot de passe *</label>
                <input type="password" name="password" required>
                <small>Au moins 6 caractères</small>
            </div>
            <div class="form-group">
                <label>Confirmer mot de passe *</label>
                <input type="password" name="confirmPassword" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">S'inscrire</button>
        </form>
        <p class="auth-link">
            Déjà inscrit ? <a href="/breif10/public/index.php?url=login">Se connecter</a>
        </p>
    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>