<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    // You can also check $_POST['otp'] if you want

    $conn = pg_connect("host=localhost dbname=PROJECT user=postgres password=1035");

    if (!$conn) {
        die("Connection failed.");
    }

    $result = pg_query_params($conn, "SELECT * FROM systemlogin WHERE username = $1 AND admin_type = 'system_admin'", [$username]);

    if ($row = pg_fetch_assoc($result)) {

        if (password_verify($password, $row['password'])) {
          $_SESSION['user_id'] = $row['id']; 
            $_SESSION['system_admin'] = $username;
            header("Location: system_dashboard.php");
            exit();
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "User not found.";
    }

    pg_close($conn);
//   else {
//     echo "Invalid request.";

}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>System Login Page</title>
  <link rel="stylesheet" href="system_admin_login.css" />
  <script>
    let generatedOTP = '';

    function generateOTP() {
      // Generate random 6-digit OTP
      generatedOTP = Math.floor(100000 + Math.random() * 900000).toString();
      alert("Your OTP is: " + generatedOTP);

      // Fill hidden input with generated OTP
      document.getElementById('generatedOtp').value = generatedOTP;

      // Show OTP input field
      document.getElementById('otpWrapper').style.display = 'block';
    }

    function validateForm(event) {
      const userOTP = document.getElementById('otp').value;
      const generated = document.getElementById('generatedOtp').value;

      if (generated === '') {
        alert('Please generate an OTP first.');
        event.preventDefault();
        return false;
      }

      if (userOTP !== generated) {
        alert('Invalid OTP.');
        event.preventDefault();
        return false;
      }

      // else allow form to submit
      return true;
    }
  </script>
</head>
<body>
  <div class="login-container">
    <h1>Admin Login</h1>
    <form id="loginForm" method="POST" action="" onsubmit="return validateForm(event)">
      <label for="username">Username:</label>
      <input type="text" id="username" name="username" placeholder="Enter your Username" required />

      <label for="password">Password:</label>
      <input type="password" id="password" name="password" placeholder="Enter your password" required />

      <!-- Hidden input to store generated OTP -->
      <input type="hidden" id="generatedOtp" name="generatedOtp" />

      <!-- OTP input field (hidden at first) -->
      <div id="otpWrapper" style="display:none;">
        <label for="otp">Enter OTP:</label>
        <input type="text" id="otp" name="otp" placeholder="Enter the OTP" required />
      </div>

      <button type="submit" onclick="generateOTP()">Generate OTP</button>
      <button type="submit">Login</button>
    </form>
  </div>
</body>
</html>

