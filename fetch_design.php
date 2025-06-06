<?php
$conn = new mysqli("localhost", "root", "root", "tanishq_calculator");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

if (isset($_GET['jewel_type_id'])) {
    $type_id = intval($_GET['jewel_type_id']);
    $stmt = $conn->prepare("SELECT id, design_name FROM jewelry_designs WHERE jewelry_type_id = ?");
    $stmt->bind_param("i", $type_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $designs = [];
    while ($row = $result->fetch_assoc()) {
        $designs[] = $row;
    }
    echo json_encode($designs);
}
?>