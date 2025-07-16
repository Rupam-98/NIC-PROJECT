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

    $conn = pg_connect("host=localhost dbname=PROJECT user=postgres password=1035");
    if (!$conn) {
        die("Connection failed.");
    }

    // Look up user
    $query = "SELECT * FROM branch_admins WHERE username = $1";
    $result = pg_query_params($conn, $query, [$username]);

    if ($result && pg_num_rows($result) === 1) {
        $row = pg_fetch_assoc($result);

        if (password_verify($password, $row['password'])) {
            $_SESSION['branch_admin_id'] = $row['id'];
            $_SESSION['branch_admin_username'] = $row['username'];

            echo "Login successful! Welcome, " . htmlspecialchars($row['officer_name']) . ".";

            // Redirect to dashboard if needed
             header("Location: branch_dashboard.html");
            // exit;

        } else {
            echo "Incorrect password.";
        }
    } else {
        echo "User not found.";
    }

    pg_close($conn);
} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Branch Admin Login Page</title>
  <link rel="stylesheet" href="branch_admin_login.css" />
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
    <form id="loginForm" method="POST" action=" " onsubmit="return validateForm(event)">
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

