<?php
class User {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function register($name, $email, $password, $gender, $dob) {
        $stmt = $this->conn->prepare("SELECT id FROM users WHERE email = ? LIMIT 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $stmt->close();
            return false;
        }
        $stmt->close();

        $stmt = $this->conn->prepare("INSERT INTO users (name, email, password, gender, dob, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
        $stmt->bind_param("sssss", $name, $email, $password, $gender, $dob);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    public function login($email, $password) {
        $stmt = $this->conn->prepare("SELECT id, password, is_admin FROM users WHERE email = ? LIMIT 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                return $user;
            }
        }
        $stmt->close();
        return false;
    }

    public function getUserById($user_id) {
        $stmt = $this->conn->prepare("SELECT id, name, email, gender, dob FROM users WHERE id = ? LIMIT 1");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();
        return $user;
    }
}