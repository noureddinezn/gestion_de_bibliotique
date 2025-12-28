<?php
require_once __DIR__ . '/../config/connection.php';
require_once __DIR__ . '/../models/Book.php';
require_once __DIR__ . '/../partials/header.php';
$book = new Book($pdo);
$books = $book->getAll();
?>