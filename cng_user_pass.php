<?php
$host = "localhost";
$dbname = "PROJECT";
$user = "postgres";
$password = "1035";

$conn = pg_connect("host=$host dbname=$dbname user=$user password=$password");
if (!$conn) {
  die("Connection failed: " . pg_last_error());
}

$id = $_GET['id'] ?? null;
if (!$id) {
  die("No user ID specified.");
}

// Fetch existing password hash
$query = "SELECT * FROM admins WHERE id = $1";
$result = pg_query_params($conn, $query, [$id]);

if (!$result || pg_num_rows($result) !== 1) {
  die("User not found.");
}

$userData = pg_fetch_assoc($result);
$stored_hashed_password = $userData['password'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $old_password = $_POST['old_password'];
  $new_password = $_POST['new_password'];
  $confirm_password = $_POST['confirm_password'];

  // 1. Check old password
  if (!password_verify($old_password, $stored_hashed_password)) {
    echo "<script>alert('Old password is incorrect.');</script>";
  }
  // 2. Check new and confirm match
  elseif ($new_password !== $confirm_password) {
    echo "<script>alert('New password and confirm password do not match.');</script>";
  }
  else {
    // 3. Update password
    $hashed_new = password_hash($new_password, PASSWORD_DEFAULT);
    $updateQuery = "UPDATE admins SET password = $1 WHERE id = $2";
    $updateResult = pg_query_params($conn, $updateQuery, [$hashed_new, $id]);

    if ($updateResult) {
      echo "<script>alert('Updated successfully'); window.parent.closeIframeModal();</script>";
      exit;
    } else {
      echo "<p style='color:red;'>Update failed: " . pg_last_error($conn) . "</p>";
    }
  }
}

pg_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Change Password</title>
  <style>
    body {
      background: #f4f6fb;
      font-family: 'Segoe UI', Arial, sans-serif;
      padding: 40px;
    }
    .edit-container {
      max-width: 420px;
      margin: auto;
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
      padding: 30px;
    }

    .edit-container h2 {
      text-align: center;
      margin-bottom: 24px;
    }

    label {
      display: block;
      margin-bottom: 6px;
      font-weight: 500;
      color: #333;
    }

    input[type="password"] {
      width: 95%;
      padding: 10px 12px;
      margin-bottom: 18px;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 1rem;
    }

    button {
      width: 100%;
      background: #4f8cff;
      color: #fff;
      border: none;
      border-radius: 6px;
      padding: 12px 0;
      font-size: 1rem;
      cursor: pointer;
      transition: background 0.2s;
    }

    button:hover {
      background: #2355d6;
    }
  </style>
</head>
<body>
  <div class="edit-container">
    <h2>Change Password</h2>
    <form method="POST">
      <input type="hidden" name="id" value="<?= htmlspecialchars($userData['id']) ?>">

      <label for="old_password">Old Password:</label>
      <input type="password" id="old_password" name="old_password" required>

      <label for="new_password">New Password:</label>
      <input type="password" id="new_password" name="new_password" required>

      <label for="confirm_password">Confirm New Password:</label>
      <input type="password" id="confirm_password" name="confirm_password" required>

      <button type="submit">Update Password</button>
    </form>
  </div>
</body>
</html>
