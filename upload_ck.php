<?php
// Adjust the following lines to match your own environment:
$uploadDir = 'upload/';
$publicPath = 'https://tanawan91.ddlcoding.com/upload/';
$response = [];

if ($_FILES['upload']) {
    $file = $_FILES['upload'];
    $fileName = basename($file['name']);
    $uploadPath = $uploadDir . $fileName;
    
    if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
        $fileUrl = $publicPath . $fileName;

        $response = [
            "uploaded" => 1,
            "fileName" => $fileName,
            "url" => $fileUrl
        ];
    } else {
        $response = [
            "uploaded" => 0,
            "error" => [
                "message" => "Could not upload the image. Check permissions."
            ]
        ];
    }
} else {
    $response = [
        "uploaded" => 0,
        "error" => [
            "message" => "No file sent."
        ]
    ];
}

// Send the JSON response to the editor
header('Content-Type: application/json');
echo json_encode($response);
