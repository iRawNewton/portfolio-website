<?php
// Allow only POST requests
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode(["message" => "Method not allowed"]);
    exit();
}

// Set your email where the appointment requests will go
$to = "contact@irawnewton.com";

// Get the email from the form
$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

// Basic validation
if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(["message" => "Please enter a valid email address."]);
    exit();
}

// Email subject and body
$subject = "New Appointment Request";
$message = "You have a new appointment request from: $email";

// Additional headers
$headers = "From: no-reply@irawnewton.com\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8";

// Try sending the email
if (mail($to, $subject, $message, $headers)) {
    http_response_code(200);
    echo json_encode(["message" => "Thank you! Your appointment request has been sent."]);
} else {
    http_response_code(500);
    echo json_encode(["message" => "Something went wrong while sending your request. Please try again later."]);
}
?>
