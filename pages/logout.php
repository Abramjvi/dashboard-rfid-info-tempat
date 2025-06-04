<?php
session_start();
require_once '../config.php';

// Hapus sesi dari database
if (isset($_SESSION['user_id'])) {
    $stmt = $pdo->prepare("DELETE FROM sessions WHERE user_id = ?");
    $stmt->execute([$_SESSION['user_id']]);
}

// Destroy all session data
session_unset();
session_destroy();

// Set header untuk mencegah caching
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');
header('Expires: Thu, 01 Jan 1970 00:00:00 GMT');

// Redirect ke index.php
header('Location: /dashboard-rfid-employee/pages/index.php');
exit;
?>