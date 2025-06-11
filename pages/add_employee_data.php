<?php
header('Content-Type: application/json');
ini_set('display_errors', 0); // Nonaktifkan output error HTML
ini_set('log_errors', 1);
ini_set('error_log', '/path/to/php_error.log'); // Sesuaikan path
date_default_timezone_set('Asia/Jakarta');

try {
    // Periksa keberadaan config.php
    if (!file_exists('../config.php')) {
        throw new Exception('File config.php tidak ditemukan.');
    }
    include '../config.php';

    // Ambil input JSON
    $input = file_get_contents('php://input');
    if (!$input) {
        throw new Exception('Tidak ada data input.');
    }
    $data = json_decode($input, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception('Data JSON tidak valid: ' . json_last_error_msg());
    }

    // Validasi input
    if (empty($data['name']) || empty($data['npk']) || empty($data['department']) || empty($data['rfid'])) {
        echo json_encode([
            'success' => false,
            'message' => 'Semua kolom wajib diisi.'
        ]);
        exit;
    }

    // Sanitasi data
    $name = filter_var($data['name'], FILTER_SANITIZE_STRING);
    $npk = filter_var($data['npk'], FILTER_SANITIZE_STRING);
    $department_id = filter_var($data['department'], FILTER_VALIDATE_INT);
    $rfid = filter_var($data['rfid'], FILTER_SANITIZE_STRING);
    $sta = 1;
    $udate_sta = date('Y-m-d H:i:s');

    // Validasi department_id
    $stmt = $pdo_els->prepare('SELECT id FROM departments WHERE id = :id');
    $stmt->execute(['id' => $department_id]);
    if (!$stmt->fetch()) {
        echo json_encode([
            'success' => false,
            'message' => 'Departemen tidak valid.'
        ]);
        exit;
    }

    // Validasi rfid
    $stmt = $pdo_els->prepare('SELECT rfid FROM unknown_rfid WHERE rfid = :rfid');
    $stmt->execute(['rfid' => $rfid]);
    if (!$stmt->fetch()) {
        echo json_encode([
            'success' => false,
            'message' => 'RFID tidak valid.'
        ]);
        exit;
    }

    // Siapkan dan jalankan query INSERT
    $sql = "INSERT INTO employees (npk, name, department_id, rfid, sta, udate_sta) 
            VALUES (:npk, :name, :department_id, :rfid, :sta, :udate_sta)";
    $stmt = $pdo_els->prepare($sql);
    $stmt->bindParam(':npk', $npk);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':department_id', $department_id, PDO::PARAM_INT);
    $stmt->bindParam(':rfid', $rfid);
    $stmt->bindParam(':sta', $sta, PDO::PARAM_INT);
    $stmt->bindParam(':udate_sta', $udate_sta);
    $stmt->execute();

    echo json_encode([
        'success' => true,
        'message' => 'Data karyawan berhasil ditambahkan.'
    ]);

} catch (PDOException $e) {
    error_log('PDOException: ' . $e->getMessage()); // Log ke file
    if ($e->getCode() == 23000) {
        echo json_encode([
            'success' => false,
            'message' => 'NPK atau RFID sudah terdaftar.'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Kesalahan database: ' . $e->getMessage()
        ]);
    }
} catch (Exception $e) {
    error_log('Exception: ' . $e->getMessage()); // Log ke file
    echo json_encode([
        'success' => false,
        'message' => 'Kesalahan: ' . $e->getMessage()
    ]);
}
?>