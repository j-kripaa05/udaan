<?php
session_start();
include '../../db_connect.php';
require '../../vendor/autoload.php'; // Include Composer's autoloader

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);

    // Check if the email exists in either the workers or employers table
    $sql_worker = "SELECT * FROM workers WHERE email = ?";
    $stmt_worker = $conn->prepare($sql_worker);
    $stmt_worker->bind_param("s", $email);
    $stmt_worker->execute();
    $result_worker = $stmt_worker->get_result();

    $sql_employer = "SELECT * FROM employers WHERE email = ?";
    $stmt_employer = $conn->prepare($sql_employer);
    $stmt_employer->bind_param("s", $email);
    $stmt_employer->execute();
    $result_employer = $stmt_employer->get_result();

    if ($result_worker->num_rows > 0 || $result_employer->num_rows > 0) {
        // Email exists, generate OTP
        $otp = rand(100000, 999999);

        // Store OTP and email in session
        $_SESSION['otp'] = $otp;
        $_SESSION['email'] = $email;

        // Send OTP via email using PHPMailer
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com'; // Set the SMTP server to send through
            $mail->SMTPAuth   = true;
            $mail->Username   = 'udaan.ngoproject@gmail.com'; // SMTP username (your Gmail address)
            $mail->Password   = 'utjx sstc joce rdxi'; // SMTP password (your Gmail app password)
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;

            //Recipients
            $mail->setFrom('udaan.ngoproject@gmail.com', 'Udaan');
            $mail->addAddress($email);

            //Content
            $mail->isHTML(true);
            $mail->Subject = 'Your Password Reset OTP for Udaan';
            $mail->Body    = "Your OTP for password reset is: <b>$otp</b>";

            $mail->send();

            // Redirect to the OTP verification page
            header("Location: reset-password.php");
            exit();
        } catch (Exception $e) {
            $_SESSION['error'] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            header("Location: forgot-password.php");
            exit();
        }

    } else {
        // Email does not exist
        $_SESSION['error'] = "No account found with that email address.";
        header("Location: forgot-password.php");
        exit();
    }
}
?>