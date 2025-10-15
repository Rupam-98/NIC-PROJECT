<?php
session_start();

$conn = pg_connect("host=localhost dbname=PROJECT user=postgres password=1035");

if (!isset($_SESSION['id'])) {
  die("Unauthorized access.");
}

$id = $_SESSION['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $officer_name = $_POST['officer_name'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];

  $query = "UPDATE admins SET officer_name = $1, email = $2, phone = $3 WHERE id = $4";
  $result = pg_query_params($conn, $query, [$officer_name, $email, $phone, $id]);

  if ($result) {
    echo "<script>alert('Update successful!'); window.parent.closeIframeModal();</script>";
    exit();
  } else {
    echo "error: " . pg_last_error($conn);
  }
}

$result = pg_query_params($conn, "SELECT * FROM admins WHERE id = $1", [$id]);
$row = pg_fetch_assoc($result);
if (!$row) {
  die("User not found.");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Edit Admin Info</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      padding: 20px;
      background: #f4f4f4;
    }

    form {
      background: #fff;
      padding: 20px;
      border-radius: 8px;
      max-width: 500px;
      margin: auto;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h2 {
      text-align: center;
      color: #333;
    }

    label {
      display: block;
      margin-top: 15px;
    }

    input {
      width: 96%;
      padding: 10px;
      margin-top: 5px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    button {
      margin-top: 20px;
      width: 100%;
      padding: 10px;
      background-color: #28a745;
      color: white;
      border: none;
      border-radius: 4px;
      font-weight: bold;
      cursor: pointer;
    }

    button:hover {
      background-color: #218838;
    }
  </style>
</head>

<body>
  <form method="POST">
    <h2>Update Profile</h2>
    <label>Officer Name:</label>
    <input type="text" name="officer_name" value="<?= htmlspecialchars($row['officer_name']) ?>" required>

    <label>Email:</label>
    <input type="email" name="email" value="<?= htmlspecialchars($row['email']) ?>" required>

    <label>Phone:</label>
    <input type="text" name="phone" value="<?= htmlspecialchars($row['phone']) ?>" required>

    <button type="submit">Update</button>
  </form>

</body>

</html>