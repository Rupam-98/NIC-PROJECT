<?php
session_start();
$host = "localhost";
$dbname = "PROJECT";
$user = "postgres";
$password = "1035";
$conn = pg_connect("host=$host dbname=$dbname user=$user password=$password");

if (!$conn) {
    http_response_code(500);
    echo json_encode(['error' => 'Database connection failed']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $otp = rand(100000, 999999);
    $_SESSION['otp'] = $otp;
    $_SESSION['otp_username'] = $username;

    // For now, return OTP in response (replace this with SMS/email in production)
    echo json_encode(['otp' => $otp, 'message' => "OTP for $username is $otp"]);
    exit();
}
?>
