<?php
requireLogin();
if (isAdmin()) redirect('');

require_once __DIR__ . '/../config/connection.php';
require_once __DIR__ . '/../functions.php';

$action = $_GET['action'] ?? '';

if ($action === 'borrow') {
    $bookId = $_GET['id'] ?? 0;
    
    $stmt = $pdo->prepare("SELECT status FROM books WHERE id = ?");
    $stmt->execute([$bookId]);
    $book = $stmt->fetch();
    
    if ($book && $book['status'] === 'available') {
        $stmt = $pdo->prepare("INSERT INTO borrows (readerId, bookId, borrowDate) VALUES (?, ?, NOW())");
        $stmt->execute([$_SESSION['user_id'], $bookId]);
        
        $stmt = $pdo->prepare("UPDATE books SET status = 'borrowed' WHERE id = ?");
        $stmt->execute([$bookId]);
        
        setMessage("Livre emprunté avec succès !");
    } else {
        setMessage("Ce livre n'est pas disponible", "error");
    }
}

elseif ($action === 'return') {
    $borrowId = $_GET['id'] ?? 0;
    
    $stmt = $pdo->prepare("SELECT bookId FROM borrows WHERE id = ?");
    $stmt->execute([$borrowId]);
    $borrow = $stmt->fetch();
    
    if ($borrow) {
        $stmt = $pdo->prepare("UPDATE borrows SET returnDate = NOW() WHERE id = ?");
        $stmt->execute([$borrowId]);
        
        $stmt = $pdo->prepare("UPDATE books SET status = 'available' WHERE id = ?");
        $stmt->execute([$borrow['bookId']]);
        
        setMessage("Livre retourné avec succès !");
    }
}

redirect('profile');
?>