<?php
session_start();
require_once 'includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rating = filter_var($_POST['rating'], FILTER_SANITIZE_NUMBER_INT);
    $feedback = filter_var($_POST['feedback'], FILTER_SANITIZE_STRING);

    $stmt = $conn->prepare("INSERT INTO feedback (rating, feedback) VALUES (?, ?)");
    $stmt->bind_param("is", $rating, $feedback);
    if ($stmt->execute()) {
        $success = "Thank you for your feedback!";
    } else {
        $error = "Failed to submit feedback";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback - DisasterPrep</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">
    <?php include 'includes/header.php'; ?>
    <main class="flex-grow flex items-center justify-center p-4">
        <form method="POST" class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
            <h2 class="text-2xl font-bold text-center mb-6">Give Feedback</h2>
            <div class="mb-4">
                <label class="block mb-2">Rating (1-5):</label>
                <input type="number" name="rating" min="1" max="5" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            <div class="mb-6">
                <textarea name="feedback" placeholder="Your Feedback" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" rows="4" required></textarea>
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded hover:bg-blue-600 transition">Submit Feedback</button>
            <?php 
            if (isset($error)) echo "<p class='text-red-500 mt-4 text-center'>$error</p>";
            if (isset($success)) echo "<p class='text-green-500 mt-4 text-center'>$success</p>";
            ?>
        </form>
    </main>
    <?php include 'includes/footer.php'; ?>
</body>
</html>