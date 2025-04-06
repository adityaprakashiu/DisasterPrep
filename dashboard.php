<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
}
?>
<div class="p-4">
    <h2 class="text-2xl">Welcome, <?php echo $_SESSION['user']['name']; ?></h2>
    <div id="map" class="w-full h-64 mt-4"></div>
</div>