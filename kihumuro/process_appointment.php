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
    !empty($data->phone) &&
    !empty($data->department) &&
    !empty($data->date)
) {
    $name = htmlspecialchars(strip_tags($data->name));
    $email = htmlspecialchars(strip_tags($data->email));
    $phone = htmlspecialchars(strip_tags($data->phone));
    $department = htmlspecialchars(strip_tags($data->department));
    $date = htmlspecialchars(strip_tags($data->date));
    $message = isset($data->message) ? htmlspecialchars(strip_tags($data->message)) : "";
    
    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo json_encode(array("message" => "Invalid email format."));
        exit();
    }

    // Validate date
    $appointment_date = new DateTime($date);
    $current_date = new DateTime();
    if ($appointment_date < $current_date) {
        http_response_code(400);
        echo json_encode(array("message" => "Appointment date cannot be in the past."));
        exit();
    }

    try {
        $query = "INSERT INTO appointments (name, email, phone, department, appointment_date, message, created_at) 
                 VALUES (:name, :email, :phone, :department, :appointment_date, :message, NOW())";
        $stmt = $db->prepare($query);

        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":phone", $phone);
        $stmt->bindParam(":department", $department);
        $stmt->bindParam(":appointment_date", $date);
        $stmt->bindParam(":message", $message);

        if ($stmt->execute()) {
            // Send confirmation email
            $to = $email;
            $subject = "Appointment Confirmation - Kihumuro Hospital";
            $message = "Dear " . $name . ",\n\n";
            $message .= "Your appointment has been scheduled for " . $date . " in the " . $department . " department.\n";
            $message .= "We will contact you shortly to confirm the exact time.\n\n";
            $message .= "Best regards,\nKihumuro Hospital Team";
            
            $headers = "From: appointments@kihumurohospital.com\r\n";
            $headers .= "Reply-To: appointments@kihumurohospital.com\r\n";
            $headers .= "X-Mailer: PHP/" . phpversion();
            
            mail($to, $subject, $message, $headers);

            http_response_code(201);
            echo json_encode(array("message" => "Appointment was created successfully."));
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "Unable to create appointment."));
        }
    } catch(PDOException $exception) {
        http_response_code(500);
        echo json_encode(array("message" => "Database error: " . $exception->getMessage()));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Unable to create appointment. Data is incomplete."));
}
?> 