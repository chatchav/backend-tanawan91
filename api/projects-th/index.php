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
        if (end($urlParts) === 'projects-th') {

            $stmt = $db->query(
            "SELECT p.*, t.typeNameTH as typeName
            FROM projects_th p
            INNER JOIN setting_project_type t ON t.typeId = p.typeId
            WHERE p.status = 'A'  ORDER BY seq DESC");
            $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } elseif (end($urlParts)) {
            $serviceId = end($urlParts);

            $stmt = $db->prepare(
            "SELECT p.*, t.typeNameTH as typeName, s.statusNameTH as statusName
            FROM projects_th p
            INNER JOIN setting_project_type t ON t.typeId = p.typeId
            INNER JOIN setting_project_status s ON s.statusId = p.projectStatusId
            WHERE p.status = 'A' AND p.urlFriendly = ?");
            $stmt->execute([$serviceId]);
            $service = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $stmt = $db->prepare(
                "SELECT image FROM `project_albums`
                WHERE projectId = (SELECT projectId FROM `projects` WHERE status ='A' AND urlFriendly = ? )");
            $stmt->execute([$serviceId]);
            $albums = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($service) {
                $response = ["data"=>$service,"albums"=>$albums];
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
