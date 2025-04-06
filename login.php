<?php
session_start();
require_once 'includes/user.php';
$user = new User($conn);

$error = ''; // Initialize error variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    // Basic validation
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email address.";
    } elseif (empty($password)) {
        $error = "Please enter your password.";
    } else {
        if ($userData = $user->login($email, $password)) {
            $_SESSION['user'] = $userData;
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Invalid email or password.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - DisasterPrep</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: linear-gradient(to bottom, rgba(28, 25, 23, 0.9), rgba(0, 0, 0, 0.3)), 
            url('assets/images/disaster-prep-bg2.png') no-repeat center/cover;
            background-color: #4a5568;
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            height: 100vh;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        header, footer {
            background-color: transparent;
            color: #fff;
            position: relative;
            z-index: 10;
        }
        header a, footer a {
            color: #0d6efd;
        }
        header a:hover, footer a:hover {
            color: #6610f2;
        }

        footer p {
            font-size: 1.25rem;
            font-weight: 500;
        }

        .form-container {
            width: 400px;
            height: 450px;
            transition: transform 0.3s ease, opacity 0.3s ease;
            border-radius: 10px;
            overflow: hidden;
        }
        .form-container:hover {
            transform: translateY(-5px);
            opacity: 0.98;
        }

        /* Form Styling with more rounded inputs */
        .form-container {
            background: rgba(37, 70, 85, 0.95);
            border: 2px solid #1e3a47;
            box-shadow: 0 6px 20px rgba(37, 70, 85, 0.4);
            color: #ffffff;
            padding: 35px 35px 50px;
        }
        input {
            background: rgba(255, 255, 255, 0.95);
            border: 1px solid #a3c1cc;
            color: #1f2937;
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 8px; /* Increased from 4px to 8px for more rounded corners */
            font-size: 1rem;
            height: 50px;
            line-height: 1.5;
        }
        input::placeholder {
            color: #6b7280;
            opacity: 1;
            font-size: 1.1rem;
        }
        input:focus {
            border-color: #ffffff;
            box-shadow: 0 0 0 3px rgba(37, 70, 85, 0.6);
            outline: none; /* Removes default browser outline */
        }
        button {
            background: linear-gradient(to right, #254655, #1e3a47, #172a33);
            color: #ffffff;
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px; /* Made consistent with input radius */
            font-weight: 600;
            font-size: 1.1rem;
            height: 50px;
            margin-top: 20px;
        }
        button:hover:not(:disabled) {
            background: linear-gradient(to right, #1e3a47, #172a33, #101c22);
        }
        button:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
        .error-message {
            color: #ffccd5;
            text-align: center;
            margin-top: 20px;
        }
        .text-gray-400 {
            color: #d1e0e6;
            text-align: center;
            margin-top: 20px;
            padding-bottom: 10px;
        }
        .text-blue-400 {
            color: #ffffff;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body class="text-white">
    <?php
    // Include the header
    $headerFile = 'includes/header.php';
    if (file_exists($headerFile)) {
        include $headerFile;
    } else {
        echo "<p style='color:red;'>Error: includes/header.php not found in the current directory!</p>";
    }
    ?>

    <!-- Login Form with Adjusted Bottom Spacing -->
    <main class="flex-grow flex items-center justify-center p-8">
        <div class="form-container backdrop-blur-sm">
            <h2 class="text-2xl font-bold text-center mb-6">Login</h2>
            <form method="POST" class="space-y-6" id="loginForm">
                <div>
                    <label for="email" class="block text-base mb-2">Email</label>
                    <input type="email" name="email" id="email" placeholder="test@example.com" required>
                </div>
                <div>
                    <label for="password" class="block text-base mb-2">Password</label>
                    <input type="password" name="password" id="password" placeholder="********" required>
                </div>
                <button type="submit" class="w-full p-3 rounded font-semibold transition-all" id="loginButton">Login</button>
                <?php if (!empty($error)) echo "<p class='error-message animate-pulse'>$error</p>"; ?>
                <p class="text-gray-400">
                    Don't have an account? <a href="signup.php" class="text-blue-400">Sign up</a>
                </p>
            </form>
        </div>
    </main>

    <footer class="w-full text-white p-4 mt-auto">
        <div class="max-w-6xl mx-auto text-center">
            <p>© 2025 DisasterPrep. All rights reserved.</p>
        </div>
    </footer>

    <script>
        // Add loading state to button on form submission
        const form = document.getElementById('loginForm');
        const button = document.getElementById('loginButton');

        form.addEventListener('submit', function() {
            button.textContent = 'Logging In...';
            button.disabled = true;
        });
    </script>
</body>
</html>