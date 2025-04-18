<?php
session_start();
if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    header("Location: ../pages/login.php");
    exit();
}
include '../includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $question = $_POST['question'];
    $option_a = $_POST['option_a'];
    $option_b = $_POST['option_b'];
    $option_c = $_POST['option_c'];
    $option_d = $_POST['option_d'];
    $correct_answer = $_POST['correct_answer'];

    $stmt = $conn->prepare("INSERT INTO quiz_questions (question, option_a, option_b, option_c, option_d, correct_answer) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $question, $option_a, $option_b, $option_c, $option_d, $correct_answer);

    if ($stmt->execute()) {
        $success = "Question added successfully!";
    } else {
        $error = "Failed to add question.";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Question - DisasterPrep</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background: linear-gradient(135deg, #2d3748, #1a202c); color: #e2e8f0; min-height: 100vh; }
        .admin-container { max-width: 600px; margin: 2rem auto; padding: 2rem; background: rgba(37, 70, 85, 0.95); border-radius: 0.75rem; box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3); }
    </style>
</head>
<body>
    <section class="py-20">
        <div class="admin-container">
            <h1 class="text-3xl font-bold mb-6">Add New Quiz Question</h1>
            <?php if (isset($error)) echo "<p class='text-red-400'>$error</p>"; ?>
            <?php if (isset($success)) echo "<p class='text-green-400'>$success</p>"; ?>
            <form method="POST" class="space-y-4">
                <input type="text" name="question" placeholder="Question" class="w-full p-2 rounded bg-gray-700 text-white" required>
                <input type="text" name="option_a" placeholder="Option A" class="w-full p-2 rounded bg-gray-700 text-white" required>
                <input type="text" name="option_b" placeholder="Option B" class="w-full p-2 rounded bg-gray-700 text-white" required>
                <input type="text" name="option_c" placeholder="Option C" class="w-full p-2 rounded bg-gray-700 text-white" required>
                <input type="text" name="option_d" placeholder="Option D" class="w-full p-2 rounded bg-gray-700 text-white" required>
                <input type="text" name="correct_answer" placeholder="Correct Answer (e.g., Option A)" class="w-full p-2 rounded bg-gray-700 text-white" required>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Submit Question</button>
            </form>
        </div>
    </section>
    <?php include '../includes/footer.php'; ?>
</body>
</html>