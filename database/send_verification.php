<?php
session_start();
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('config.php');
require_once __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$generateCode = rand(100000, 999999);
if (!isset($_SESSION['account']['email'])) {
    echo json_encode(['success' => false, 'error' => 'Session email not found']);
    exit;
}

$email = $_SESSION['account']['email'];
$_SESSION["$email-generated"] = $generateCode;

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'jdmaster888@gmail.com';  
    $mail->Password = 'mxvj qric haou eibj';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $text = "verification";
    $mail->setFrom('jdmaster888@gmail.com', 'Your Name or App Name');
    $mail->addAddress($email);
    $mail->Subject = "Your $text Code";
    $mail->Body = "Your $text code is: $generateCode";

    $mail->send();
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $mail->ErrorInfo]);
}
