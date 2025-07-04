<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $enteredOtp = $_POST['otp'];

    if (isset($_SESSION['otp']) && isset($_SESSION['temp_user'])) {
        if ($enteredOtp == $_SESSION['otp']) {
            // OTP is valid → log the user in
            $_SESSION['system_admin'] = $_SESSION['temp_user'];

            // Clean up
            unset($_SESSION['otp']);
            unset($_SESSION['temp_user']);

            header("Location: system_dashboard.html");
            exit();
        } else {
            echo "Invalid OTP. <a href='system_admin_login.html'>Try again</a>";
        }
    } else {
        echo "Session expired. <a href='system_admin_login.html'>Login again</a>";
    }
} else {
    echo "Invalid request.";
}
?>
