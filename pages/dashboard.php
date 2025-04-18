<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: /DisasterPrep/pages/login.php");
    exit();
}

include '../includes/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Your personal dashboard for disaster preparedness with DisasterPrep.">
    <meta name="keywords" content="disaster preparedness, emergency tips, quiz, resources, safety">
    <title>Dashboard - DisasterPrep</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: linear-gradient(to bottom, rgba(28, 25, 23, 0.9), rgba(0, 0, 0, 0.3)), url('../assets/images/disaster-prep-bg2.png') no-repeat center/cover;
            background-color: #4a5568;
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            min-height: 100vh;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            color: #e2e8f0;
        }
        .hero {
            padding: 4rem 1rem;
            text-align: center;
            animation: fadeIn 1.5s ease-in-out;
        }
        .team-subtitle {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            font-weight: 800;
            color: #10b981;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
            margin-top: 1rem;
            margin-bottom: 2rem;
        }
        .welcome-banner {
            background: rgba(16, 185, 129, 0.1);
            border-left: 4px solid #10b981;
            padding: 2rem;
            margin-bottom: 2rem;
            border-radius: 0.75rem;
            backdrop-filter: blur(5px);
            animation: fadeIn 1s ease-in-out;
            box-shadow: 0 4px 20px rgba(16, 185, 129, 0.2);
            transform: translateY(-10px);
            transition: transform 0.5s ease;
        }
        .welcome-banner:hover {
            transform: translateY(0);
        }
        .welcome-title {
            font-family: 'Playfair Display', serif;
            font-size: 3.5rem;
            font-weight: 800;
            background: linear-gradient(to right, #10b981, #3b82f6);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            margin-bottom: 1rem;
            animation: pulse 2s infinite;
        }
        .welcome-subtitle {
            font-size: 1.5rem;
            color: #d1e0e6;
            line-height: 1.6;
        }
        @keyframes pulse {
            0% { opacity: 0.9; }
            50% { opacity: 1; }
            100% { opacity: 0.9; }
        }
        .team-container {
            background: rgba(37, 70, 85, 0.95);
            border: 2px solid #1e3a47;
            box-shadow: 0 6px 20px rgba(37, 70, 85, 0.4);
            backdrop-filter: blur(8px);
            padding: 2rem;
            border-radius: 0.75rem;
            max-width: 1000px;
            width: 100%;
            margin: 2rem auto;
            transition: transform 0.3s ease, opacity 0.3s ease;
        }
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
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;800&display=swap" rel="stylesheet">
</head>
<body>
    <section id="home" class="hero">
        <svg class="hero-svg" viewBox="0 0 1440 150" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 75C240 25 480 125 720 75C960 25 1200 125 1440 75" fill="none"/>
        </svg>
        <div class="text-center max-w-5xl mx-auto px-6 py-20 z-10">
            <div class="welcome-banner">
                <h2 class="welcome-title">Welcome back, <?php echo htmlspecialchars($_SESSION['name'] ?? 'User'); ?>!</h2>
                <p class="welcome-subtitle">We're so glad to see you again. Your safety and preparedness are our top priorities.</p>
            </div>
            <h1 class="text-6xl md:text-8xl font-extrabold animate-fade-in animate-bounce">Prepare. Survive. Thrive!</h1>
            <p class="mt-4 text-xl md:text-2xl text-gray-200 animate-slide-up" style="text-shadow: 1px 1px 5px rgba(0, 0, 0, 0.8);">Master disaster readiness with expert tools and knowledge.</p>
        </div>
    </section>

    <section id="tips" class="py-20 reveal">
        <div class="max-w-6xl mx-auto px-6">
            <h2 class="text-4xl md:text-5xl font-bold text-center mb-12">Essential Tips</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="card bg-gray-800 p-6 rounded-lg shadow-lg">
                    <h3 class="text-2xl font-semibold text-green-400">Emergency Kit</h3>
                    <p class="mt-4">Prepare a basic disaster supplies kit and keep it readily accessible.</p>
                </div>
                <div class="card bg-gray-800 p-6 rounded-lg shadow-lg">
                    <h3 class="text-2xl font-semibold text-green-400">Communication Plan</h3>
                    <p class="mt-4">Establish and practice a family emergency communication plan.</p>
                </div>
                <div class="card bg-gray-800 p-6 rounded-lg shadow-lg">
                    <h3 class="text-2xl font-semibold text-green-400">Stay Informed</h3>
                    <p class="mt-4">Monitor local news and weather alerts for emergency updates.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="resources" class="py-20 reveal">
        <div class="max-w-6xl mx-auto px-6">
            <h2 class="text-4xl md:text-5xl font-bold text-center mb-12 animate-slide-up">Resources</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <a href="assets/pdfs/DisasterPrep.pdf" download class="card bg-gray-800 p-6 rounded-lg shadow-lg animate-slide-up" style="animation-delay: 0.1s;">
                    <h3 class="text-2xl font-semibold text-green-400">Emergency Checklist</h3>
                    <p class="mt-4">Download our free PDF to build your disaster kit.</p>
                </a>
                <a href="https://www.redcross.org" target="_blank" class="card bg-gray-800 p-6 rounded-lg shadow-lg animate-slide-up" style="animation-delay: 0.2s;">
                    <h3 class="text-2xl font-semibold text-green-400">Red Cross</h3>
                    <p class="mt-4">Visit for expert disaster guidance and training.</p>
                </a>
            </div>
        </div>
    </section>

    <?php include '../includes/footer.php'; ?>

    <button class="back-to-top" onclick="scrollToTop()" aria-label="Back to top">↑</button>

    <script>
        function scrollToTop() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({ behavior: 'smooth' });
            });
        });

        const reveals = document.querySelectorAll('.reveal');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, { threshold: 0.2 });
        reveals.forEach(reveal => observer.observe(reveal));

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