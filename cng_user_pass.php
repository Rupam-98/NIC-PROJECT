<?php
session_start();
$conn = pg_connect("host=localhost dbname=PROJECT user=postgres password=1035");

if (!isset($_SESSION['id'])) {
    die("Unauthorized access.");
}

$id = $_SESSION['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    $query = "SELECT password FROM admins WHERE id = $1";
    $result = pg_query_params($conn, $query, [$id]);
    $row = pg_fetch_assoc($result);

    if (!$row || !password_verify($current_password, $row['password'])) {
        echo "<script>alert('Current password is incorrect');</script>";
    } elseif ($new_password !== $confirm_password) {
        echo "<script>alert('New password and confirm password do not match');</script>";
    } else {
        $hashed_new = password_hash($new_password, PASSWORD_DEFAULT);
        $update = pg_query_params($conn, "UPDATE admins SET password = $1 WHERE id = $2", [$hashed_new, $id]);
        if ($update) {
            echo "<script>alert('Updated successfully'); window.parent.closeIframeModal();</script>";
            exit;
        } else {
            echo "Update failed: " . pg_last_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Change Password</title>
    <style>
        body {
          background: #eef2f7;
          font-family: Arial, sans-serif;
          padding: 40px;
        }
        form {
          background: #fff;
          padding: 30px;
          max-width: 450px;
          margin: auto;
          border-radius: 8px;
          box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 {
          text-align: center;
          margin-bottom: 20px;
        }
        input {
          width: 100%;
          padding: 10px;
          margin: 10px 0;
          border-radius: 5px;
          border: 1px solid #ccc;
        }
        button {
          width: 100%;
          padding: 10px;
          background-color: #007BFF;
          border: none;
          color: white;
          font-weight: bold;
          border-radius: 5px;
          cursor: pointer;
        }
        button:hover {
          background-color: #0056b3;
        }
    </style>
</head>
<body>
    <form method="POST">
        <h2>Change Password</h2>
        <input type="password" name="current_password" placeholder="Current Password" required>
        <input type="password" name="new_password" placeholder="New Password" required>
        <input type="password" name="confirm_password" placeholder="Confirm New Password" required>
        <button type="submit">Update Password</button>
    </form>
</body>
</html>
