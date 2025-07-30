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


// Get current user info
$query = "SELECT * FROM  WHERE id = $1";
$result = pg_query_params($conn, $query, [$id]);

if (!$result || pg_num_rows($result) !== 1) {
  die("User not found.");
}

$userData = pg_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $new_username = $_POST['username'];
  $new_password_raw = $_POST['password'];
  $hashed_password = password_hash($new_password_raw, PASSWORD_DEFAULT);

  $updateQuery = "UPDATE systemlogin SET username = $1, password = $2 WHERE id = $3";
  $updateResult = pg_query_params($conn, $updateQuery, [$new_username, $hashed_password, $id]);

  if ($updateResult) {
    echo "<script>alert('Username & password updated successfully!'); window.location.href='';</script>";
    exit;
  } else {
    echo "<p style='color:red;'>Update failed: " . pg_last_error($conn) . "</p>";
  }
}

pg_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Edit User Login</title>
  <style>
    body {
      background: #f4f6fb;
      font-family: 'Segoe UI', Arial, sans-serif;
      padding: 40px;
    }
    form{
        margin-right: 20px;
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

    input[type="text"],
    input[type="password"] {
      width: 100%;
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
    <h2>Edit Username & Password</h2>
    <form method="POST">
      <input type="hidden" name="id" value="<?= htmlspecialchars($userData['id']) ?>">

      <label for="username">Username:</label>
      <input type="text" id="username" name="username" value="<?= htmlspecialchars($userData['username']) ?>" required>

      <label for="password">New Password:</label>
      <input type="password" id="password" name="password" placeholder="Enter new password" required>

      <button type="submit">Update</button>
    </form>
  </div>
</body>
</html>
