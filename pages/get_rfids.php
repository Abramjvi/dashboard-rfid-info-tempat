
<?php
header('Content-Type: application/json');
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
include '../config.php'; // Koneksi database menggunakan PDO

try {
    $stmt = $pdo_els->query('SELECT rfid FROM unknown_rfid ORDER BY rfid');
    $rfids = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($rfids) {
        echo json_encode(['success' => true, 'rfids' => $rfids]);
    } else {
        echo json_encode(['success' => true, 'rfids' => []]);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Kesalahan database: ' . $e->getMessage()]);
}
?>
