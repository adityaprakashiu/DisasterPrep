<?php
session_start();
require_once '../includes/db.php';

if (!isset($_SESSION['user_id']) || !isset($_GET['user_id']) || $_SESSION['user_id'] != $_GET['user_id']) {
    echo json_encode([]);
    exit();
}

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT score, DATE_FORMAT(created_at, '%Y-%m-%d %H:%i') as created_at FROM quiz_results WHERE user_id = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$history = $result->fetch_all(MYSQLI_ASSOC);
echo json_encode($history);
$stmt->close();
?>