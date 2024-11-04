<?php
// Include the PHPMailer library
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// Retrieve JSON data from POST request
$data = json_decode(file_get_contents('php://input'), true);

// Extract user email and reservation details
$userEmail = $data['userEmail'];
$reservationDetails = $data['reservationDetails'];

// Set up PHPMailer
$mail = new PHPMailer(true);
try {
    // Server settings
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; // Set the SMTP server to send through
    $mail->SMTPAuth = true;
    $mail->Username = 'coworkingspacereservation101@gmail.com';
    $mail->Password = 'ezxf eksq qfuj rbpp';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Recipients
    $mail->setFrom('coworkingspacereservation101@gmail.com', 'Coworking Space Reservation');
    $mail->addAddress($userEmail);

    // Email content
    $mail->isHTML(true); // Set email format to HTML
    $mail->Subject = 'Your Coworking Space Reservation Confirmation';

    // Create the email body with reservation details
    $mail->Body = "
        <h1>Reservation Confirmation</h1>
        <p>Thank you for reserving with us! Here are your reservation details:</p>
        <ul>
            <li><strong>Name:</strong> {$reservationDetails['name']}</li>
            <li><strong>Email:</strong> {$reservationDetails['email']}</li>
            <li><strong>Phone Number:</strong> {$reservationDetails['phoneNumber']}</li>
            <li><strong>Check-in Date:</strong> {$reservationDetails['checkInDate']}</li>
            <li><strong>Check-out Date:</strong> {$reservationDetails['checkOutDate']}</li>
            <li><strong>Payment Amount:</strong> {$reservationDetails['paymentAmount']}</li>
        </ul>
        <p>We look forward to your visit!</p>
    ";

    // Send the email
    $mail->send();
    echo json_encode([
        "status" => "success",
        "message" => "Email sent successfully."
    ]);
} catch (Exception $e) {
    echo json_encode([
        "status" => "error",
        "message" => "Mailer Error: " . $mail->ErrorInfo
    ]);
}
?>
