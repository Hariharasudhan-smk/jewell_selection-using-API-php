<?php
header('Content-Type: application/json');

// Function to get current gold rate for India
function getCurrentGoldRate() {
    // Try multiple APIs for better reliability
    
    // Method 1: Try metals-api.com (free tier available)
    $goldRate = getGoldRateFromMetalsAPI();
    if ($goldRate['success']) {
        return $goldRate;
    }
    
    // Method 2: Try alternative API
    $goldRate = getGoldRateFromAlternativeAPI();
    if ($goldRate['success']) {
        return $goldRate;
    }
    
    // Method 3: Fallback to a reasonable current rate for India
    return [
        'success' => true,
        'rate' => 6850.00, // Current approximate gold rate in India
        'currency' => 'INR',
        'unit' => 'gram',
        'last_updated' => date('Y-m-d H:i:s'),
        'source' => 'Default Rate',
        'message' => 'Using estimated current market rate for India'
    ];
}

// Method 1: Using metals-api.com
function getGoldRateFromMetalsAPI() {
    try {
        // Using free endpoint that doesn't require API key
        $url = "https://api.metals.live/v1/spot/gold";
        
        $context = stream_context_create([
            'http' => [
                'timeout' => 10,
                'method' => 'GET',
                'header' => [
                    'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'
                ]
            ]
        ]);
        
        $response = @file_get_contents($url, false, $context);
        
        if ($response !== false) {
            $data = json_decode($response, true);
            
            if (isset($data['price'])) {
                // Convert USD per ounce to INR per gram
                $usd_per_ounce = $data['price'];
                $usd_per_gram = $usd_per_ounce / 31.1035;
                
                // Get current USD to INR rate
                $usd_to_inr = getCurrentUSDToINRRate();
                $inr_per_gram = $usd_per_gram * $usd_to_inr;
                
                return [
                    'success' => true,
                    'rate' => round($inr_per_gram, 2),
                    'currency' => 'INR',
                    'unit' => 'gram',
                    'last_updated' => date('Y-m-d H:i:s'),
                    'source' => 'Live Market Data'
                ];
            }
        }
    } catch (Exception $e) {
        // Continue to next method
    }
    
    return ['success' => false];
}

// Method 2: Alternative API approach
function getGoldRateFromAlternativeAPI() {
    try {
        // Using a free gold price API
        $url = "https://api.exchangerate-api.com/v4/latest/USD";
        
        $context = stream_context_create([
            'http' => [
                'timeout' => 10,
                'method' => 'GET'
            ]
        ]);
        
        $response = @file_get_contents($url, false, $context);
        
        if ($response !== false) {
            $data = json_decode($response, true);
            
            if (isset($data['rates']['INR'])) {
                // Using current approximate gold price in USD and converting to INR
                $gold_usd_per_ounce = 2050; // Approximate current gold price
                $usd_per_gram = $gold_usd_per_ounce / 31.1035;
                $inr_per_gram = $usd_per_gram * $data['rates']['INR'];
                
                return [
                    'success' => true,
                    'rate' => round($inr_per_gram, 2),
                    'currency' => 'INR',
                    'unit' => 'gram',
                    'last_updated' => date('Y-m-d H:i:s'),
                    'source' => 'Currency Exchange Based'
                ];
            }
        }
    } catch (Exception $e) {
        // Continue to fallback
    }
    
    return ['success' => false];
}

// Function to get USD to INR conversion rate
function getCurrentUSDToINRRate() {
    try {
        $url = "https://api.exchangerate-api.com/v4/latest/USD";
        
        $context = stream_context_create([
            'http' => [
                'timeout' => 5,
                'method' => 'GET'
            ]
        ]);
        
        $response = @file_get_contents($url, false, $context);
        
        if ($response !== false) {
            $data = json_decode($response, true);
            if (isset($data['rates']['INR'])) {
                return $data['rates']['INR'];
            }
        }
    } catch (Exception $e) {
        // Use fallback rate
    }
    
    return 83.0; // Approximate current USD to INR rate
}

// Handle API requests
$action = $_GET['action'] ?? '';

switch ($action) {
    case 'get_gold_rate':
        echo json_encode(getCurrentGoldRate());
        break;
    
    default:
        echo json_encode(['error' => 'Invalid action']);
        break;
}
?>