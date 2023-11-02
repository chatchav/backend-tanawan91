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

        if (end($urlParts) === 'homes') {

            $stmt = $db->query("SELECT * FROM `homeslider` WHERE status = 'A'");
            $homeSlider = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $stmt = $db->query("SELECT a.* FROM `home_about` h INNER JOIN about a ON a.aboutId = h.aboutId WHERE h.status = 'A'");
            $homeAbout = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $stmt = $db->query("SELECT * FROM services WHERE status = 'A'");
            $homeService = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $stmt = $db->query("SELECT p.* FROM `home_projects` h INNER JOIN projects p ON p.projectId = h.projectId WHERE h.status = 'A'");
            $homeProject = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $stmt = $db->query("SELECT * FROM publications WHERE status = 'A' ORDER BY publicId DESC LIMIT 8");
            $homeArticles = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $stmt = $db->query("SELECT * FROM contact");
            $homeContact = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $response = [
                "slider" => $homeSlider,
                "abouts" => $homeAbout,
                "services" => $homeService,
                "projects" => $homeProject,
                "articles" => $homeArticles,
                "contact" => $homeContact
            ];
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
