<?php
session_start();
require_once '../includes/db.php';

if (!isset($_SESSION['user_id'])) {
    echo "Please log in to save your curriculum.";
    exit();
}

$user_id = $_SESSION['user_id'];
$content = $_POST['content'];

$stmt = $conn->prepare("INSERT INTO curricula (user_id, content, created_at) VALUES (?, ?, NOW()) ON DUPLICATE KEY UPDATE content = ?, created_at = NOW()");
$stmt->bind_param("iss", $user_id, $content, $content);
$stmt->execute();
echo "Curriculum saved successfully!";
$stmt->close();
?>