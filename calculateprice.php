<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

$conn = new mysqli("localhost", "root", "", "tanishq_calculator");

if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]));
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die(json_encode(['success' => false, 'message' => 'Invalid request method']));
}

// Get POST data
if (isset($_POST['design_id'])) {
    $design_id = $_POST['design_id'];
    $gold_rate = $_POST['gold_rate'] ?? 0;
    $gemstone_price = $_POST['gemstone_price'] ?? 0;
} else {
    // Handle JSON input
    $input = json_decode(file_get_contents('php://input'), true);
    $design_id = $input['design_id'] ?? 0;
    $gold_rate = $input['gold_rate'] ?? 0;
    $gemstone_price = $input['gemstone_price'] ?? 0;
}

if (!$design_id || !$gold_rate) {
    die(json_encode(['success' => false, 'message' => 'Missing required fields: design_id and gold_rate']));
}

// Get jewelry details
$stmt = $conn->prepare("
    SELECT jd.*, jt.type_name 
    FROM jewelry_designs jd 
    JOIN jewelry_types jt ON jd.jewelry_type_id = jt.id 
    WHERE jd.id = ?
");
$stmt->bind_param("i", $design_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die(json_encode(['success' => false, 'message' => 'Jewelry design not found']));
}

$jewelry = $result->fetch_assoc();

// Calculate prices
$weight = $jewelry['weight_grams'];
$making_charges = $jewelry['making_charges'];
$wastage_percentage = $jewelry['wastage_percentage'];
$tax_percentage = $jewelry['tax_percentage'];
$gemstone_count = $jewelry['gemstone_count'];

// Gold cost calculation
$gold_cost = $weight * $gold_rate;

// Wastage cost calculation
$wastage_cost = $gold_cost * ($wastage_percentage / 100);

// Total gemstone cost
$total_gemstone_cost = $gemstone_count * $gemstone_price;

// Subtotal before tax
$subtotal = $gold_cost + $making_charges + $wastage_cost + $total_gemstone_cost;

// Tax calculation
$tax_amount = $subtotal * ($tax_percentage / 100);

// Total price
$total_price = $subtotal + $tax_amount;

// Format response
$response = [
    'success' => true,
    'jewelry_name' => $jewelry['design_name'],
    'jewelry_type' => $jewelry['type_name'],
    'current_gold_rate' => number_format($gold_rate, 2),
    'gold_cost' => number_format($gold_cost, 2),
    'making_charges' => number_format($making_charges, 2),
    'wastage_cost' => number_format($wastage_cost, 2),
    'gemstone_cost' => number_format($total_gemstone_cost, 2),
    'tax_amount' => number_format($tax_amount, 2),
    'total_price' => number_format($total_price, 2),
    'details' => [
        'weight' => $weight,
        'gemstone_count' => $gemstone_count,
        'wastage_percentage' => $wastage_percentage,
        'tax_percentage' => $tax_percentage,
        'making_charges_raw' => $making_charges,
        'gold_cost_raw' => $gold_cost,
        'wastage_cost_raw' => $wastage_cost,
        'total_gemstone_cost_raw' => $total_gemstone_cost,
        'tax_amount_raw' => $tax_amount,
        'total_price_raw' => $total_price
    ]
];

echo json_encode($response);
$conn->close();
?>
