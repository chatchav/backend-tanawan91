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

        if (end($urlParts) === 'contact_th') {

            $stmt = $db->query("SELECT * FROM contact_th ");
            $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } elseif (is_numeric(end($urlParts))) {
            $serviceId = (int)end($urlParts);

            $stmt = $db->prepare("SELECT * FROM contact_th WHERE contactId = ?");
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
            if (!empty($data['name'])) {
                $name = $data['name'];
    
                // Insert service into the database
                $stmt = $db->prepare("INSERT INTO contact (name) VALUES (?)");
                $stmt->execute([$name]);
    
                $response = ["message" => "Service created successfully"];
            } else {
                $response = ["error" => "Name is required for creating a service"];
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
