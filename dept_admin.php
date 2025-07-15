<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get data from form
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // These come from client-side JS only
    $userOTP = $_POST['otp'] ?? '';
    $generatedOTP = $_POST['generatedOtp'] ?? '';

    // Server-side OTP check (optional but safer)
    if ($userOTP !== $generatedOTP) {
        die("Invalid OTP.");
    }

    if (empty($username) || empty($password)) {
        die("Username and password are required.");
    }

    $conn = pg_connect("host=localhost dbname=PROJECT user=postgres password=695847");
    if (!$conn) {
        die("Connection failed.");
    }

    // Look up user
    $query = "SELECT * FROM dept_admins WHERE username = $1";
    $result = pg_query_params($conn, $query, [$username]);

    if ($result && pg_num_rows($result) === 1) {
        $row = pg_fetch_assoc($result);

        if (password_verify($password, $row['password'])) {
            $_SESSION['dept_admin_id'] = $row['id'];
            $_SESSION['dept_admin_username'] = $row['username'];

            echo "Login successful! Welcome, " . htmlspecialchars($row['officer_name']) . ".";

            // Redirect to dashboard if needed
             header("Location: dept_dashboard.html");
            // exit;

        } else {
            echo "Incorrect password.";
        }
    } else {
        echo "User not found.";
    }

    pg_close($conn);
} else {
    echo "Invalid request.";
}
?>
