<?php
// Include the PHPMailer library
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// Get the raw POST data
$data = json_decode(file_get_contents('php://input'), true);

// Extract user email, UID, location, booking number, date, and time
$userEmail = isset($data['userEmail']) ? $data['userEmail'] : '';
$uid = isset($data['uid']) ? $data['uid'] : '';
$location = isset($data['location']) ? $data['location'] : '';
$bookingNumber = isset($data['bookingNumber']) ? $data['bookingNumber'] : '';
$bookingDate = isset($data['bookingDate']) ? $data['bookingDate'] : '';
$bookingTime = isset($data['bookingTime']) ? $data['bookingTime'] : '';

if (empty($userEmail) || empty($uid) || empty($location) || empty($bookingNumber) || empty($bookingDate) || empty($bookingTime)) {
    echo json_encode([
        "status" => "error",
        "message" => "Missing required booking details."
    ]);
    exit();
}

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

    // Content
    $mail->isHTML(true);
    $mail->Subject = 'Booking Confirmation';
    $mail->Body    = "
        Dear user,<br><br>
        Your booking has been confirmed.<br><br>
        <strong>Location:</strong> $location<br>
        <strong>Booking Number:</strong> $bookingNumber<br>
        <strong>Date:</strong> $bookingDate<br>
        <strong>Time:</strong> $bookingTime<br><br>
        Thank you for using our service!
    ";
    
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
