<?php
session_start();
require_once "config.php";

$email = $_SESSION['account']['email'];
$generateCode = $_SESSION["$email-generated"];
$generated = $_POST['generated'];
if ($generateCode == $generated) {
    $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($_SESSION['account']['aCompany'] == "0") {
        $query = "UPDATE users SET verified = ? WHERE email = ?";
    } else {
        $query = "UPDATE company SET verified = ? WHERE email = ?";
    }

    $stmt = $conn->prepare($query);
    $verified = 1;

    if ($stmt) {
        $stmt->bind_param("is", $verified, $email);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $_SESSION['verified'] = true;
            $_SESSION['success'] = "Account verified successfully.";
        } else {
            $_SESSION['error'] = "Verification failed. Please try again." . $email . $generateCode . $generated;
        }

        $stmt->close();
    } else {
        $_SESSION['error'] = "Error in preparing the query.";
    }

    $conn->close();
} else {
    $_SESSION['error'] = "Verification code does not match.";
}
header('Location: ../index.php');
exit;
?>