<?php
header('Content-Type: application/json');
include '../config.php'; // Pastikan koneksi $pdo_els ada

// Koordinat statis berdasarkan lokasi
$staticCoordinates = [
    'lantai-1' => [
        ['id' => 8, 'top' => 33.3, 'left' => 25.5],
        ['id' => 7, 'top' => 29, 'left' => 51],
        ['id' => 6, 'top' => 33, 'left' => 51],
        ['id' => 5, 'top' => 29, 'left' => 76.2],
        ['id' => 4, 'top' => 66, 'left' => 73.5],
        ['id' => 24, 'top' => 66, 'left' => 76.2],
        ['id' => 27, 'top' => 66, 'left' => 25.5] 
    ],
    'lantai-2' => [
        ['id' => 1, 'top' => 40.3, 'left' => 54],
        ['id' => 2, 'top' => 47.2, 'left' => 37.6],
        ['id' => 3, 'top' => 23.0, 'left' => 60.5],
        ['id' => 27, 'top' => 74, 'left' => 31]
    ],
    'plant' => [
        ['id' => 9, 'top' => 11.2, 'left' => 25.0],
        ['id' => 10, 'top' => 11.2, 'left' => 33.0],
        ['id' => 11, 'top' => 11.2, 'left' => 42.0],
        ['id' => 15, 'top' => 11.2, 'left' => 63.5],
        ['id' => 16, 'top' => 11.2, 'left' => 67.2],
        ['id' => 26, 'top' => 11.2, 'left' => 74.0],
        ['id' => 7, 'top' => 43.9, 'left' => 25.0],
        ['id' => 5, 'top' => 58.0, 'left' => 25.0],
        ['id' => 12, 'top' => 80.0, 'left' => 25.0],
        ['id' => 13, 'top' => 80.0, 'left' => 33.2],
        ['id' => 14, 'top' => 80.0, 'left' => 42.0],
        ['id' => 17, 'top' => 80.0, 'left' => 46.0],
        ['id' => 19, 'top' => 80.0, 'left' => 53.2],
        ['id' => 18, 'top' => 80.0, 'left' => 57.7],
        ['id' => 20, 'top' => 80.0, 'left' => 61.0],
        ['id' => 21, 'top' => 80.0, 'left' => 64.2],
        ['id' => 22, 'top' => 80.0, 'left' => 67.5],
        ['id' => 23, 'top' => 80.0, 'left' => 74.1],
        ['id' => 25, 'top' => 43.9, 'left' => 80.0],
        ['id' => 28, 'top' => 11.2, 'left' => 80.0]
    ]
];

$location = $_GET['location'] ?? '';

try {
    // Validasi lokasi
    if (!isset($staticCoordinates[$location])) {
        echo json_encode(['success' => false, 'message' => 'Invalid location']);
        exit;
    }

    // Periksa koneksi database
    if (!$pdo_els) {
        echo json_encode(['success' => false, 'message' => 'Database connection failed']);
        exit;
    }

    $points = [];
    $ids = array_unique(array_column($staticCoordinates[$location], 'id'));
    $placeholders = rtrim(str_repeat('?,', count($ids)), ',');
    $stmt = $pdo_els->prepare("SELECT id, room_name, act_dt FROM readers WHERE id IN ($placeholders)");
    $stmt->execute($ids);

    $readerData = [];
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    error_log("Query result for location $location: " . print_r($rows, true));

    foreach ($rows as $row) {
        $readerData[$row['id']] = [
            'room_name' => !empty($row['room_name']) ? htmlspecialchars($row['room_name']) : 'Room ID ' . $row['id'],
            'act_dt' => !empty($row['act_dt']) ? $row['act_dt'] : 'No Date'
        ];
    }

    foreach ($staticCoordinates[$location] as $coord) {
        $id = $coord['id'];
        if (!isset($readerData[$id])) {
            error_log("ID $id not found in readerData for location $location");
        }

        $points[] = [
            'id' => $id,
            'room_name' => isset($readerData[$id]) ? $readerData[$id]['room_name'] . '<br>' . $readerData[$id]['act_dt'] : 'Room ID ' . $id,
            'top' => $coord['top'],
            'left' => $coord['left'],
        ];
    }

    $output = ['success' => true, 'points' => $points];
    error_log("JSON output for location $location: " . json_encode($output));
    echo json_encode($output);
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
?>