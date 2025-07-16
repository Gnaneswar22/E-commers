<?php
require_once 'config.php';
require_once 'vendor/autoload.php'; // For Twilio SDK

use Twilio\Rest\Client;

// Twilio credentials
$twilio_account_sid = 'YOUR_ACCOUNT_SID';
$twilio_auth_token = 'YOUR_AUTH_TOKEN';
$twilio_phone_number = 'YOUR_TWILIO_PHONE_NUMBER';

// Function to generate OTP
function generateOTP() {
    return rand(100000, 999999);
}

// Function to send OTP via SMS using Twilio
function sendOTP($phone, $otp) {
    global $twilio_account_sid, $twilio_auth_token, $twilio_phone_number;
    
    try {
        $client = new Client($twilio_account_sid, $twilio_auth_token);
        $message = $client->messages->create(
            '+91' . $phone, // Add country code
            [
                'from' => $twilio_phone_number,
                'body' => "Your OTP for MENWEAR is: $otp. Valid for 5 minutes."
            ]
        );
        
        return true;
    } catch (Exception $e) {
        error_log("Error sending SMS: " . $e->getMessage());
        return false;
    }
}

// Handle AJAX requests
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"), true);
    $action = isset($data['action']) ? $data['action'] : '';
    
    // Send OTP
    if ($action == 'send_otp') {
        $phone = $data['phone'];
        
        // Validate phone number (basic validation)
        if (!preg_match('/^[0-9]{10}$/', $phone)) {
            echo json_encode(['success' => false, 'message' => 'Invalid phone number']);
            exit;
        }
        
        $otp = generateOTP();
        $expires_at = date('Y-m-d H:i:s', strtotime('+5 minutes'));
        
        // Store OTP in database
        $stmt = $conn->prepare("INSERT INTO otp_verification (phone, otp, expires_at) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $phone, $otp, $expires_at);
        
        if ($stmt->execute()) {
            // Send OTP via SMS
            if (sendOTP($phone, $otp)) {
                echo json_encode(['success' => true, 'message' => 'OTP sent successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to send OTP']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Error storing OTP']);
        }
    }
    
    // Other functions remain the same...
}
?>