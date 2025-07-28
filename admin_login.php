<?php
session_start();

$host = "localhost";
$dbname = "PROJECT";
$user = "postgres";
$password = "1035";
$conn = pg_connect("host=$host dbname=$dbname user=$user password=$password");

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $pass = $_POST['password'];
    $userOTP = $_POST['otp'] ?? '';
    $generatedOTP = $_POST['generatedOtp'] ?? '';

    // Validate OTP
    if ($generatedOTP === '' || $userOTP !== $generatedOTP) {
        $error = "Invalid OTP!";
    } else {
        // Check username and password
        $query = "SELECT * FROM admins WHERE username = $1";
        $result = pg_query_params($conn, $query, [$username]);

        if (pg_num_rows($result) === 1) {
            $admin = pg_fetch_assoc($result);

            if (password_verify($pass, $admin['password'])) {
                $_SESSION['username'] = $admin['username'];
                $_SESSION['role'] = $admin['role'];
                $_SESSION['dept_code'] = $admin['dept_code'];
                $_SESSION['branch_code'] = $admin['branch_code'];

                if ($admin['role'] == 'super_admin') {
                    header("Location: system_dashboard.php");
                } elseif ($admin['role'] == 'department_admin') {
                    header("Location: dept_dashboard.php");
                } elseif ($admin['role'] == 'branch_admin') {
                    header("Location: branch_dashboard.php");
                }
                exit();
            } else {
                $error = "Invalid username or password!";
            }
        } else {
            $error = "Invalid username or password!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Admin Login</title>
  <style>
    /* Basic styling */
    * {
      box-sizing: border-box;
      margin: 0; padding: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
      background: #f0f4f8;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
    }

    .login-box {
      background: #ffffff;
      padding: 40px 30px;
      width: 360px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.1);
      border-radius: 12px;
    }

    .login-box h2 {
      text-align: center;
      margin-bottom: 24px;
      color: #333;
    }

    .login-box input {
      width: 100%;
      padding: 12px;
      margin-bottom: 16px;
      border: 1px solid #ccc;
      border-radius: 8px;
    }

    .login-box button {
      width: 100%;
      padding: 12px;
      background-color: #007bff;
      color: #fff;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      cursor: pointer;
      margin-bottom: 10px;
    }

    .login-box button:hover {
      background-color: #0056b3;
    }

    .error {
      color: red;
      text-align: center;
      margin-bottom: 15px;
      font-size: 14px;
    }

    #otpWrapper {
      display: none;
    }
  </style>

  <script>
    let generatedOTP = '';

    function generateOTP(event) {
      event.preventDefault();
      generatedOTP = Math.floor(100000 + Math.random() * 900000).toString();
      alert("Your OTP is: " + generatedOTP);

      document.getElementById('generatedOtp').value = generatedOTP;
      document.getElementById('otpWrapper').style.display = 'block';
    }

    function validateForm(event) {
      const enteredOTP = document.getElementById('otp').value;
      const generated = document.getElementById('generatedOtp').value;

      if (!generated || enteredOTP !== generated) {
        alert("Invalid or missing OTP.");
        event.preventDefault();
        return false;
      }

      return true;
    }
  </script>
</head>
<body>
  <div class="login-box">
    <h2>Admin Login</h2>

    <?php if ($error): ?>
      <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST" action="" onsubmit="return validateForm(event)">
      <input type="text" name="username" placeholder="Username" required />
      <input type="password" name="password" placeholder="Password" required />

      <!-- Hidden generated OTP input -->
      <input type="hidden" id="generatedOtp" name="generatedOtp" />

      <!-- OTP Field -->
      <div id="otpWrapper">
        <input type="text" id="otp" name="otp" placeholder="Enter OTP" />
      </div>

      <button onclick="generateOTP(event)">Generate OTP</button>
      <button type="submit">Login</button>
    </form>
  </div>
</body>
</html>
