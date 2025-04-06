<?php
class Database {
    private $host = "localhost";
    private $username = "root";     // Default XAMPP username
    private $password = "";         // Default XAMPP password (empty)
    private $dbname = "disaster_db"; // Updated to match your database
    public $conn;

    public function __construct() {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->dbname);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function getConnection() {
        return $this->conn;
    }
}

$db = new Database();
$conn = $db->getConnection();
?>