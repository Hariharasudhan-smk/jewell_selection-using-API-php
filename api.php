<?php
header('Content-Type: application/json');
$conn = new mysqli("localhost", "root", "", "tanishq_calculator");

if ($conn->connect_error) {
    die(json_encode(['error' => 'Connection failed: ' . $conn->connect_error]));
}

$action = $_GET['action'] ?? '';

switch ($action) {
    case 'get_jewelry_types':
        getJewelryTypes($conn);
        break;
    
    case 'get_designs':
        $typeId = $_GET['type_id'] ?? 0;
        getDesigns($conn, $typeId);
        break;
    
    default:
        echo json_encode(['error' => 'Invalid action']);
        break;
}

function getJewelryTypes($conn) {
    $sql = "SELECT id, type_name FROM jewelry_types ORDER BY type_name";
    $result = $conn->query($sql);
    
    $types = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $types[] = $row;
        }
    }
    
    echo json_encode($types);
}

function getDesigns($conn, $typeId) {
    $stmt = $conn->prepare("SELECT id, design_name FROM jewelry_designs WHERE jewelry_type_id = ? ORDER BY design_name");
    $stmt->bind_param("i", $typeId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $designs = [];
    while ($row = $result->fetch_assoc()) {
        $designs[] = $row;
    }
    
    echo json_encode($designs);
}

$conn->close();
?>
