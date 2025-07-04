<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // PostgreSQL connection
    $conn = pg_connect("host=localhost dbname=PROJECT user=postgres password=695847");
    if (!$conn) {
        die("Connection failed.");
    }

    $result = pg_query_params($conn, "SELECT * FROM systemlogin WHERE username = $1 AND admin_type = 'system_admin'", [$username]);

    if ($row = pg_fetch_assoc($result)) {
        if (password_verify($password, $row['password'])) {
            // Credentials valid → generate OTP
            $otp = random_int(100000, 999999);

            $_SESSION['otp'] = $otp;
            $_SESSION['temp_user'] = $username; // Save username temporarily

            // Show OTP input form
            echo "
                <script>alert('Your OTP is: $otp');</script>
                <h2>Enter OTP</h2>
                <form method='POST' action='SA_otp.php'>
                    <label for='otp'>OTP:</label>
                    <input type='number' name='otp' required />
                    <button type='submit'>Verify OTP</button>
                </form>
            ";
           
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "User not found or not a system admin.";
    }

    pg_close($conn);
} else {
    echo "Invalid request.";
}
?>
