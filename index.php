<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'includes/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Prepare for disasters with DisasterPrep. Learn tips, take quizzes, and access resources for better readiness.">
    <meta name="keywords" content="disaster preparedness, emergency tips, quiz, resources, safety">
    <title>Home - DisasterPrep</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .hero { background: url('assets/images/disaster-prep-bg2.png') no-repeat center/cover fixed; background-color: rgb(39, 56, 88); min-height: 100vh; position: relative; display: flex; align-items: center; }
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
    </style>
</head>
<body class="bg-gray-900 text-white">
    <section id="home" class="hero">
        <svg class="hero-svg" viewBox="0 0 1440 150" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 75C240 25 480 125 720 75C960 25 1200 125 1440 75" fill="none"/>
        </svg>
        <div class="text-center max-w-5xl mx-auto px-6 py-20 z-10">
            <h1 class="text-6xl md:text-8xl font-extrabold animate-fade-in animate-bounce">Prepare. Survive. Thrive!</h1>
            <p class="mt-4 text-xl md:text-2xl text-gray-200 animate-slide-up" style="text-shadow: 1px 1px 5px rgba(0, 0, 0, 0.8);">Master disaster readiness with expert tools and knowledge.</p>
            <div class="mt-10 space-x-6 animate-slide-up" style="animation-delay: 0.3s;">
                <a href="pages/signup.php" class="inline-block bg-gradient-to-r from-green-600 to-blue-600 px-8 py-4 rounded-lg font-semibold text-lg btn-glow transition-all">Get Started</a>
                <a href="#tips" class="inline-block bg-transparent border-2 border-green-500 px-8 py-4 rounded-lg font-semibold text-lg hover:bg-green-500/20 btn-glow transition-all">Learn More</a>
            </div>
        </div>
    </section>

    <section id="tips" class="py-20 reveal">
        <div class="max-w-6xl mx-auto px-6">
            <h2 class="text-4xl md:text-5xl font-bold text-center mb-12 animate-slide-up">Disaster Preparedness Tips</h2>
            <div class="flex justify-center space-x-4 mb-8 flex-wrap">
                <button class="tab-btn px-4 py-2 rounded-lg font-semibold active" data-tab="general">General</button>
                <button class="tab-btn px-4 py-2 rounded-lg font-semibold" data-tab="flood">Flood</button>
                <button class="tab-btn px-4 py-2 rounded-lg font-semibold" data-tab="earthquake">Earthquake</button>
                <button class="tab-btn px-4 py-2 rounded-lg font-semibold" data-tab="wildfire">Wildfire</button>
            </div>
            <div id="general" class="tab-content active grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="card bg-gray-800 p-6 rounded-lg shadow-lg animate-slide-up" style="animation-delay: 0.1s;">
                    <h3 class="text-2xl font-semibold text-green-400">Build a Kit</h3>
                    <p class="mt-4">Stock water, food, flashlight, and first-aid supplies for 72+ hours.</p>
                </div>
                <div class="card bg-gray-800 p-6 rounded-lg shadow-lg animate-slide-up" style="animation-delay: 0.2s;">
                    <h3 class="text-2xl font-semibold text-green-400">Make a Plan</h3>
                    <p class="mt-4">Know evacuation routes and communication strategies.</p>
                </div>
                <div class="card bg-gray-800 p-6 rounded-lg shadow-lg animate-slide-up" style="animation-delay: 0.3s;">
                    <h3 class="text-2xl font-semibold text-green-400">Stay Informed</h3>
                    <p class="mt-4">Monitor alerts and local news for updates.</p>
                </div>
            </div>
            <div id="flood" class="tab-content grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="card bg-gray-800 p-6 rounded-lg shadow-lg animate-slide-up" style="animation-delay: 0.1s;">
                    <h3 class="text-2xl font-semibold text-green-400">Elevate Items</h3>
                    <p class="mt-4">Move valuables to higher ground to avoid water damage.</p>
                </div>
                <div class="card bg-gray-800 p-6 rounded-lg shadow-lg animate-slide-up" style="animation-delay: 0.2s;">
                    <h3 class="text-2xl font-semibold text-green-400">Avoid Floodwater</h3>
                    <p class="mt-4">6 inches of moving water can sweep you away—stay safe.</p>
                </div>
                <div class="card bg-gray-800 p-6 rounded-lg shadow-lg animate-slide-up" style="animation-delay: 0.3s;">
                    <h3 class="text-2xl font-semibold text-green-400">Sandbags</h3>
                    <p class="mt-4">Use them to divert water flow from your home.</p>
                </div>
            </div>
            <div id="earthquake" class="tab-content grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="card bg-gray-800 p-6 rounded-lg shadow-lg animate-slide-up" style="animation-delay: 0.1s;">
                    <h3 class="text-2xl font-semibold text-green-400">Drop, Cover, Hold</h3>
                    <p class="mt-4">Protect yourself under sturdy furniture during shaking.</p>
                </div>
                <div class="card bg-gray-800 p-6 rounded-lg shadow-lg animate-slide-up" style="animation-delay: 0.2s;">
                    <h3 class="text-2xl font-semibold text-green-400">Secure Heavy Items</h3>
                    <p class="mt-4">Bolt shelves and appliances to walls to prevent injury.</p>
                </div>
                <div class="card bg-gray-800 p-6 rounded-lg shadow-lg animate-slide-up" style="animation-delay: 0.3s;">
                    <h3 class="text-2xl font-semibold text-green-400">Avoid Windows</h3>
                    <p class="mt-4">Stay clear of glass to avoid shards during an quake.</p>
                </div>
            </div>
            <div id="wildfire" class="tab-content grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="card bg-gray-800 p-6 rounded-lg shadow-lg animate-slide-up" style="animation-delay: 0.1s;">
                    <h3 class="text-2xl font-semibold text-green-400">Clear Vegetation</h3>
                    <p class="mt-4">Remove dry brush within 30 feet of your home.</p>
                </div>
                <div class="card bg-gray-800 p-6 rounded-lg shadow-lg animate-slide-up" style="animation-delay: 0.2s;">
                    <h3 class="text-2xl font-semibold text-green-400">Fireproof Home</h3>
                    <p class="mt-4">Use fire-resistant materials for roofing and siding.</p>
                </div>
                <div class="card bg-gray-800 p-6 rounded-lg shadow-lg animate-slide-up" style="animation-delay: 0.3s;">
                    <h3 class="text-2xl font-semibold text-green-400">Evacuate Early</h3>
                    <p class="mt-4">Leave before flames are close—don't wait for orders.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="stats" class="py-20 bg-gray-800 reveal">
        <div class="max-w-6xl mx-auto px-6">
            <h2 class="text-4xl md:text-5xl font-bold text-center mb-12 animate-slide-up">Why It Matters</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                <div class="card animate-slide-up" style="animation-delay: 0.1s;">
                    <p class="text-5xl font-bold text-green-400">70%</p>
                    <p class="mt-2">of people aren't prepared (FEMA, 2023).</p>
                </div>
                <div class="card animate-slide-up" style="animation-delay: 0.2s;">
                    <p class="text-5xl font-bold text-green-400">500+</p>
                    <p class="mt-2">disasters strike globally each year.</p>
                </div>
                <div class="card animate-slide-up" style="animation-delay: 0.3s;">
                    <p class="text-5xl font-bold text-green-400">3 Days</p>
                    <p class="mt-2">minimum survival kit duration.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="survivor-stories" class="py-20 reveal">
        <div class="max-w-6xl mx-auto px-6">
            <h2 class="text-4xl md:text-5xl font-bold text-center mb-12 animate-slide-up">Survivor Stories</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="card bg-gray-800 p-6 rounded-lg shadow-lg animate-slide-up" style="animation-delay: 0.1s;">
                    <h3 class="text-2xl font-semibold text-green-400">Hurricane Survival</h3>
                    <p class="mt-4">"Thanks to DisasterPrep, our family had a plan when the hurricane hit. We evacuated early and had all our supplies ready."</p>
                </div>
                <div class="card bg-gray-800 p-6 rounded-lg shadow-lg animate-slide-up" style="animation-delay: 0.2s;">
                    <h3 class="text-2xl font-semibold text-green-400">Earthquake Preparedness</h3>
                    <p class="mt-4">"The earthquake caught us off guard, but our emergency kit and knowledge from DisasterPrep helped us stay safe until help arrived."</p>
                </div>
            </div>
        </div>
    </section>

    <section id="disaster-gallery" class="py-20 reveal">
        <div class="max-w-6xl mx-auto px-6">
            <div class="gallery-container relative overflow-hidden rounded-lg shadow-2xl" style="height: 600px;">
                <div class="gallery-slider flex transition-transform duration-1000 ease-in-out">
                    <div class="gallery-slide min-w-full">
                        <img src="assets/images/flood.jpg" alt="Flood damage to residential home" class="w-full h-full object-cover">
                        <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-70 p-4">
                            <h3 class="text-xl font-bold text-white">Flood Impact</h3>
                            <p class="text-gray-200">Severe flooding can cause extensive damage to homes and property, requiring proper preparation and safety measures.</p>
                        </div>
                    </div>
                    <div class="gallery-slide min-w-full">
                        <img src="assets/images/fire.jpg" alt="Disaster damage" class="w-full h-full object-cover">
                        <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-70 p-4">
                            <h3 class="text-xl font-bold text-white">Disaster Aftermath</h3>
                            <p class="text-gray-200">Understanding the impact of disasters helps in better preparation and response.</p>
                        </div>
                    </div>
                    <div class="gallery-slide min-w-full">
                        <img src="assets/images/drought.jpg" alt="Disaster scene" class="w-full h-full object-cover">
                        <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-70 p-4">
                            <h3 class="text-xl font-bold text-white">Emergency Response</h3>
                            <p class="text-gray-200">Quick and effective response is crucial in disaster situations.</p>
                        </div>
                    </div>
                    <div class="gallery-slide min-w-full">
                        <img src="assets/images/earthquake.jpg" alt="Disaster impact" class="w-full h-full object-cover">
                        <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-70 p-4">
                            <h3 class="text-xl font-bold text-white">Community Impact</h3>
                            <p class="text-gray-200">Disasters affect entire communities, highlighting the need for collective preparedness.</p>
                        </div>
                    </div>
                    <div class="gallery-slide min-w-full">
                        <img src="assets/images/flood2.jpg" alt="Disaster recovery" class="w-full h-full object-cover">
                        <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-70 p-4">
                            <h3 class="text-xl font-bold text-white">Recovery Efforts</h3>
                            <p class="text-gray-200">Recovery and rebuilding are essential parts of disaster management.</p>
                        </div>
                    </div>
                    <div class="gallery-slide min-w-full">
                        <img src="assets/images/tornado.jpg" alt="Disaster preparation" class="w-full h-full object-cover">
                        <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-70 p-4">
                            <h3 class="text-xl font-bold text-white">Preparation Matters</h3>
                            <p class="text-gray-200">Proper preparation can significantly reduce disaster impact.</p>
                        </div>
                    </div>
                    <div class="gallery-slide min-w-full">
                        <img src="assets/images/f2.jpg" alt="Disaster awareness" class="w-full h-full object-cover">
                        <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-70 p-4">
                            <h3 class="text-xl font-bold text-white">Awareness & Education</h3>
                            <p class="text-gray-200">Knowledge and awareness are key to disaster preparedness.</p>
                        </div>
                    </div>
                </div>
                <button class="gallery-nav prev absolute left-4 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full hover:bg-opacity-75 transition-all" aria-label="Previous slide">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button class="gallery-nav next absolute right-4 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full hover:bg-opacity-75 transition-all" aria-label="Next slide">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
                <div class="gallery-dots absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
                    <button class="dot w-3 h-3 rounded-full bg-white bg-opacity-50 hover:bg-opacity-100 transition-all" aria-label="Go to slide 1"></button>
                    <button class="dot w-3 h-3 rounded-full bg-white bg-opacity-50 hover:bg-opacity-100 transition-all" aria-label="Go to slide 2"></button>
                    <button class="dot w-3 h-3 rounded-full bg-white bg-opacity-50 hover:bg-opacity-100 transition-all" aria-label="Go to slide 3"></button>
                    <button class="dot w-3 h-3 rounded-full bg-white bg-opacity-50 hover:bg-opacity-100 transition-all" aria-label="Go to slide 4"></button>
                    <button class="dot w-3 h-3 rounded-full bg-white bg-opacity-50 hover:bg-opacity-100 transition-all" aria-label="Go to slide 5"></button>
                    <button class="dot w-3 h-3 rounded-full bg-white bg-opacity-50 hover:bg-opacity-100 transition-all" aria-label="Go to slide 6"></button>
                    <button class="dot w-3 h-3 rounded-full bg-white bg-opacity-50 hover:bg-opacity-100 transition-all" aria-label="Go to slide 7"></button>
                </div>
            </div>
        </div>
    </section>

    <section id="resources" class="py-20 reveal">
        <div class="max-w-6xl mx-auto px-6">
            <h2 class="text-4xl md:text-5xl font-bold text-center mb-12 animate-slide-up">Resources</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="card bg-gray-800 p-6 rounded-lg shadow-lg animate-slide-up" style="animation-delay: 0.1s;">
                    <h3 class="text-2xl font-semibold text-green-400">Emergency Checklist</h3>
                    <p class="mt-4">Download our free PDF to build your disaster kit.</p>
                    <div class="mt-4 flex space-x-4">
                        <button onclick="showPdfPreview()" class="flex items-center text-blue-400 hover:text-blue-300 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            Preview
                        </button>
                        <a href="assets/pdfs/DisasterPrep.pdf" download class="flex items-center text-green-400 hover:text-green-300 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            Download
                        </a>
                    </div>
                </div>
                <div class="card bg-gray-800 p-6 rounded-lg shadow-lg animate-slide-up" style="animation-delay: 0.2s;">
                    <h3 class="text-2xl font-semibold text-green-400">Red Cross</h3>
                    <p class="mt-4">Visit for expert disaster guidance and training.</p>
                    <div class="mt-4">
                        <a href="https://www.redcross.org" target="_blank" class="flex items-center text-red-400 hover:text-red-300 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                            </svg>
                            Visit Red Cross
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- PDF Preview Modal -->
    <div id="pdfPreviewModal" class="fixed inset-0 bg-black bg-opacity-75 hidden flex items-center justify-center z-50">
        <div class="bg-gray-800 rounded-lg p-6 max-w-4xl w-full mx-4 relative">
            <button onclick="closePdfPreview()" class="absolute top-4 right-4 text-white hover:text-gray-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <div class="mt-4">
                <iframe src="assets/pdfs/Guide.pdf" class="w-full h-[600px] rounded-lg" frameborder="0"></iframe>
            </div>
            <div class="mt-4 flex justify-between items-center">
                <a href="assets/pdfs/Guide.pdf" download class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Download PDF
                </a>
                <button onclick="closePdfPreview()" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg">
                    Close Preview
                </button>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>

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

        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
                document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
                btn.classList.add('active');
                document.getElementById(btn.dataset.tab).classList.add('active');
            });
        });

        document.querySelectorAll('.btn-glow').forEach(btn => {
            btn.addEventListener('mouseover', () => btn.classList.add('shadow-lg'));
            btn.addEventListener('mouseout', () => btn.classList.remove('shadow-lg'));
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
            const sections = document.querySelectorAll('section');
            const navLinks = document.querySelectorAll('header a[href^="#"]');
            let current = '';
            sections.forEach(section => {
                const sectionTop = section.offsetTop - 100;
                if (window.scrollY >= sectionTop) {
                    current = section.getAttribute('id');
                }
            });
            navLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href') === `#${current}`) {
                    link.classList.add('active');
                }
            });
            const backToTop = document.querySelector('.back-to-top');
            if (window.scrollY > 300) {
                backToTop.classList.add('visible');
            } else {
                backToTop.classList.remove('visible');
            }
        });

        // Gallery Slider
        document.addEventListener('DOMContentLoaded', function() {
            const slider = document.querySelector('.gallery-slider');
            const slides = document.querySelectorAll('.gallery-slide');
            const dots = document.querySelectorAll('.dot');
            const prevBtn = document.querySelector('.gallery-nav.prev');
            const nextBtn = document.querySelector('.gallery-nav.next');
            
            let currentSlide = 0;
            const slideCount = slides.length;
            
            // Set up auto-sliding with 2 second interval
            let slideInterval = setInterval(nextSlide, 2000);
            
            // Function to go to a specific slide
            function goToSlide(index) {
                if (index < 0) index = slideCount - 1;
                if (index >= slideCount) index = 0;
                
                currentSlide = index;
                slider.style.transform = `translateX(-${currentSlide * 100}%)`;
                
                // Update dots
                dots.forEach((dot, i) => {
                    if (i === currentSlide) {
                        dot.classList.add('bg-white');
                        dot.classList.remove('bg-opacity-50');
                    } else {
                        dot.classList.remove('bg-white');
                        dot.classList.add('bg-opacity-50');
                    }
                });
            }
            
            // Function to go to next slide
            function nextSlide() {
                goToSlide(currentSlide + 1);
            }
            
            // Function to go to previous slide
            function prevSlide() {
                goToSlide(currentSlide - 1);
            }
            
            // Event listeners for navigation buttons
            prevBtn.addEventListener('click', function() {
                clearInterval(slideInterval);
                prevSlide();
                slideInterval = setInterval(nextSlide, 2000);
            });
            
            nextBtn.addEventListener('click', function() {
                clearInterval(slideInterval);
                nextSlide();
                slideInterval = setInterval(nextSlide, 2000);
            });
            
            // Event listeners for dots
            dots.forEach((dot, index) => {
                dot.addEventListener('click', function() {
                    clearInterval(slideInterval);
                    goToSlide(index);
                    slideInterval = setInterval(nextSlide, 2000);
                });
            });
            
            // Initialize the first dot as active
            dots[0].classList.add('bg-white');
            dots[0].classList.remove('bg-opacity-50');
            
            // Pause auto-sliding when hovering over the gallery
            const galleryContainer = document.querySelector('.gallery-container');
            galleryContainer.addEventListener('mouseenter', function() {
                clearInterval(slideInterval);
            });
            
            galleryContainer.addEventListener('mouseleave', function() {
                slideInterval = setInterval(nextSlide, 2000);
            });
        });

        // PDF Preview Functions
        function showPdfPreview() {
            document.getElementById('pdfPreviewModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closePdfPreview() {
            document.getElementById('pdfPreviewModal').classList.add('hidden');
            document.body.style.overflow = '';
        }

        // Close modal when clicking outside
        document.getElementById('pdfPreviewModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closePdfPreview();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closePdfPreview();
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