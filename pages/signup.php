<?php
session_start();
require_once '../includes/db.php';
require_once '../includes/user.php';
$user = new User($conn);

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $gender = isset($_POST['gender']) ? $_POST['gender'] : '';
    $dob = $_POST['dob'];

    if (empty($name) || !preg_match("/^[a-zA-Z\s]+$/", $name)) {
        $error = "Invalid input: Name should only contain letters and spaces";
    } elseif (!preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/", $email)) {
        $error = "Invalid input: Invalid email format";
    } elseif (empty($password) || strlen($password) < 6) {
        $error = "Invalid input: Password must be at least 6 characters";
    } elseif ($password !== $confirm_password) {
        $error = "Invalid input: Passwords do not match";
    } elseif (empty($gender) || !in_array($gender, ['male', 'female', 'other'])) {
        $error = "Invalid input: Please select a valid gender";
    } elseif (empty($dob) || !DateTime::createFromFormat('Y-m-d', $dob)) {
        $error = "Invalid input: Please enter a valid date of birth";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        if ($user->register($name, $email, $hashed_password, $gender, $dob)) {
            $success = "Registration successful! Redirecting...";
            echo '<div id="loading" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center z-50 hidden">
                    <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-blue-500"></div>
                  </div>';
            echo '<script>
                    document.getElementById("loading").classList.remove("hidden");
                    setTimeout(() => window.location.href = "login.php", 2000);
                  </script>';
            exit;
        } else {
            $error = "Registration failed. Email may already exist.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup - DisasterPrep</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: linear-gradient(to bottom, rgba(28, 25, 23, 0.9), rgba(0, 0, 0, 0.3)), url('../assets/images/disaster-prep-bg2.png') no-repeat center/cover;
            background-color: #4a5568;
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            min-height: 100vh; /* Changed from height to min-height for flexibility */
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
        }
        header {
            background-color: transparent;
            color: #fff;
            position: relative;
            z-index: 10;
            background: linear-gradient(to bottom, rgba(28, 25, 23, 0.9), rgba(0, 0, 0, 0.3));
        }
        header a { color: #0d6efd; }
        header a:hover { color: #6610f2; }
        .content-wrapper {
            flex: 1 0 auto; /* Ensures content pushes footer down */
        }
        .form-container { transition: transform 0.3s ease, opacity 0.3s ease; }
        .form-container:hover { transform: translateY(-5px); opacity: 0.98; }
        .form-container {
            background: rgba(37, 70, 85, 0.95);
            border: 2px solid #1e3a47;
            box-shadow: 0 6px 20px rgba(37, 70, 85, 0.4);
            color: #ffffff;
        }
        input, select { background: rgba(255, 255, 255, 0.95); border-color: #a3c1cc; color: #1f2937; padding: 0.75rem; }
        input[type="date"], select { color: #1f2937; -webkit-appearance: none; appearance: none; padding: 0.75rem; }
        input[type="date"]::-webkit-calendar-picker-indicator { filter: invert(0.2); }
        input::placeholder, select:invalid { color: #6b7280; opacity: 1; }
        select:invalid { color: #6b7280; }
        select option { color: #1f2937; background: #ffffff; }
        select option:checked { color: #1f2937; background: #e0f2fe; }
        select option[value=""][disabled] { display: none; }
        input:focus, select:focus { border-color: #ffffff; box-shadow: 0 0 0 3px rgba(37, 70, 85, 0.6); color: #1f2937; }
        button { background: linear-gradient(to right, #254655, #1e3a47, #172a33); color: #ffffff; }
        button:hover { background: linear-gradient(to right, #1e3a47, #172a33, #101c22); }
        .error-message { color: #ffccd5; }
        .success-message { color: #ccffcc; }
        .text-gray-400 { color: #d1e0e6; }
        .text-blue-400 { color: #ffffff; }
        @media (max-width: 640px) { .form-container { padding: 1rem; width: 90%; } input, select, button { font-size: 0.875rem; padding: 0.5rem; } h2 { font-size: 1.5rem; } }
    </style>
</head>
<body class="text-white">
    <?php include '../includes/header.php'; ?>

    <div class="content-wrapper">
        <main class="flex-grow flex items-center justify-center p-6">
            <div class="form-container backdrop-blur-sm p-8 rounded-xl shadow-2xl w-full max-w-lg border">
                <h2 class="text-3xl font-extrabold text-center mb-6 bg-gradient-to-r from-white to-blue-200 bg-clip-text text-transparent">Create Account</h2>
                <form method="POST" class="space-y-6">
                    <div>
                        <input type="text" name="name" placeholder="Full Name" class="w-full p-3 bg-white/95 border border-blue-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-white transition-all" value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>" required>
                    </div>
                    <div>
                        <input type="email" name="email" placeholder="Email" class="w-full p-3 bg-white/95 border border-blue-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-white transition-all" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required>
                    </div>
                    <div>
                        <input type="password" name="password" placeholder="Password" class="w-full p-3 bg-white/95 border border-blue-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-white transition-all" required>
                    </div>
                    <div>
                        <input type="password" name="confirm_password" placeholder="Confirm Password" class="w-full p-3 bg-white/95 border border-blue-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-white transition-all" required>
                    </div>
                    <div>
                        <input type="date" name="dob" class="w-full p-3 bg-white/95 border border-blue-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-white transition-all" value="<?php echo htmlspecialchars($_POST['dob'] ?? ''); ?>" required>
                    </div>
                    <div>
                        <select name="gender" class="w-full p-3 bg-white/95 border border-blue-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-white transition-all" required>
                            <option value="" disabled selected hidden>Select Gender</option>
                            <option value="male" <?php echo (isset($_POST['gender']) && $_POST['gender'] == 'male') ? 'selected' : ''; ?>>Male</option>
                            <option value="female" <?php echo (isset($_POST['gender']) && $_POST['gender'] == 'female') ? 'selected' : ''; ?>>Female</option>
                            <option value="other" <?php echo (isset($_POST['gender']) && $_POST['gender'] == 'other') ? 'selected' : ''; ?>>Other</option>
                        </select>
                    </div>
                    <button type="submit" class="w-full p-3 rounded-lg font-semibold transition-all text-white">Sign Up</button>
                    <?php if (isset($error)) echo "<p class='text-red-200 text-center animate-pulse error-message'>$error</p>"; ?>
                    <?php if (isset($success)) echo "<p class='text-green-200 text-center animate-bounce success-message'>$success</p>"; ?>
                    <p class="text-center text-gray-400">Already registered? <a href="login.php" class="text-blue-400 hover:underline">Log in</a></p>
                </form>
            </div>
        </main>
    </div>

    <?php include '../includes/footer.php'; ?>
</body>
</html>
<?php
if (isset($_SESSION['error'])) {
    echo '<p style="color: red; text-align: center;">' . htmlspecialchars($_SESSION['error']) . '</p>';
    unset($_SESSION['error']);
}
?>