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

        if (end($urlParts) === 'projects') {

            $stmt = $db->query("SELECT * FROM projects WHERE status = 'A'");
            $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } elseif (is_numeric(end($urlParts))) {
            $serviceId = (int)end($urlParts);

            $stmt = $db->prepare("SELECT * FROM projects WHERE projectId = ?");
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

    default:
        http_response_code(405); 
        $response = ["error" => "Invalid HTTP method"];
        break;
}


header("Content-Type: application/json");
echo json_encode($response);
?>
