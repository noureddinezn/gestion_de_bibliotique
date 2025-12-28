<?php
requireAdmin();

require_once __DIR__ . '/../config/connection.php';
require_once __DIR__ . '/../models/Book.php';
require_once __DIR__ . '/../functions.php';

$url = $_GET['url'] ?? '';

if ($url === 'add_book' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = clean($_POST['title']);
    $author = clean($_POST['author']);
    $year = intval($_POST['year']);
    
    $book = new Book($pdo);
    $book->setTitle($title);
    $book->setAuthor($author);
    $book->setYear($year);
    
    if ($book->create()) {
        setMessage("Livre ajouté avec succès");
    } else {
        setMessage("Erreur lors de l'ajout", "error");
    }
    redirect('admin');
}

elseif ($url === 'delete_book') {
    $bookId = $_GET['id'] ?? 0;
    
    if ($bookId) {
        $book = new Book($pdo);
        if ($book->findById($bookId)) {
            if ($book->delete()) {
                setMessage("Livre supprimé avec succès");
            } else {
                setMessage("Erreur lors de la suppression", "error");
            }
        }
    }
    redirect('admin');
}
?>