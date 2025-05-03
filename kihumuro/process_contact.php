<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once 'config/database.php';

$database = new Database();
$db = $database->getConnection();

$data = json_decode(file_get_contents("php://input"));

if (
    !empty($data->name) &&
    !empty($data->email) &&
    !empty($data->message)
) {
    $name = htmlspecialchars(strip_tags($data->name));
    $email = htmlspecialchars(strip_tags($data->email));
    $message = htmlspecialchars(strip_tags($data->message));
    
    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo json_encode(array("message" => "Invalid email format."));
        exit();
    }

    try {
        $query = "INSERT INTO contacts (name, email, message, created_at) VALUES (:name, :email, :message, NOW())";
        $stmt = $db->prepare($query);

        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":message", $message);

        if ($stmt->execute()) {
            http_response_code(201);
            echo json_encode(array("message" => "Contact message was created successfully."));
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "Unable to create contact message."));
        }
    } catch(PDOException $exception) {
        http_response_code(500);
        echo json_encode(array("message" => "Database error: " . $exception->getMessage()));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Unable to create contact message. Data is incomplete."));
}
?> 