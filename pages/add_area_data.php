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

    // Get JSON data from request
    $input = json_decode(file_get_contents('php://input'), true);
    $reader_id_1 = isset($input['reader_id_1']) ? intval($input['reader_id_1']) : 0;
    $reader_id_2 = isset($input['reader_id_2']) ? intval($input['reader_id_2']) : 0;
    $nama_area = isset($input['nama_area']) ? trim($input['nama_area']) : '';

    // Validate input
    if (!$reader_id_1 || !$reader_id_2 || !$nama_area) {
        header('Content-Type: application/json');
        echo json_encode([
            'success' => false,
            'message' => 'All fields (reader_id_1, reader_id_2, nama_area) are required.'
        ]);
        exit;
    }

    // Set default values for other fields
    $tipe_area = 1; // Default to 1 (can be adjusted based on requirements)
    $pos_x = 90; // Default value
    $pos_y = 90; // Default value
    $pos1_x = 90; // Default value
    $pos1_y = 90; // Default value

    // Prepare and execute insert query
    $stmt = $pdo->prepare("
        INSERT INTO area (reader_id_1, reader_id_2, nama_area, tipe_area, pos_x, pos_y, pos1_x, pos1_y)
        VALUES (:reader_id_1, :reader_id_2, :nama_area, :tipe_area, :pos_x, :pos_y, :pos1_x, :pos1_y)
    ");
    $stmt->execute([
        ':reader_id_1' => $reader_id_1,
        ':reader_id_2' => $reader_id_2,
        ':nama_area' => $nama_area,
        ':tipe_area' => $tipe_area,
        ':pos_x' => $pos_x,
        ':pos_y' => $pos_y,
        ':pos1_x' => $pos1_x,
        ':pos1_y' => $pos1_y
    ]);

    // Return success response
    header('Content-Type: application/json');
    echo json_encode([
        'success' => true,
        'message' => 'Location added successfully.'
    ]);
} catch (PDOException $e) {
    // Handle database errors
    header('Content-Type: application/json');
    echo json_encode([
        'success' => false,
        'message' => 'Database error: ' . $e->getMessage()
    ]);
}
?>