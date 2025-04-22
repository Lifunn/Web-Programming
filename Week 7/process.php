<?php
// Set headers to allow AJAX requests
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Simulate server processing delay
sleep(1);

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the JSON data from the request
    $json_data = file_get_contents('php://input');
    $data = json_decode($json_data, true);
    
    // If no data was received or could not be decoded
    if ($data === null) {
        echo json_encode([
            'success' => false,
            'message' => 'No data was received or data format is invalid.'
        ]);
        exit;
    }
    
    // Validate the data
    $name = isset($data['name']) ? trim($data['name']) : '';
    $email = isset($data['email']) ? trim($data['email']) : '';
    $message = isset($data['message']) ? trim($data['message']) : '';
    
    $errors = [];
    
    if (empty($name)) {
        $errors[] = 'Name is required.';
    }
    
    if (empty($email)) {
        $errors[] = 'Email is required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Email address is invalid.';
    }
    
    if (empty($message)) {
        $errors[] = 'Message is required.';
    }
    
    // If there are errors, return them
    if (!empty($errors)) {
        echo json_encode([
            'success' => false,
            'message' => 'Validation failed.',
            'errors' => $errors
        ]);
        exit;
    }
    
    // In a real application, you would save the data to a database here
    // For this example, we'll just return a success message
    
    echo json_encode([
        'success' => true,
        'message' => 'Thank you for your submission. We will get back to you shortly.',
        'data' => [
            'name' => $name,
            'email' => $email,
            'timestamp' => date('Y-m-d H:i:s')
        ]
    ]);
} else {
    // If the request is not a POST request
    echo json_encode([
        'success' => false,
        'message' => 'Only POST requests are accepted.'
    ]);
}
?>