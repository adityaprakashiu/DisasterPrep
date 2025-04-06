<?php
session_start(); // Start session for future user features
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - DisasterPrep</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .gallery-img { transition: transform 0.3s ease, opacity 0.3s ease; }
        .gallery-img:hover { transform: scale(1.05); opacity: 0.9; }
        .hero { 
            background: linear-gradient(to bottom, rgba(28, 25, 23, 0.9), rgba(0, 0, 0, 0.3)), 
            url('assets/images/disaster-prep-bg2.png') no-repeat center/cover; 
            background-color: #4a5568; /* Gray fallback */
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 0;
        }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        .animate-fade-in { animation: fadeIn 1.5s ease-in-out; }
        
        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
            40% { transform: translateY(-30px); }
            60% { transform: translateY(-15px); }
        }
        .animate-bounce { animation: bounce 1s infinite; }

        /* Header and Footer Styles */
        header, footer {
            background-color: transparent;
            color: #fff;
            position: relative;
            z-index: 10;
        }
        header a, footer a {
            color: #0d6efd; /* Blue links */
        }
        header a:hover, footer a:hover {
            color: #6610f2; /* Indigo on hover */
        }

        /* Footer Text Styling */
        footer p {
            font-size: 1.25rem; /* Bigger text (equivalent to text-xl in Tailwind) */
            font-weight: 500; /* Slightly bolder (between normal and bold) */
        }

        /* Hero Text Styling with Increased Opacity */
        .hero h1 {
            background: linear-gradient(to right, #365314, #334155);
            -webkit-background-clip: text;
            background-clip: text;
            color: rgba(255, 255, 255, 0.9);
            text-shadow: 0 0 10px rgba(120, 134, 107, 0.3);
        }

        /* Remove scrolling and adjust layout */
        html, body {
            height: 100%;
            overflow: hidden;
            margin: 0;
            padding: 0;
        }
        body {
            position: relative;
            display: flex;
            flex-direction: column;
        }
    </style>
</head>
<body class="text-white">
    <?php
    // Debug: Check if header.php exists
    $headerFile = 'includes/header.php';
    if (file_exists($headerFile)) {
        include $headerFile;
    } else {
        echo "<p style='color:red;'>Error: includes/header.php not found in the current directory!</p>";
    }
    ?>

    <!-- Hero Section -->
    <section class="hero w-full h-screen flex items-center justify-center">
        <div class="text-center max-w-4xl mx-auto px-6">
            <h1 class="text-7xl md:text-8xl font-extrabold animate-fade-in animate-bounce">Prepare. Survive. Thrive!</h1>
            <p class="mt-4 text-lg md:text-xl text-gray-300 animate-fade-in delay-200">Empowering communities with tools and knowledge for disaster readiness.</p>
            <div class="mt-8 space-x-4 animate-fade-in delay-400">
                <a href="signup.php" class="inline-block bg-gradient-to-r from-green-700 to-blue-700 px-6 py-3 rounded-lg font-semibold hover:from-green-800 hover:to-blue-800 transition-all shadow-md hover:shadow-lg">Get Started</a>
                <a href="#combined-section" class="inline-block bg-transparent border border-green-700 px-6 py-3 rounded-lg font-semibold hover:bg-green-700/20 transition-all shadow-md hover:shadow-lg">Learn More</a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="w-full text-white p-4 mt-auto">
        <div class="max-w-6xl mx-auto text-center">
            <p>© 2025 DisasterPrep. All rights reserved.</p>
        </div>
    </footer>

    <script src="assets/js/script.js"></script>
    <script>
        // Mouse Event for Hero Buttons
        document.querySelectorAll('.hero a').forEach(btn => {
            btn.addEventListener('mouseover', () => btn.classList.add('shadow-lg'));
            btn.addEventListener('mouseout', () => btn.classList.remove('shadow-lg'));
        });
    </script>
</body>
</html>