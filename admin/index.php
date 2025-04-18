<?php
session_start();
include '../includes/header.php';

if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header("Location: pages/login.php");
    exit();
}

require_once '../includes/db.php';

// Example: Update quiz questions
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['question'])) {
    $question = $_POST['question'];
    $options = json_encode($_POST['options']);
    $answer = $_POST['answer'];
    $stmt = $conn->prepare("INSERT INTO quiz_questions (question, options, answer) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE question = ?, options = ?, answer = ?");
    $stmt->bind_param("sss", $question, $options, $answer, $question, $options, $answer);
    $stmt->execute();
    $stmt->close();
}
?>

<section id="admin" class="py-20 reveal">
    <div class="max-w-6xl mx-auto px-6">
        <h2 class="text-4xl md:text-5xl font-bold text-center mb-12 animate-slide-up">Admin Panel</h2>
        <div class="card bg-gray-800 p-6 rounded-lg shadow-lg animate-slide-up">
            <h3 class="text-2xl font-semibold text-green-400">Add Quiz Question</h3>
            <form method="POST" class="space-y-4 mt-4">
                <input type="text" name="question" placeholder="Question" class="w-full p-3 bg-white/95 border border-blue-200 rounded-lg" required>
                <input type="text" name="options[]" placeholder="Option 1" class="w-full p-3 bg-white/95 border border-blue-200 rounded-lg" required>
                <input type="text" name="options[]" placeholder="Option 2" class="w-full p-3 bg-white/95 border border-blue-200 rounded-lg" required>
                <input type="text" name="options[]" placeholder="Option 3" class="w-full p-3 bg-white/95 border border-blue-200 rounded-lg" required>
                <input type="text" name="options[]" placeholder="Option 4" class="w-full p-3 bg-white/95 border border-blue-200 rounded-lg" required>
                <input type="text" name="answer" placeholder="Correct Answer" class="w-full p-3 bg-white/95 border border-blue-200 rounded-lg" required>
                <button type="submit" class="w-full p-3 bg-green-600 hover:bg-green-700 text-white rounded-lg">Add Question</button>
            </form>
        </div>
    </div>
</section>

<?php include '../includes/footer.php'; ?>