<?php
session_start();
require_once '../includes/db.php';

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $message = filter_var($_POST['message'], FILTER_SANITIZE_STRING);

    if (empty($name) || empty($email) || empty($message)) {
        $error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } else {
        try {
            $stmt = $conn->prepare("INSERT INTO contact (name, email, message, created_at) VALUES (?, ?, ?, NOW())");
            $stmt->bind_param("sss", $name, $email, $message);
            if ($stmt->execute()) {
                $success = "Thank you for contacting us! We will get back to you soon.";
                $_POST = array(); // Clear form data
            } else {
                $error = "Failed to send message. Please try again.";
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
    <title>Contact Us - DisasterPrep</title>
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
        .form-container { background: rgba(37, 70, 85, 0.95); border: 2px solid #1e3a47; box-shadow: 0 6px 20px rgba(37, 70, 85, 0.4); backdrop-filter: blur(8px); padding: 2rem; border-radius: 0.75rem; max-width: 500px; width: 100%; transition: transform 0.3s ease, opacity 0.3s ease; }
        .form-container:hover { transform: translateY(-5px); opacity: 0.98; }
        .form-input { background: rgba(255, 255, 255, 0.1); border: 1px solid #a3c1cc; color: #e2e8f0; padding: 0.75rem 0.75rem 0.75rem 2.5rem; border-radius: 0.5rem; width: 100%; transition: all 0.3s ease; }
        .form-input::placeholder { color: #d1e0e6; opacity: 1; }
        .form-input:focus { background: rgba(255, 255, 255, 0.2); border-color: #10b981; outline: none; box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.4); }
        textarea.form-input { min-height: 100px; resize: vertical; padding: 1rem 1rem 1rem 2.5rem; line-height: 1.5; }
        .submit-btn { background: linear-gradient(to right, #254655, #1e3a47, #172a33); color: #fff; padding: 0.75rem; border-radius: 0.5rem; width: 100%; font-weight: bold; transition: all 0.3s ease; }
        .submit-btn:hover { background: linear-gradient(to right, #1e3a47, #172a33, #101c22); transform: translateY(-2px); }
        .error-message { color: #ffccd5; background: rgba(220, 38, 38, 0.2); padding: 0.75rem; border-radius: 0.5rem; text-align: center; margin-bottom: 1rem; }
        .success-message { color: #bbf7d0; background: rgba(34, 197, 94, 0.2); padding: 0.75rem; border-radius: 0.5rem; text-align: center; margin-bottom: 1rem; }
        .map-container { margin-top: 2rem; border-radius: 0.5rem; overflow: hidden; }
        footer { margin-top: auto; padding: 1rem; text-align: center; }
        footer a { margin: 0 0.5rem; color: #10b981; }
        footer a:hover { color: #059669; }
        @media (max-width: 640px) { .hero h1 { font-size: 2rem; } .hero p { font-size: 1rem; } .form-container { padding: 1rem; } .form-input, .submit-btn { padding: 0.5rem 0.5rem 0.5rem 2rem; font-size: 0.875rem; } .map-container iframe { height: 200px; } }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    </style>
</head>
<body>
    <?php include '../includes/header.php'; ?>

    <section class="hero">
        <div>
            <h1 class="text-4xl md:text-5xl font-extrabold mb-4">Contact Us</h1>
            <p class="text-lg md:text-xl">Get in touch with our team for support or inquiries</p>
        </div>
    </section>

    <main class="flex-grow flex items-center justify-center px-4 py-8">
        <div class="form-container">
            <h2 class="text-2xl font-bold text-center mb-6 text-white">Send Us a Message</h2>
            
            <?php if ($error): ?>
                <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
            <?php elseif ($success): ?>
                <div class="success-message"><?php echo htmlspecialchars($success); ?></div>
            <?php endif; ?>

            <form method="POST" class="space-y-4">
                <div class="relative">
                    <input type="text" name="name" placeholder="Your Name" class="form-input" value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>" required>
                    <svg class="absolute top-1/2 left-3 transform -translate-y-1/2 w-5 h-5" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                </div>
                <div class="relative">
                    <input type="email" name="email" placeholder="Your Email" class="form-input" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required>
                    <svg class="absolute top-1/2 left-3 transform -translate-y-1/2 w-5 h-5" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 14H4V6h16v12zM4 0h16v2H4V0zm0 20h16v2H4v-2zm6-10l8 5V7l-8 5z"/>
                    </svg>
                </div>
                <div class="relative">
                    <textarea name="message" placeholder="Your Message" class="form-input" required><?php echo htmlspecialchars($_POST['message'] ?? ''); ?></textarea>
                    <svg class="absolute top-4 left-3 w-5 h-5" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path d="M20 2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h14l4 4V4c0-1.1-.9-2-2-2zm-2 12H6v-2h12v2zm0-3H6V9h12v2zm0-3H6V6h12v2z"/>
                    </svg>
                </div>
                <button type="submit" class="submit-btn">Send Message</button>
            </form>

            <div class="mt-6 text-center text-gray-300">
                <p>Email: <a href="mailto:support@disasterprep.org">support@disasterprep.org</a></p>
                <p>Phone: +91-6202430412</p>
                <p>Address: 123 Preparedness Lane, Safety City, SC 12345</p>
            </div>

            <div class="map-container mt-6">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3153.0456!2d-122.4194!3d37.7749!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x80859a6d!2sSan+Francisco!5e0!3m2!1sen!2sus!4v1603456789!5m2!1sen!2sus" 
                        width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
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