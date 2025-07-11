<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    // You can also check $_POST['otp'] if you want

    $conn = pg_connect("host=localhost dbname=PROJECT user=postgres password=695847");

    if (!$conn) {
        die("Connection failed.");
    }

    $result = pg_query_params($conn, "SELECT * FROM systemlogin WHERE username = $1 AND admin_type = 'system_admin'", [$username]);

    if ($row = pg_fetch_assoc($result)) {
        if (password_verify($password, $row['password'])) {
            $_SESSION['system_admin'] = $username;
            header("Location: system_dashboard.html");
            exit();
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "User not found.";
    }

    pg_close($conn);
} else {
    echo "Invalid request.";
}
?>
