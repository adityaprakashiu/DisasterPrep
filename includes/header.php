<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<header class="w-full bg-gradient-to-r from-[#2A3D4A] to-[#3B5A6B] text-white p-4 z-10 shadow-md" role="banner">
    <nav class="flex justify-between items-center max-w-7xl mx-auto px-6" aria-label="Main navigation">
        <div class="flex items-center space-x-2">
            <img src="/DisasterPrep/assets/images/logoDp.png" alt="DisasterPrep Logo" class="h-10 w-auto" onerror="this.style.display='none';">
            <h1 class="text-4xl font-bold text-white" aria-label="DisasterPrep Logo">DisasterPrep</h1>
        </div>
        <ul class="flex space-x-6" role="menubar">
            <li role="menuitem"><a href="/DisasterPrep/index.php" class="text-lg font-bold text-white hover:text-blue-500 hover:underline transition-colors" aria-current="page">Home</a></li>
            <?php if (isset($_SESSION['user_id'])): ?>
                <li role="menuitem"><a href="/DisasterPrep/pages/profile.php" class="text-lg font-bold text-white hover:text-blue-500 hover:underline transition-colors">Profile</a></li>
                <li role="menuitem"><a href="/DisasterPrep/weather.php" class="text-lg font-bold text-white hover:text-blue-500 hover:underline transition-colors">Weather</a></li>
                <li role="menuitem"><a href="/DisasterPrep/pages/quiz.php" class="text-lg font-bold text-white hover:text-blue-500 hover:underline transition-colors">Quiz</a></li>
                <li role="menuitem"><a href="/DisasterPrep/pages/about.php" class="text-lg font-bold text-white hover:text-blue-500 hover:underline transition-colors">About Us</a></li>
                <li role="menuitem"><a href="/DisasterPrep/pages/contact.php" class="text-lg font-bold text-white hover:text-blue-500 hover:underline transition-colors">Contact Us</a></li>
                <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']): ?>
                    <li role="menuitem"><a href="/DisasterPrep/admin/index.php" class="text-lg font-bold text-white hover:text-blue-500 hover:underline transition-colors">Admin</a></li>
                <?php endif; ?>
                <li role="menuitem"><a href="/DisasterPrep/pages/logout.php" class="text-lg font-bold text-white hover:text-blue-500 hover:underline transition-colors">Logout</a></li>
            <?php else: ?>
                <li role="menuitem"><a href="/DisasterPrep/pages/login.php" class="text-lg font-bold text-white hover:text-blue-500 hover:underline transition-colors">Login</a></li>
                <li role="menuitem"><a href="/DisasterPrep/pages/signup.php" class="text-lg font-bold text-white hover:text-blue-500 hover:underline transition-colors">Signup</a></li>
                <li role="menuitem"><a href="/DisasterPrep/pages/about.php" class="text-lg font-bold text-white hover:text-blue-500 hover:underline transition-colors">About Us</a></li>
                <li role="menuitem"><a href="/DisasterPrep/pages/contact.php" class="text-lg font-bold text-white hover:text-blue-500 hover:underline transition-colors">Contact Us</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>