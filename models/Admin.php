<?php
require_once 'User.php';

class Admin extends User {
    
    public function __construct($pdo) {
        parent::__construct($pdo);
        $this->role = 'admin';
    }

    public function getPermissions() {
        return [
            'borrow_books' => false,
            'return_books' => false,
            'view_books' => true,
            'manage_books' => true,
            'manage_users' => true,
            'view_all_borrows' => true
        ];
    }

    public function getAllReaders() {
        $sql = "SELECT id, firstName, lastName, email FROM users WHERE role = 'reader'";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }

    public function getAllBorrows() {
        $sql = "SELECT b.*, u.firstName, u.lastName, bk.title, bk.author
                FROM borrows b
                JOIN users u ON b.readerId = u.id
                JOIN books bk ON b.bookId = bk.id
                ORDER BY b.borrowDate DESC";
        
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }

    public function getStats() {
        $stats = [];
        
        $stmt = $this->pdo->query("SELECT COUNT(*) as count FROM books");
        $stats['total_books'] = $stmt->fetch()['count'];
        
        $stmt = $this->pdo->query("SELECT COUNT(*) as count FROM books WHERE status = 'available'");
        $stats['available_books'] = $stmt->fetch()['count'];
        
        $stmt = $this->pdo->query("SELECT COUNT(*) as count FROM users WHERE role = 'reader'");
        $stats['total_readers'] = $stmt->fetch()['count'];
        
        $stmt = $this->pdo->query("SELECT COUNT(*) as count FROM borrows WHERE returnDate IS NULL");
        $stats['active_borrows'] = $stmt->fetch()['count'];
        
        return $stats;
    }
}
?>