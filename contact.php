<?php
// Only accept POST requests
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect the form data
    $to = "contact@irawnewton.com";  // Your email
    $subject = "New Contact Form Submission";

    $name = isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '';
    $email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';
    $message = isset($_POST['message']) ? htmlspecialchars($_POST['message']) : '';

    // Basic validation
    if (empty($name) || empty($email) || empty($message)) {
        http_response_code(400);
        echo json_encode(["message" => "Please fill out all fields."]);
        exit;
    }

    // Compose the email
    $body = "Name: $name\nEmail: $email\n\nMessage:\n$message";

    // Set the headers
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    // Send the email
    if (mail($to, $subject, $body, $headers)) {
        echo json_encode(["message" => "Your message has been sent successfully."]);
    } else {
        http_response_code(500);
        echo json_encode(["message" => "Failed to send message. Please try again later."]);
    }
} else {
    http_response_code(405); // Method not allowed
    echo json_encode(["message" => "Invalid request method."]);
}
?>
