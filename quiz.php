<?php
session_start();
require_once 'includes/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Disaster Awareness Quiz - DisasterPrep</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: linear-gradient(to bottom, rgba(28, 25, 23, 0.9), rgba(0, 0, 0, 0.3)), 
            url('assets/images/disaster-prep-bg2.png') no-repeat center/cover;
            background-color: #4a5568;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        /* Hero section with transparent background */
        .quiz-hero {
            background: transparent;
            height: 200px;
            position: relative;
        }
        
        /* Quiz container styling */
        .quiz-container {
            background: rgba(37, 70, 85, 0.95);
            border: 2px solid #1e3a47;
            box-shadow: 0 6px 20px rgba(37, 70, 85, 0.4);
            backdrop-filter: blur(8px);
        }
        
        /* Option buttons */
        .option-btn {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid #a3c1cc;
            transition: all 0.3s ease;
        }
        
        .option-btn:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }
        
        .option-btn.selected {
            background: rgba(46, 204, 113, 0.3);
            border-color: #2ecc71;
        }
        
        /* Next button gradient */
        .next-btn {
            background: linear-gradient(to right, #254655, #1e3a47, #172a33);
        }
        
        .next-btn:hover {
            background: linear-gradient(to right, #1e3a47, #172a33, #101c22);
        }
        
        /* Progress bar */
        .progress-bar {
            background: rgba(255, 255, 255, 0.1);
        }
        
        .progress-fill {
            background: linear-gradient(to right, #365314, #334155);
        }
    </style>
</head>
<body class="text-white">
    <!-- Imported Header -->
    <?php include 'includes/header.php'; ?>

    <!-- Hero Section -->
    <section class="quiz-hero w-full flex flex-col justify-center items-center text-center px-4">
        <h1 class="text-4xl font-extrabold">Disaster Preparedness Quiz</h1>
    </section>

    <!-- Quiz Section -->
    <div class="flex-grow flex items-center justify-center px-4 py-12">
        <div class="quiz-container p-8 rounded-lg w-full max-w-2xl">
            <h2 class="text-2xl font-bold text-center mb-6">🌍 Disaster Readiness Test</h2>
            
            <div id="quiz-container">
                <div class="flex justify-between items-center mb-4">
                    <p id="question-number" class="text-sm text-gray-300">Question <span id="qnum">1</span>/<span id="total-questions">15</span></p>
                    <p id="score-display" class="text-sm text-gray-300">Score: <span id="score">0</span></p>
                </div>
                
                <div class="progress-bar rounded-full h-2 mb-6">
                    <div id="progress" class="progress-fill h-2 rounded-full" style="width: 0%"></div>
                </div>
                
                <h3 id="question" class="text-xl font-semibold mb-6"></h3>
                
                <div id="options" class="space-y-3"></div>
                
                <button id="next-btn" class="next-btn w-full text-white font-bold py-3 rounded-lg mt-6 transition-all duration-300">
                    Next Question
                </button>
            </div>

            <div id="result-container" class="hidden text-center">
                <h3 class="text-3xl font-bold mb-4">Quiz Completed!</h3>
                <div class="text-5xl font-bold mb-6 text-yellow-300">Score: <span id="final-score">0</span>/15</div>
                <p id="result-message" class="text-xl mb-8"></p>
                <div class="flex justify-center space-x-4">
                    <button onclick="location.reload()" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg transition">
                        Retake Quiz
                    </button>
                    <a href="index.php" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg transition">
                        Return Home
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="w-full text-white p-4 mt-auto">
        <div class="max-w-6xl mx-auto text-center">
            <p>© 2025 DisasterPrep. All rights reserved.</p>
        </div>
    </footer>

    <script>
        const questions = [
            {
                q: "Which type of disaster is an earthquake?",
                options: ["Natural", "Man-made", "Both", "Neither"],
                answer: "Natural"
            },
            {
                q: "What is the safest action during an earthquake?",
                options: ["Run outside", "Stay near windows", "Drop, cover, and hold", "Stand in doorway"],
                answer: "Drop, cover, and hold"
            },
            {
                q: "Which scale measures earthquake magnitude?",
                options: ["Fujita", "Richter", "Beaufort", "Saffir-Simpson"],
                answer: "Richter"
            },
            {
                q: "What's the minimum water supply recommended per person for 3 days?",
                options: ["1 gallon", "3 gallons", "6 gallons", "10 gallons"],
                answer: "3 gallons"
            },
            {
                q: "Where is safest during a tornado?",
                options: ["Car", "Basement", "Under highway", "Top floor"],
                answer: "Basement"
            },
            {
                q: "How often should you test smoke alarms?",
                options: ["Monthly", "Yearly", "Every 5 years", "Never"],
                answer: "Monthly"
            },
            {
                q: "What should be in every emergency kit?",
                options: ["Flashlight", "Jewelry", "TV", "Perishable food"],
                answer: "Flashlight"
            },
            {
                q: "What's the '30-30 rule' for lightning safety?",
                options: [
                    "30 sec between flash-bang means 30 min danger",
                    "30 min warning before storms",
                    "30 ft safe distance from trees",
                    "30 mph wind speed limit"
                ],
                answer: "30 sec between flash-bang means 30 min danger"
            },
            {
                q: "What does CERT stand for?",
                options: [
                    "Community Emergency Response Team",
                    "Central Emergency Rescue Team",
                    "Critical Event Reaction Team",
                    "Crisis Evaluation and Response Team"
                ],
                answer: "Community Emergency Response Team"
            },
            {
                q: "During a hurricane, you should:",
                options: [
                    "Evacuate if ordered",
                    "Take photos outside",
                    "Open windows to equalize pressure",
                    "All of the above"
                ],
                answer: "Evacuate if ordered"
            },
            {
                q: "What color sky often precedes a tornado?",
                options: ["Green", "Red", "Blue", "Yellow"],
                answer: "Green"
            },
            {
                q: "The 'Safe Room' concept is primarily for:",
                options: ["Tornadoes", "Earthquakes", "Floods", "Wildfires"],
                answer: "Tornadoes"
            },
            {
                q: "What's the leading cause of death in hurricanes?",
                options: ["Wind", "Storm surge", "Tornadoes", "Lightning"],
                answer: "Storm surge"
            },
            {
                q: "When should you turn off utilities after an earthquake?",
                options: [
                    "Only if you smell gas",
                    "Immediately always",
                    "After 1 hour",
                    "Never turn them off"
                ],
                answer: "Only if you smell gas"
            },
            {
                q: "What's the recommended emergency food supply duration?",
                options: ["3 days", "1 week", "2 weeks", "1 month"],
                answer: "2 weeks"
            }
        ];

        let currentQuestion = 0;
        let score = 0;
        let selectedOption = null;
        const totalQuestions = questions.length;

        document.getElementById('total-questions').textContent = totalQuestions;

        function loadQuestion() {
            document.getElementById('qnum').textContent = currentQuestion + 1;
            document.getElementById('question').textContent = questions[currentQuestion].q;
            document.getElementById('score').textContent = score;
            
            // Update progress bar
            const progressPercent = ((currentQuestion) / totalQuestions) * 100;
            document.getElementById('progress').style.width = `${progressPercent}%`;
            
            const optionsContainer = document.getElementById('options');
            optionsContainer.innerHTML = '';
            
            questions[currentQuestion].options.forEach((option, index) => {
                const button = document.createElement('button');
                button.className = 'option-btn w-full text-left py-3 px-4 rounded-lg';
                button.textContent = option;
                button.onclick = function() {
                    document.querySelectorAll('.option-btn').forEach(btn => {
                        btn.classList.remove('selected');
                    });
                    this.classList.add('selected');
                    selectedOption = option;
                };
                optionsContainer.appendChild(button);
            });
            
            if (currentQuestion === totalQuestions - 1) {
                document.getElementById('next-btn').textContent = 'Finish Quiz';
            } else {
                document.getElementById('next-btn').textContent = 'Next Question';
            }
        }

        function nextQuestion() {
            if (!selectedOption && currentQuestion > 0) {
                alert("Please select an answer before continuing.");
                return;
            }
            
            if (selectedOption === questions[currentQuestion].answer) {
                score++;
                document.getElementById('score').textContent = score;
            }
            
            if (currentQuestion < totalQuestions - 1) {
                currentQuestion++;
                selectedOption = null;
                loadQuestion();
            } else {
                showResults();
            }
        }

        function showResults() {
            document.getElementById('quiz-container').style.display = 'none';
            document.getElementById('result-container').classList.remove('hidden');
            document.getElementById('final-score').textContent = score;
            
            let message = "";
            const percentage = (score / totalQuestions) * 100;
            
            if (percentage >= 90) {
                message = "Emergency Expert! You're exceptionally prepared.";
            } else if (percentage >= 70) {
                message = "Well Prepared! You have strong disaster knowledge.";
            } else if (percentage >= 50) {
                message = "Good Start! Consider reviewing preparedness guides.";
            } else {
                message = "Needs Improvement. Please explore our resources to learn more.";
            }
            
            document.getElementById('result-message').textContent = message;
        }

        // Initialize quiz
        loadQuestion();
        
        // Add event listener to next button
        document.getElementById('next-btn').addEventListener('click', nextQuestion);
    </script>
</body>
</html>