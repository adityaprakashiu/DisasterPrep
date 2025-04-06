<?php
session_start();
require_once 'includes/db.php';

// Initialize variables
$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $message = filter_var($_POST['message'], FILTER_SANITIZE_STRING);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format";
    } else {
        try {
            $stmt = $conn->prepare("INSERT INTO contact (name, email, message) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $name, $email, $message);
            if ($stmt->execute()) {
                $success = "Thank you for contacting us!";
                // Clear form fields after successful submission
                $_POST = array();
            } else {
                $error = "Failed to send message. Please try again.";
            }
        } catch (Exception $e) {
            $error = "Database error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - DisasterPrep</title>
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
        
        .contact-container {
            background: rgba(37, 70, 85, 0.95);
            border: 2px solid #1e3a47;
            box-shadow: 0 6px 20px rgba(37, 70, 85, 0.4);
            backdrop-filter: blur(8px);
        }
        
        .form-input {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid #a3c1cc;
            color: white;
            transition: all 0.3s ease;
        }
        
        .form-input::placeholder {
            color: #d1e0e6;
        }
        
        .form-input:focus {
            background: rgba(255, 255, 255, 0.2);
            border-color: #ffffff;
            outline: none;
            box-shadow: 0 0 0 3px rgba(37, 70, 85, 0.6);
        }
        
        .submit-btn {
            background: linear-gradient(to right, #254655, #1e3a47, #172a33);
            transition: all 0.3s ease;
        }
        
        .submit-btn:hover {
            background: linear-gradient(to right, #1e3a47, #172a33, #101c22);
            transform: translateY(-2px);
        }
    </style>
</head>
<body class="text-white">
    <?php 
    // Include header
    $headerFile = 'includes/header.php';
    if (file_exists($headerFile)) {
        include $headerFile;
    } else {
        echo "<p class='text-red-500 text-center'>Header file missing</p>";
    }
    ?>
    
    <!-- Hero Section -->
    <section class="w-full py-20 flex flex-col justify-center items-center text-center px-4">
        <h1 class="text-4xl font-extrabold">Contact Us</h1>
        <p class="mt-2 text-lg text-gray-300">Get in touch with our team</p>
    </section>

    <!-- Contact Form Section -->
    <main class="flex-grow flex items-center justify-center px-4 pb-12">
        <form method="POST" class="contact-container p-8 rounded-lg w-full max-w-md">
            <h2 class="text-2xl font-bold text-center mb-6">Send Us a Message</h2>
            
            <?php if ($error): ?>
                <div class="mb-4 p-3 bg-red-500/20 text-red-300 rounded-lg text-center">
                    <?php echo $error; ?>
                </div>
            <?php elseif ($success): ?>
                <div class="mb-4 p-3 bg-green-500/20 text-green-300 rounded-lg text-center">
                    <?php echo $success; ?>
                </div>
            <?php endif; ?>
            
            <div class="mb-4">
                <input type="text" name="name" placeholder="Your Name" 
                       class="form-input w-full p-3 rounded-lg" 
                       value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>" required>
            </div>
            
            <div class="mb-4">
                <input type="email" name="email" placeholder="Your Email" 
                       class="form-input w-full p-3 rounded-lg"
                       value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required>
            </div>
            
            <div class="mb-6">
                <textarea name="message" placeholder="Your Message" rows="4"
                          class="form-input w-full p-3 rounded-lg" required><?php 
                          echo htmlspecialchars($_POST['message'] ?? ''); ?></textarea>
            </div>
            
            <button type="submit" class="submit-btn w-full text-white font-bold py-3 rounded-lg">
                Send Message
            </button>
        </form>
    </main>

    

    <script>
        // Add any necessary JavaScript here
        document.addEventListener('DOMContentLoaded', function() {
            // Focus on first input field
            const firstInput = document.querySelector('input');
            if (firstInput) firstInput.focus();
        });
    </script>
</body>
</html>