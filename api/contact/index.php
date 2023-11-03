<?php

include '../connect_pdo.php';

$method = $_SERVER['REQUEST_METHOD'];

$response = [];

$allowedOrigins = [
    '*',   
];

$origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '';
if (in_array($origin, $allowedOrigins)) {
    header("Access-Control-Allow-Origin: $origin");
}

header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");

switch ($method) {
    case 'GET':
        $urlParts = explode('/', $_SERVER['REQUEST_URI']);
        
        $urlParts = array_values(array_filter($urlParts));

        if (end($urlParts) === 'contact') {

            $stmt = $db->query("SELECT * FROM contact ");
            $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } elseif (is_numeric(end($urlParts))) {
            $serviceId = (int)end($urlParts);

            $stmt = $db->prepare("SELECT * FROM contact WHERE contactId = ?");
            $stmt->execute([$serviceId]);
            $service = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($service) {
                $response = $service;
            } else {
                http_response_code(404); 
                $response = ["error" => "Id not found"];
            }
        } else {
            http_response_code(400); 
            $response = ["error" => "Invalid URL format"];
        }
        break;

        case 'POST':
            $data = json_decode(file_get_contents('php://input'), true);
            if (!empty($data['name']) && !empty($data['email']) && !empty($data['message'])) {
                $name = $data['name'];
                $email = $data['email'];
                $phone = $data['phone'] ?? ''; // Using null coalescing operator for optional data
                $subject = $data['subject'] ?? 'No subject'; // Default subject if not provided
                $message = $data['message'];
        
                // Insert service into the database
                $stmt = $db->prepare("INSERT INTO contact_form (name, email, phone, subject, message) VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([$name, $email, $phone, $subject, $message]);
        
                $stmt3 = $db->query("SELECT * FROM setting_mail LIMIT 1");
                $emailSettings = $stmt3->fetch(PDO::FETCH_ASSOC);
                // Send email to admin
                $adminEmail = $emailSettings['email']; // Replace with the admin's email address
                $headers = "From: " . $email . "\r\n";
                $headers .= "Reply-To: " . $email . "\r\n";
                $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
        
                $emailBody = "You have received a new contact message:\n\n";
                $emailBody .= "Name: " . $name . "\n";
                $emailBody .= "Email: " . $email . "\n";
                $emailBody .= "Phone: " . $phone . "\n";
                $emailBody .= "Subject: " . $subject . "\n";
                $emailBody .= "Message:\n" . $message . "\n";
        
                // Use mail() function to send the email
                if(mail($adminEmail, "New Contact Form Submission", $emailBody, $headers)) {
                    $response = ["message" => "Service created and email sent successfully"];
                } else {
                    $response = ["error" => "Service created but email failed to send"];
                }
            } else {
                $response = ["error" => "Name, email, and message are required for creating a service"];
            }
            break;
    
    default:
        http_response_code(405); 
        $response = ["error" => "Invalid HTTP method"];
        break;
}


header("Content-Type: application/json");
echo json_encode($response);
?>
