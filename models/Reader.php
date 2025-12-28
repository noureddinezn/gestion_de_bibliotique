<?php
require_once 'User.php';

class Reader extends User {
    
    public function __construct($pdo) {
        parent::__construct($pdo);
        $this->role = 'reader';
    }

    public function getPermissions() {
        return [
            'borrow_books' => true,
            'return_books' => true,
            'view_books' => true,
            'manage_books' => false
        ];
    }

    public function getMyBorrows() {
        $sql = "SELECT b.*, bk.title, bk.author 
                FROM borrows b
                JOIN books bk ON b.bookId = bk.id
                WHERE b.readerId = ?
                ORDER BY b.borrowDate DESC";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$this->id]);
        return $stmt->fetchAll();
    }

    public function countActiveBorrows() {
        $sql = "SELECT COUNT(*) as count FROM borrows WHERE readerId = ? AND returnDate IS NULL";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$this->id]);
        return $stmt->fetch()['count'];
    }
}
?>