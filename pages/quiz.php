<?php
   session_start();
   include '../includes/header.php';
   require_once '../includes/db.php';

   // Check if user is logged in
   if (!isset($_SESSION['user_id'])) {
       $_SESSION['error'] = 'Please log in to take the quiz.';
       header('Location: ../login.php');
       exit();
   }

   // Fetch all questions
   $questions = [];
   $result = $conn->query("SELECT * FROM quiz_questions ORDER BY id");
   if ($result && $result->num_rows > 0) {
       while ($row = $result->fetch_assoc()) {
           $questions[] = [
               'q' => $row['question'],
               'options' => [$row['option_a'], $row['option_b'], $row['option_c'], $row['option_d']],
               'answer' => $row['correct_answer']
           ];
       }
   }

   // Handle quiz completion
   if (isset($_POST['final_score'])) {
       $user_id = $_SESSION['user_id'];
       $score = (int)$_POST['final_score'];
       $stmt = $conn->prepare("INSERT INTO quiz_results (user_id, score, date_taken) VALUES (?, ?, NOW())");
       $stmt->bind_param('ii', $user_id, $score);
       $stmt->execute();
       $stmt->close();
       header('Location: quiz.php');
       exit();
   }
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
               url('../assets/images/disaster-prep-bg2.png') no-repeat center/cover;
               background-color: #4a5568;
               min-height: 100vh;
               display: flex;
               flex-direction: column;
           }
           .quiz-hero { height: 200px; position: relative; }
           .quiz-container { background: rgba(37, 70, 85, 0.95); border: 2px solid #1e3a47; box-shadow: 0 6px 20px rgba(37, 70, 85, 0.4); backdrop-filter: blur(8px); }
           .option-btn { background: rgba(255, 255, 255, 0.1); border: 1px solid #a3c1cc; transition: all 0.3s ease; }
           .option-btn:hover { background: rgba(255, 255, 255, 0.2); transform: translateY(-2px); }
           .option-btn.selected { background: rgba(46, 204, 113, 0.3); border-color: #2ecc71; }
           .next-btn, .prev-btn { background: linear-gradient(to right, #254655, #1e3a47, #172a33); }
           .next-btn:hover, .prev-btn:hover { background: linear-gradient(to right, #1e3a47, #172a33, #101c22); }
           .progress-bar { background: rgba(255, 255, 255, 0.1); }
           .progress-fill { background: linear-gradient(to right, #365314, #334155); }
           .back-to-top { position: fixed; bottom: 20px; right: 20px; background: #10b981; color: white; width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; opacity: 0; transition: opacity 0.3s; }
           .back-to-top.visible { opacity: 1; }
       </style>
   </head>
   <body class="text-white">
       <section class="quiz-hero w-full flex flex-col justify-center items-center text-center px-4">
           <h1 class="text-4xl font-extrabold">Disaster Preparedness Quiz</h1>
       </section>

       <div class="flex-grow flex items-center justify-center px-4 py-12">
           <div class="quiz-container p-8 rounded-lg w-full max-w-2xl">
               <h2 class="text-2xl font-bold text-center mb-6">🌍 Disaster Readiness Test</h2>
               
               <div id="quiz-container">
                   <div class="flex justify-between items-center mb-4">
                       <p id="question-number" class="text-sm text-gray-300">Question <span id="qnum">1</span>/<span id="total-questions">0</span></p>
                       <p id="score-display" class="text-sm text-gray-300">Score: <span id="score">0</span></p>
                   </div>
                   
                   <div class="progress-bar rounded-full h-2 mb-6">
                       <div id="progress" class="progress-fill h-2 rounded-full" style="width: 0%"></div>
                   </div>
                   
                   <h3 id="question" class="text-xl font-semibold mb-6"></h3>
                   
                   <div id="options" class="space-y-3"></div>
                   
                   <div class="flex justify-between mt-6">
                       <button id="prev-btn" class="prev-btn text-white font-bold py-3 px-6 rounded-lg transition-all duration-300 hidden">
                           Previous Question
                       </button>
                       <button id="next-btn" class="next-btn text-white font-bold py-3 px-6 rounded-lg transition-all duration-300">
                           Next Question
                       </button>
                   </div>
               </div>

               <div id="result-container" class="hidden text-center">
                   <h3 class="text-3xl font-bold mb-4">Quiz Completed!</h3>
                   <div class="text-5xl font-bold mb-6 text-yellow-300">Score: <span id="final-score">0</span>/15</div>
                   <p id="result-message" class="text-xl mb-8"></p>
                   <div class="flex justify-center space-x-4">
                       <button onclick="location.reload()" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg transition">
                           Retake Quiz
                       </button>
                       <a href="../index.php" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg transition">
                           Return Home
                       </a>
                   </div>
               </div>
           </div>
       </div>

       <?php include '../includes/footer.php'; ?>
       <button class="back-to-top" onclick="scrollToTop()" aria-label="Back to top">↑</button>

       <script>
           const questions = <?php echo json_encode($questions); ?>;
           let currentQuestion = 0;
           let score = 0;
           let selectedOption = null;
           const totalQuestions = questions.length;

           document.getElementById('total-questions').textContent = totalQuestions;

           function loadQuestion() {
               if (!questions.length) {
                   document.getElementById('quiz-container').innerHTML = '<p class="text-xl text-center">No questions available. Contact support.</p>';
                   return;
               }
               document.getElementById('qnum').textContent = currentQuestion + 1;
               document.getElementById('question').textContent = questions[currentQuestion].q;
               document.getElementById('score').textContent = score;
               const progressPercent = (currentQuestion / totalQuestions) * 100;
               document.getElementById('progress').style.width = `${progressPercent}%`;
               const optionsContainer = document.getElementById('options');
               optionsContainer.innerHTML = '';
               questions[currentQuestion].options.forEach(option => {
                   const button = document.createElement('button');
                   button.className = 'option-btn w-full text-left py-3 px-4 rounded-lg';
                   button.textContent = option;
                   button.onclick = function() {
                       document.querySelectorAll('.option-btn').forEach(btn => btn.classList.remove('selected'));
                       this.classList.add('selected');
                       selectedOption = option;
                   };
                   optionsContainer.appendChild(button);
               });
               document.getElementById('next-btn').textContent = currentQuestion === totalQuestions - 1 ? 'Finish Quiz' : 'Next Question';
               document.getElementById('prev-btn').classList.toggle('hidden', currentQuestion === 0);
           }

           function nextQuestion() {
               if (!selectedOption) {
                   alert('Please select an answer before continuing.');
                   return;
               }
               if (selectedOption === questions[currentQuestion].answer) score++;
               if (currentQuestion < totalQuestions - 1) {
                   currentQuestion++;
                   selectedOption = null;
                   loadQuestion();
               } else {
                   showResults();
               }
           }

           function prevQuestion() {
               if (currentQuestion > 0) {
                   currentQuestion--;
                   selectedOption = null;
                   loadQuestion();
               }
           }

           function showResults() {
               document.getElementById('quiz-container').style.display = 'none';
               document.getElementById('result-container').classList.remove('hidden');
               document.getElementById('final-score').textContent = score;
               const percentage = (score / totalQuestions) * 100;
               const messages = ['Needs Improvement. Please explore our resources.', 'Good Start! Consider reviewing preparedness guides.', 'Well Prepared! You have strong disaster knowledge.', 'Emergency Expert! You\'re exceptionally prepared.'];
               document.getElementById('result-message').textContent = messages[Math.floor(percentage / 25)] || messages[0];
               fetch(window.location.href, {
                   method: 'POST',
                   headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                   body: 'final_score=' + score
               });
           }

           if (questions.length) {
               loadQuestion();
               document.getElementById('next-btn').addEventListener('click', nextQuestion);
               document.getElementById('prev-btn').addEventListener('click', prevQuestion);
           }

           function scrollToTop() { window.scrollTo({ top: 0, behavior: 'smooth' }); }
           window.addEventListener('scroll', () => {
               const backToTop = document.querySelector('.back-to-top');
               if (window.scrollY > 300) backToTop.classList.add('visible');
               else backToTop.classList.remove('visible');
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