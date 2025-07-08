<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get posted data safely
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Connect to PostgreSQL
    $conn = pg_connect("host=localhost dbname=project user=postgres password=1035");
    if (!$conn) {
        die("Connection failed.");
    }

    // Query to fetch user
    $result = pg_query_params(
        $conn,
        "SELECT * FROM system_admin WHERE username = $1 AND admin_type = 'system_admin'",
        [$username]
    );

    if ($row = pg_fetch_assoc($result)) {
        if (password_verify($password, $row['password'])) {
            // Valid credentials → generate OTP
            $otp = random_int(100000, 999999);

            // Save OTP and username temporarily in session
            $_SESSION['otp'] = $otp;
            $_SESSION['temp_user'] = $username;
echo"<script>window.location.href='system_dashboard.html'</script>";

            // Show OTP form
            ?>
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8" />
                <title>Enter OTP</title>
                <link rel="stylesheet" href="system_admin_login.css" />
            </head>
            <body>
                <div class="login-container">
                    <h1>Enter OTP</h1>
                    <p>Your OTP is: <strong><?php echo htmlspecialchars($otp); ?></strong></p> <!-- Only for testing -->
                    <form method="POST" action="SA_otp.php">
                        <label for="otp">OTP:</label>
                        <input type="number" id="otp" name="otp" placeholder="Enter OTP" required />
                        <button type="submit">Verify OTP</button>
                    </form>
                </div>
            </body>
            </html>
            <?php
            pg_close($conn);
            exit();
        } else {
            $message = "Invalid password.";
        }
    } else {
        $message = "User not found or not a system admin.";
    }

    pg_close($conn);
}
?>


