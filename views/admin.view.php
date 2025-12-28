<?php
requireAdmin();

require_once __DIR__ . '/../config/connection.php';
require_once __DIR__ . '/../models/Book.php';
require_once __DIR__ . '/../partials/header.php';

$book = new Book($pdo);
$books = $book->getAll();

$statsBooks = $pdo->query("SELECT COUNT(*) as count FROM books")->fetch()['count'];
$statsAvailable = $pdo->query("SELECT COUNT(*) as count FROM books WHERE status = 'available'")->fetch()['count'];
$statsReaders = $pdo->query("SELECT COUNT(*) as count FROM users WHERE role = 'reader'")->fetch()['count'];
$statsActive = $pdo->query("SELECT COUNT(*) as count FROM borrows WHERE returnDate IS NULL")->fetch()['count'];

$borrowsStmt = $pdo->query("
    SELECT b.*, u.firstName, u.lastName, bk.title, bk.author
    FROM borrows b
    JOIN users u ON b.readerId = u.id
    JOIN books bk ON b.bookId = bk.id
    ORDER BY b.borrowDate DESC
");
$allBorrows = $borrowsStmt->fetchAll();
?>

<div class="admin-header">
    <h1>⚙️ Dashboard Admin</h1>
    <p>Gestion de la bibliothèque</p>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <h3>📚 Total Livres</h3>
        <p class="stat-number"><?php echo $statsBooks; ?></p>
    </div>
    <div class="stat-card">
        <h3>✅ Disponibles</h3>
        <p class="stat-number"><?php echo $statsAvailable; ?></p>
    </div>
    <div class="stat-card">
        <h3>👥 Lecteurs</h3>
        <p class="stat-number"><?php echo $statsReaders; ?></p>
    </div>
    <div class="stat-card">
        <h3>📖 Emprunts actifs</h3>
        <p class="stat-number"><?php echo $statsActive; ?></p>
    </div>
</div>

<div class="admin-section">
    <h2>📚 Gestion des Livres</h2>
    <div class="form-card">
        <h3>Ajouter un nouveau livre</h3>
        <form method="POST" action="/breif10/public/index.php?url=add_book" class="form-inline">
            <input type="text" name="title" placeholder="Titre" required>
            <input type="text" name="author" placeholder="Auteur" required>
            <input type="number" name="year" placeholder="Année" min="1000" max="<?php echo date('Y'); ?>" required>
            <button type="submit" class="btn btn-primary">Ajouter</button>
        </form>
    </div>
    
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Auteur</th>
                    <th>Année</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($books as $b): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($b['title']); ?></td>
                        <td><?php echo htmlspecialchars($b['author']); ?></td>
                        <td><?php echo $b['year']; ?></td>
                        <td>
                            <?php if ($b['status'] === 'available'): ?>
                                <span class="badge badge-success">Disponible</span>
                            <?php else: ?>
                                <span class="badge badge-warning">Emprunté</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="/breif10/public/index.php?url=delete_book&id=<?php echo $b['id']; ?>" 
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Supprimer ce livre ?')">
                                🗑️ Supprimer
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="admin-section">
    <h2>📋 Tous les Emprunts</h2>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Lecteur</th>
                    <th>Livre</th>
                    <th>Date emprunt</th>
                    <th>Date retour</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($allBorrows as $borrow): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($borrow['firstName'] . ' ' . $borrow['lastName']); ?></td>
                        <td><?php echo htmlspecialchars($borrow['title']); ?></td>
                        <td><?php echo date('d/m/Y', strtotime($borrow['borrowDate'])); ?></td>
                        <td><?php echo $borrow['returnDate'] ? date('d/m/Y', strtotime($borrow['returnDate'])) : '-'; ?></td>
                        <td>
                            <?php if ($borrow['returnDate']): ?>
                                <span class="badge badge-info">Retourné</span>
                            <?php else: ?>
                                <span class="badge badge-warning">En cours</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>