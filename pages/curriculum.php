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
    <meta name="description" content="Create and download disaster management plans with DisasterPrep.">
    <meta name="keywords" content="curriculum, disaster plan, preparedness">
    <title>Curriculum - DisasterPrep</title>
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
        .curriculum-container { max-width: 800px; margin: 2rem auto; padding: 2rem; background: rgba(37, 70, 85, 0.95); border-radius: 0.75rem; box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3); }
    </style>
</head>
<body class="bg-gray-900 text-white">
    <section id="curriculum" class="hero">
        <div class="text-center max-w-5xl mx-auto px-6 py-20 z-10">
            <h1 class="text-6xl md:text-8xl font-extrabold animate-fade-in animate-bounce">Disaster Curriculum</h1>
            <div class="curriculum-container animate-slide-up">
                <p class="text-xl">Create or download your disaster management plan here. (Content to be expanded)</p>
                <!-- Add dynamic curriculum content or form here later -->
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