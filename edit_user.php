<?php
$conn = pg_connect("host=localhost dbname=PROJECT user=postgres password=1035");
$id = $_GET['id'] ?? '';
if (!ctype_digit($id)) {
  die("Invalid ID.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $full_name = $_POST['full_name'];
  $phone_number = $_POST['phone_number'];
  $gender = $_POST['gender'];
  $dob = $_POST['dob'];

  $query = "UPDATE systemlogin SET full_name = $1, phone_number = $2, gender = $3, dob = $4 WHERE id = $5";
  $result = pg_query_params($conn, $query, [$full_name, $phone_number, $gender, $dob, $id]);
  if ($result) {
    echo "<script>parent.closeModal();</script>";
    exit();
  } else {
    echo "Update failed: " . pg_last_error($conn);
  }
}

$result = pg_query_params($conn, "SELECT * FROM systemlogin WHERE id = $1", [$id]);
$row = pg_fetch_assoc($result);
if (!$row) {
  die("User not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Edit User</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      padding: 20px;
      background: #f9f9f9;
    }
    h2 {
      text-align: center;
      color: #333;
    }
    form {
      background: #fff;
      border-radius: 8px;
      padding: 20px;
      max-width: 400px;
      margin: 0 auto;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    label {
      display: block;
      margin-top: 15px;
      color: #333;
    }
    input[type="text"],
    input[type="date"],
    select {
      width: 100%;
      padding: 8px 10px;
      margin-top: 5px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }
    button {
      margin-top: 20px;
      width: 100%;
      padding: 10px;
      background: #007BFF;
      border: none;
      color: #fff;
      font-weight: bold;
      border-radius: 4px;
      cursor: pointer;
    }
    button:hover {
      background: #0056b3;
    }
  </style>
</head>
<body>

  <h2>Edit User</h2>
  <form method="POST">
    <label>Full Name:</label>
    <input type="text" name="full_name" value="<?= htmlspecialchars($row['full_name']) ?>" required>

    <label>Phone Number:</label>
    <input type="text" name="phone_number" value="<?= htmlspecialchars($row['phone_number']) ?>" required>

    <label>Gender:</label>
    <select name="gender" required>
      <option value="Male" <?= $row['gender'] === 'Male' ? 'selected' : '' ?>>Male</option>
      <option value="Female" <?= $row['gender'] === 'Female' ? 'selected' : '' ?>>Female</option>
      <option value="Other" <?= $row['gender'] === 'Other' ? 'selected' : '' ?>>Other</option>
    </select>

    <label>Date of Birth:</label>
    <input type="date" name="dob" value="<?= htmlspecialchars($row['dob']) ?>" required>

    <button type="submit">Update</button>
  </form>

</body>
</html>
