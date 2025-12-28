<?php
abstract class User {
    protected $id;
    protected $firstName;
    protected $lastName;
    protected $email;
    protected $password;
    protected $role;
    protected $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getId() { return $this->id; }
    public function getFirstName() { return $this->firstName; }
    public function getLastName() { return $this->lastName; }
    public function getEmail() { return $this->email; }
    public function getRole() { return $this->role; }
    public function getFullName() { return $this->firstName . ' ' . $this->lastName; }

    public function setFirstName($firstName) { $this->firstName = $firstName; }
    public function setLastName($lastName) { $this->lastName = $lastName; }
    public function setEmail($email) { $this->email = $email; }
    public function setPassword($password) { 
        $this->password = password_hash($password, PASSWORD_BCRYPT); 
    }

    public function save() {
        $sql = "INSERT INTO users (firstName, lastName, email, password, role) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$this->firstName, $this->lastName, $this->email, $this->password, $this->role]);
    }

    public function findByEmail($email) {
        $sql = "SELECT * FROM users WHERE email = ? LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$email]);
        $data = $stmt->fetch();

        if ($data) {
            $this->id = $data['id'];
            $this->firstName = $data['firstName'];
            $this->lastName = $data['lastName'];
            $this->email = $data['email'];
            $this->password = $data['password'];
            $this->role = $data['role'];
            return true;
        }
        return false;
    }

    public function verifyPassword($password) {
        return password_verify($password, $this->password);
    }

    abstract public function getPermissions();
}
?>