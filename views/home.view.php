<?php
require_once __DIR__ . '/../config/connection.php';
require_once __DIR__ . '/../models/Book.php';
require_once __DIR__ . '/../partials/header.php';
$book = new Book($pdo);
$books = $book->getAll();
?>
div class="page-header">
    <h1>📚 Catalogue des Livres</h1>
    <p>Découvrez notre collection de livres disponibles</p>
</div>

<div class="books-grid">
    <?php foreach ($books as $b): ?>
        <div class="book-card">
            <div class="book-icon">📖</div>
            <h3><?php echo htmlspecialchars($b['title']); ?></h3>
            <p class="book-author">par <?php echo htmlspecialchars($b['author']); ?></p>
            <p class="book-year">📅 <?php echo $b['year']; ?></p>
            <div class="book-status">
                <?php if ($b['status'] === 'available'): ?>
                    <span class="badge badge-success">✓ Disponible</span>
                <?php else: ?>
                    <span class="badge badge-warning">📚 Emprunté</span>
                <?php endif; ?>
            </div>
            <?php if (isLoggedIn() && !isAdmin() && $b['status'] === 'available'): ?>
                <a href="/breif10/public/index.php?url=borrow&action=borrow&id=<?php echo $b['id']; ?>" 
                   class="btn btn-primary btn-block"
                   onclick="return confirm('Emprunter ce livre ?')">
                    Emprunter
                </a>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>
<?php require_once __DIR__ . '/../partials/footer.php'; ?>