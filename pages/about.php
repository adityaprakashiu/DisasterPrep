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
    <meta name="description" content="Learn about the CodeSergonS team behind DisasterPrep.">
    <meta name="keywords" content="about us, team, CodeSergonS, disaster preparedness">
    <title>About Us - DisasterPrep</title>
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
        .team-container:hover {
            transform: translateY(-5px);
            opacity: 0.98;
        }
        .team-member {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid #a3c1cc;
            border-radius: 0.5rem;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
        }
        .team-member:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateX(5px);
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @media (max-width: 640px) {
            .hero h1 { font-size: 2rem; }
            .team-container { padding: 1rem; }
            .team-member { padding: 1rem; }
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;800&display=swap" rel="stylesheet">
</head>
<body>
    <section class="hero">
        <div>
            <h1 class="text-4xl md:text-5xl font-extrabold mb-4">About Us</h1>
            <p class="team-subtitle">Meet the CodeSergonS Team</p>
        </div>
    </section>

    <main class="flex-grow px-4 py-8">
        <div class="team-container">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold mb-4">CodeSergonS</h2>
                <p class="text-lg text-gray-300">A dedicated team working to make disaster preparedness accessible to everyone.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="team-member">
                    <h3 class="text-xl font-bold mb-2">
                        <a href="https://www.linkedin.com/in/jatin-jay-singh-788088349/" target="_blank" class="text-white hover:text-gray-300 transition-colors">
                            Jatin Singh
                        </a>
                    </h3>
                </div>
                <div class="team-member">
                    <h3 class="text-xl font-bold mb-2">
                        <a href="https://www.linkedin.com/in/shresth-veer-singh-598830291/" target="_blank" class="text-white hover:text-gray-300 transition-colors">
                            ShresthVeer Singh
                        </a>
                    </h3>
                </div>
                <div class="team-member">
                    <h3 class="text-xl font-bold mb-2">
                        <a href="https://www.linkedin.com/in/adityaprakashiu/" target="_blank" class="text-white hover:text-gray-300 transition-colors">
                            Aditya Prakash
                        </a>
                    </h3>
                </div>
                <div class="team-member">
                    <h3 class="text-xl font-bold mb-2">
                        <a href="https://www.linkedin.com/in/utkarsh-raj-1a7aab297/" target="_blank" class="text-white hover:text-gray-300 transition-colors">
                            Utkarsh Raj
                        </a>
                    </h3>
                </div>
            </div>

            <div class="mt-8 text-center">
                <h3 class="text-2xl font-bold mb-4">Our Mission</h3>
                <p class="text-gray-300">We are committed to creating a safer world by providing accessible disaster preparedness resources and tools. Through innovative technology and user-friendly interfaces, we aim to empower communities to better prepare for and respond to disasters.</p>
            </div>
        </div>
    </main>

    <?php include '../includes/footer.php'; ?>
</body>
</html>