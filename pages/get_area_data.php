<?php
// Database connection configuration
$host = 'localhost'; // Adjust as needed
$dbname = 'employee_locating_system';
$username = 'root'; // Replace with your database username
$password = ''; // Replace with your database password

try {
    // Create PDO connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get reader IDs from query parameters
    $reader_id_1 = isset($_GET['reader_id_1']) ? intval($_GET['reader_id_1']) : 0;
    $reader_id_2 = isset($_GET['reader_id_2']) ? intval($_GET['reader_id_2']) : 0;

    // Prepare and execute query
    $stmt = $pdo->prepare("
        SELECT id, reader_id_1, reader_id_2, nama_area, tipe_area, pos_x, pos_y
        FROM area
        WHERE reader_id_1 = :reader_id_1 AND reader_id_2 = :reader_id_2
        LIMIT 1
    ");
    $stmt->execute([
        ':reader_id_1' => $reader_id_1,
        ':reader_id_2' => $reader_id_2
    ]);

    // Fetch result
    $location = $stmt->fetch(PDO::FETCH_ASSOC);

    // Set response header
    header('Content-Type: application/json');

    // Return response
    if ($location) {
        echo json_encode([
            'success' => true,
            'location' => $location
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'No location found for the given reader IDs.'
        ]);
    }
} catch (PDOException $e) {
    // Handle database errors
    header('Content-Type: application/json');
    echo json_encode([
        'success' => false,
        'message' => 'Database error: ' . $e->getMessage()
    ]);
}
?>