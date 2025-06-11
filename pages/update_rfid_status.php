<?php
header('Content-Type: application/json');
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
include '../config.php'; // Koneksi database menggunakan PDO

try {
    // Ambil data RFID dari body request
    $data = json_decode(file_get_contents('php://input'), true);
    $rfid = $data['rfid'];

    if (!$rfid) {
        echo json_encode(['success' => false, 'message' => 'RFID tidak boleh kosong']);
        exit;
    }

    // Siapkan dan jalankan query untuk update status RFID
    $stmt = $pdo_els->prepare('UPDATE unknown_rfid SET sta = 1, udate_sta = CURRENT_TIMESTAMP WHERE rfid = ?');
    $stmt->execute([$rfid]);

    // Periksa apakah ada baris yang terpengaruh
    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => true, 'message' => 'Status RFID berhasil diperbarui']);
    } else {
        echo json_encode(['success' => false, 'message' => 'RFID tidak ditemukan']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Kesalahan database: ' . $e->getMessage()]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Kesalahan: ' . $e->getMessage()]);
}
?>