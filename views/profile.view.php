<?php
requireLogin();
if (isAdmin()) redirect('');

require_once __DIR__ . '/../config/connection.php';
require_once __DIR__ . '/../partials/header.php';

$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$userData = $stmt->fetch();

$borrowsStmt = $pdo->prepare("
    SELECT b.*, bk.title, bk.author 
    FROM borrows b
    JOIN books bk ON b.bookId = bk.id
    WHERE b.readerId = ?
    ORDER BY b.borrowDate DESC
");
$borrowsStmt->execute([$_SESSION['user_id']]);
$borrows = $borrowsStmt->fetchAll();
?>

<div class="profile-header">
    <h1>👤 Mon Profil</h1>
    <p>Bienvenue, <?php echo htmlspecialchars($userData['firstName'] . ' ' . $userData['lastName']); ?></p>
</div>

<h2>Mes Emprunts</h2>
<?php if (empty($borrows)): ?>
    <div class="empty-state">
        <p>Vous n'avez pas encore emprunté de livres.</p>
        <a href="/breif10/public/index.php" class="btn btn-primary">Voir les livres</a>
    </div>
<?php else: ?>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Livre</th>
                    <th>Auteur</th>
                    <th>Date emprunt</th>
                    <th>Date retour</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($borrows as $borrow): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($borrow['title']); ?></td>
                        <td><?php echo htmlspecialchars($borrow['author']); ?></td>
                        <td><?php echo date('d/m/Y', strtotime($borrow['borrowDate'])); ?></td>
                        <td><?php echo $borrow['returnDate'] ? date('d/m/Y', strtotime($borrow['returnDate'])) : '-'; ?></td>
                        <td>
                            <?php if ($borrow['returnDate']): ?>
                                <span class="badge badge-info">Retourné</span>
                            <?php else: ?>
                                <span class="badge badge-warning">En cours</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if (!$borrow['returnDate']): ?>
                                <a href="/breif10/public/index.php?url=borrow&action=return&id=<?php echo $borrow['id']; ?>" 
                                   class="btn btn-success btn-sm"
                                   onclick="return confirm('Retourner ce livre ?')">
                                    Retourner
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>