<?php
class Book {
    private $id;
    private $title;
    private $author;
    private $year;
    private $status;
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getId() { return $this->id; }
    public function getTitle() { return $this->title; }
    public function getAuthor() { return $this->author; }
    public function getYear() { return $this->year; }
    public function getStatus() { return $this->status; }

    public function setTitle($title) { $this->title = $title; }
    public function setAuthor($author) { $this->author = $author; }
    public function setYear($year) { $this->year = $year; }

    public function create() {
        $sql = "INSERT INTO books (title, author, year) VALUES (?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$this->title, $this->author, $this->year]);
    }

    public function getAll() {
        $sql = "SELECT * FROM books ORDER BY title";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }

    public function findById($id) {
        $sql = "SELECT * FROM books WHERE id = ? LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        $data = $stmt->fetch();

        if ($data) {
            $this->id = $data['id'];
            $this->title = $data['title'];
            $this->author = $data['author'];
            $this->year = $data['year'];
            $this->status = $data['status'];
            return true;
        }
        return false;
    }

    public function update() {
        $sql = "UPDATE books SET title = ?, author = ?, year = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$this->title, $this->author, $this->year, $this->id]);
    }

    public function delete() {
        $sql = "DELETE FROM books WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$this->id]);
    }

    public function updateStatus($status) {
        $sql = "UPDATE books SET status = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$status, $this->id]);
    }

    public function isAvailable() {
        return $this->status === 'available';
    }
}
?>