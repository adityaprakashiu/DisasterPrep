<?php
session_start();
require_once '../includes/db.php';

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } else {
        try {
            $stmt = $conn->prepare("SELECT id, name, password, is_admin FROM users WHERE email = ? LIMIT 1");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows === 1) {
                $user = $result->fetch_assoc();
                if (password_verify($password, $user['password'])) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['name'] = $user['name'];
                    $_SESSION['is_admin'] = $user['is_admin'];
                    $success = "Login successful! Redirecting to your dashboard...";
                    header("Refresh: 2; url=dashboard.php");
                    exit();
                } else {
                    $error = "Invalid email or password.";
                }
            } else {
                $error = "Invalid email or password.";
            }
            $stmt->close();
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
    <title>Login - DisasterPrep</title>
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
        header, footer { background-color: transparent; color: #fff; position: relative; z-index: 10; }
        header a, footer a { color: #0d6efd; }
        header a:hover, footer a:hover { color: #6610f2; }
        .hero { padding: 4rem 1rem; text-align: center; animation: fadeIn 1.5s ease-in-out; }
        .hero h1 { font-size: 3rem; font-weight: bold; color: #10b981; }
        .hero p { font-size: 1.25rem; color: #d1e0e6; }
        .form-container { background: rgba(37, 70, 85, 0.95); border: 2px solid #1e3a47; box-shadow: 0 6px 20px rgba(37, 70, 85, 0.4); backdrop-filter: blur(8px); padding: 4rem; border-radius: 0.75rem; max-width: 400px; width: 100%; transition: transform 0.3s ease, opacity 0.3s ease; }
        .form-container:hover { transform: translateY(-5px); opacity: 0.98; }
        .form-input { background: rgba(255, 255, 255, 0.1); border: 1px solid #a3c1cc; color: #e2e8f0; padding: 0.75rem 0.75rem 0.75rem 2.5rem; border-radius: 0.5rem; width: 100%; transition: all 0.3s ease; }
        .form-input::placeholder { color: #d1e0e6; opacity: 1; }
        .form-input:focus { background: rgba(255, 255, 255, 0.2); border-color: #10b981; outline: none; box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.4); }
        .input-icon { fill: #10b981; }
        .submit-btn { background: linear-gradient(to right, #254655, #1e3a47, #172a33); color: #fff; padding: 0.75rem; border-radius: 0.5rem; width: 100%; font-weight: bold; transition: all 0.3s ease; }
        .submit-btn:hover { background: linear-gradient(to right, #1e3a47, #172a33, #101c22); transform: translateY(-2px); }
        .error-message { color: #ffccd5; background: rgba(220, 38, 38, 0.2); padding: 0.75rem; border-radius: 0.5rem; text-align: center; margin-bottom: 1rem; }
        .success-message { color: #bbf7d0; background: rgba(34, 197, 94, 0.2); padding: 0.75rem; border-radius: 0.5rem; text-align: center; margin-bottom: 1rem; }
        footer { margin-top: auto; padding: 1rem; text-align: center; }
        footer a { margin: 0 0.5rem; color: #10b981; }
        footer a:hover { color: #059669; }
        @media (max-width: 640px) { .hero h1 { font-size: 2rem; } .hero p { font-size: 1rem; } .form-container { padding: 2rem; } .form-input, .submit-btn { padding: 0.5rem 0.5rem 0.5rem 2rem; font-size: 0.875rem; } .input-icon { width: 4.5rem; height: 4.5rem; } }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    </style>
</head>
<body>
    <?php include '../includes/header.php'; ?>

    <section class="hero">
        <div>
            <h1 class="text-4xl md:text-5xl font-extrabold mb-4">Login</h1>
            <p class="text-lg md:text-xl">Access your DisasterPrep account</p>
        </div>
    </section>

    <main class="flex-grow flex items-center justify-center px-4 py-8">
        <div class="form-container">
            <h2 class="text-2xl font-bold text-center mb-6 text-white">Login</h2>
            
            <?php if ($error): ?>
                <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
            <?php elseif ($success): ?>
                <div class="success-message"><?php echo htmlspecialchars($success); ?></div>
            <?php endif; ?>

            <form method="POST" class="space-y-4">
                <div class="relative">
                    <input type="email" name="email" placeholder="Your Email" class="form-input" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required>
                    <svg class="input-icon absolute top-1/2 left-3 transform -translate-y-1/2 w-6 h-6" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 14H4V6h16v12zM4 0h16v2H4V0zm0 20h16v2H4v-2zm6-10l8 5V7l-8 5z"/>
                    </svg>
                </div>
                <div class="relative">
                    <input type="password" name="password" placeholder="Password" class="form-input" required>
                    <svg class="input-icon absolute top-1/2 left-3 transform -translate-y-1/2 w-6 h-6" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path d="M12 2C9.243 2 7 4.243 7 7v2H6c-1.103 0-2 .897-2 2v8c0 1.103.897 2 2 2h12c1.103 0 2-.897 2-2v-8c0-1.103-.897-2-2-2h-1V7c0-2.757-2.243-5-5-5zm0 10V7c1.654 0 3 1.346 3 3v2h-6zm5 7c0 .551-.448 1-1 1H8c-.552 0-1-.449-1-1v-4c0-.551.448-1 1-1h8c.552 0 1 .449 1 1v4z"/>
                    </svg>
                </div>
                <div class="flex items-center justify-between text-sm">
                    <label class="flex items-center">
                        <input type="checkbox" name="remember" class="mr-2">
                        Remember Me
                    </label>
                    <a href="forgot-password.php" class="text-blue-400 hover:underline">Forgot Password?</a>
                </div>
                <button type="submit" class="submit-btn">Login</button>
            </form>

            <p class="mt-4 text-center text-gray-300">
                Don't have an account? <a href="signup.php" class="text-blue-400 hover:underline">Register here</a>
            </p>
        </div>
    </main>
    <?php include '../includes/footer.php'; ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const firstInput = document.querySelector('input');
            if (firstInput) firstInput.focus();
        });
    </script>
</body>
</html>