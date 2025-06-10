<?php
header('Content-Type: application/json');
include '../config.php'; // Koneksi database menggunakan PDO

try {
    $stmt = $pdo_els->query('SELECT id, name FROM departments ORDER BY name');
    $departments = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($departments) {
        echo json_encode(['success' => true, 'departments' => $departments]);
    } else {
        echo json_encode(['success' => true, 'departments' => []]);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Kesalahan database: ' . $e->getMessage()]);
}
?>