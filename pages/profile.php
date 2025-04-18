<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include '../includes/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="View your DisasterPrep profile and quiz history.">
    <meta name="keywords" content="profile, disaster preparedness, quiz history">
    <title>Profile - DisasterPrep</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .hero { background: url('../assets/images/disaster-prep-bg2.png') no-repeat center/cover fixed; background-color: rgb(39, 56, 88); min-height: 100vh; position: relative; display: flex; align-items: center; }
        .hero-svg { position: absolute; bottom: 0; width: 100%; height: 150px; opacity: 0.4; animation: wave 10s infinite linear; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        @keyframes slideUp { from { transform: translateY(50px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
        @keyframes bounce { 0%, 20%, 50%, 80%, 100% { transform: translateY(0); } 40% { transform: translateY(-20px); } 60% { transform: translateY(-10px); } }
        .animate-fade-in { animation: fadeIn 1.5s ease-in-out; }
        .animate-slide-up { animation: slideUp 1s ease-in-out forwards; }
        .animate-bounce { animation: bounce 1.5s infinite; }
        .reveal { opacity: 0; transition: opacity 0.5s ease; }
        .reveal.visible { opacity: 1; }
        .sticky-nav { position: sticky; top: 0; z-index: 20; background: rgba(26, 32, 44, 0.95); backdrop-filter: blur(5px); box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3); width: 100%; }
        .sticky-nav a.active { color: #10b981; border-bottom: 2px solid #10b981; }
        .btn-glow:hover { box-shadow: 0 0 15px rgba(16, 185, 129, 0.5); }
        section:not(#home) { background: linear-gradient(135deg, #2d3748, #1a202c); color: #e2e8f0; position: relative; overflow: hidden; }
        section:not(#home)::before { content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(to bottom, rgba(16, 185, 129, 0.1), rgba(0, 0, 0, 0.2)); z-index: 0; }
        section:not(#home) > * { position: relative; z-index: 1; }
        .card { transition: transform 0.3s ease, box-shadow 0.3s ease; margin-bottom: 1.5rem; }
        .card:hover { transform: scale(1.05); box-shadow: 0 0 20px rgba(16, 185, 129, 0.3); }
        .tab-content { display: none; }
        .tab-content.active { display: block; }
        .tab-btn { transition: all 0.3s ease; }
        .tab-btn:hover, .tab-btn.active { background: #10b981; color: #fff; }
        .back-to-top { position: fixed; bottom: 20px; right: 20px; background: #10b981; color: #fff; padding: 0.5rem 1rem; border-radius: 50%; display: none; }
        .back-to-top.visible { display: block; }
        @media (max-width: 768px) { header nav { flex-direction: column; align-items: flex-start; } header ul { flex-direction: column; space-x-0; margin-top: 1rem; } header li { margin-bottom: 0.5rem; } h1 { margin-left: 0; } }
        .profile-container { max-width: 600px; margin: 2rem auto; padding: 2rem; background: rgba(37, 70, 85, 0.95); border-radius: 0.75rem; box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3); }
        .quiz-history { margin-top: 1.5rem; }
        .quiz-history ul { list-style: none; padding: 0; }
        .quiz-history li { padding: 0.75rem; background: rgba(45, 55, 72, 0.8); border-radius: 0.5rem; margin-bottom: 0.5rem; }
    </style>
</head>
<body class="bg-gray-900 text-white">
    <section id="profile" class="hero">
        <div class="text-center max-w-5xl mx-auto px-6 py-20 z-10">
            <h1 class="text-6xl md:text-8xl font-extrabold animate-fade-in animate-bounce">Your Profile</h1>
            <div class="profile-container animate-slide-up">
                <?php
                if (isset($_SESSION['user_id'])) {
                    require_once '../includes/db.php';
                    require_once '../includes/user.php';
                    $user = new User($conn);
                    $userData = $user->getUserById($_SESSION['user_id']);
                    if ($userData) {
                        echo "<p class='text-xl'><strong>Name:</strong> " . htmlspecialchars($userData['name']) . "</p>";
                        echo "<p class='text-xl'><strong>Email:</strong> " . htmlspecialchars($userData['email']) . "</p>";
                        echo "<p class='text-xl'><strong>Gender:</strong> " . htmlspecialchars($userData['gender']) . "</p>";
                        echo "<p class='text-xl'><strong>Date of Birth:</strong> " . htmlspecialchars($userData['dob']) . "</p>";

                        // Fetch quiz history
                        $stmt = $conn->prepare("SELECT score, date_taken FROM quiz_results WHERE user_id = ? ORDER BY date_taken DESC");
                        $stmt->bind_param('i', $_SESSION['user_id']);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $quizHistory = [];
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $quizHistory[] = $row;
                            }
                        }
                        $stmt->close();

                        // Display quiz history
                        if (!empty($quizHistory)) {
                            echo "<div class='quiz-history'>";
                            echo "<h2 class='text-2xl font-semibold mt-6 mb-4'>Quiz History</h2>";
                            echo "<ul>";
                            foreach ($quizHistory as $entry) {
                                echo "<li>";
                                echo "Score: " . htmlspecialchars($entry['score']) . "/15 - Date: " . htmlspecialchars($entry['date_taken']);
                                echo "</li>";
                            }
                            echo "</ul>";
                            echo "</div>";
                        } else {
                            echo "<p class='text-xl mt-6 text-gray-400'>No quiz scores yet. Take the quiz to see your history!</p>";
                        }
                    } else {
                        echo "<p class='text-red-400 text-xl'>User data not found.</p>";
                    }
                } else {
                    echo "<p class='text-red-400 text-xl'>Please log in to view your profile.</p>";
                }
                ?>
                <div class="mt-6 text-center">
                    <a href="quiz.php" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg transition btn-glow">Take Quiz Again</a>
                </div>
            </div>
        </div>
    </section>
    <?php include '../includes/footer.php'; ?>
    <button class="back-to-top" onclick="scrollToTop()" aria-label="Back to top">↑</button>
    <script>
        function scrollToTop() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
        window.addEventListener('scroll', () => {
            const backToTop = document.querySelector('.back-to-top');
            if (window.scrollY > 300) {
                backToTop.classList.add('visible');
            } else {
                backToTop.classList.remove('visible');
            }
        });
    </script>
</body>
</html>
<?php
if (isset($_SESSION['error'])) {
    echo '<p style="color: red; text-align: center;">' . htmlspecialchars($_SESSION['error']) . '</p>';
    unset($_SESSION['error']);
}
?>