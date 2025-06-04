<?php
session_start();
require_once 'config.php';

header('Content-Type: application/json'); // Set JSON response header

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $npk = $_POST['npk'] ?? '';
    $password = $_POST['password'] ?? '';

    // Validasi input
    if (empty($npk) || empty($password)) {
        echo json_encode([
            'success' => false,
            'message' => 'Semua kolom harus diisi!'
        ]);
        exit;
    }

    // Verifikasi pengguna
    $stmt = $pdo->prepare("SELECT * FROM users WHERE npk = ?");
    $stmt->execute([$npk]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        // Login berhasil, buat sesi
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['npk'] = $user['npk'];
        $_SESSION['name'] = $user['name'];

        // Simpan sesi ke database (opsional)
        $session_id = bin2hex(random_bytes(16));
        $ip_address = $_SERVER['REMOTE_ADDR'];
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $stmt = $pdo->prepare("INSERT INTO sessions (id, user_id, ip_address, user_agent) VALUES (?, ?, ?, ?)");
        $stmt->execute([$session_id, $user['id'], $ip_address, $user_agent]);

        // Return JSON with redirect URL
        echo json_encode([
            'success' => true,
            'redirect' => 'dashboard.php'
        ]);
        exit;
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'NPK atau kata sandi salah!'
        ]);
        exit;
    }
}
?>