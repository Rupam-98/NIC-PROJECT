<?php
$conn = pg_connect("host=localhost dbname=PROJECT user=postgres password=1035");

$id = $_GET['id'] ?? null;

if (!$id || !ctype_digit($id)) {
    die("Invalid ID.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $officer_name = $_POST['officer_name'];
    $designation = $_POST['designation'];
    $district = $_POST['district'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $query = "UPDATE admins SET officer_name = $1, district = $2, email = $3, phone = $4 WHERE id = $5";
    $result = pg_query_params($conn, $query, [$officer_name, $district, $email, $phone, $id]);

    if ($result) {
        echo "<script>alert('User updated successfully.'); window.location.href='view_admins.php';</script>";
        exit();
    } else {
        echo "Update failed: " . pg_last_error($conn);
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
  <title>Edit Admin User</title>
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
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
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
      width: 100%;
      padding: 8px;
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

<h2>Edit Admin Info</h2>
<form method="POST">
  <label>Officer Name:</label>
  <input type="text" name="officer_name" value="<?= htmlspecialchars($row['officer_name']) ?>" required>

  <!-- <label>Designation:</label>
  <input type="text" name="designation" value="<?= htmlspecialchars($row['designation']) ?>" required> -->

      <label for="district">Office District</label>
    <select id="district" name="district" required>
      <option value="">District Name</option>
      <option value="Bajali">Bajali</option>
      <option value="Baksa">Baksa</option>
      <option value="Barpeta">Barpeta</option>
      <option value="Biswanath">Biswanath</option>
      <option value="Bongaigaon">Bongaigaon</option>
      <option value="Cachar">Cachar</option>
      <option value="Charaideo">Charaideo</option>
      <option value="Chirang">Chirang</option>
      <option value="Darrang">Darrang</option>
      <option value="Dhemaji">Dhemaji</option>
      <option value="Dhubri">Dhubri</option>
      <option value="Dibrugarh">Dibrugarh</option>
      <option value="Dima Hasao">Dima Hasao</option>
      <option value="Goalpara">Goalpara</option>
      <option value="Golaghat">Golaghat</option>
      <option value="Hailakandi">Hailakandi</option>
      <option value="Hojai">Hojai</option>
      <option value="Jorhat">Jorhat</option>
      <option value="Kamrup Metropolitan">Kamrup Metropolitan</option>
      <option value="Kamrup">Kamrup</option>
      <option value="Karbi Anglong">Karbi Anglong</option>
      <option value="Karimganj">Karimganj</option>
      <option value="Kokrajhar">Kokrajhar</option>
      <option value="Lakhimpur">Lakhimpur</option>
      <option value="Majuli">Majuli</option>
      <option value="Morigaon">Morigaon</option>
      <option value="Nagaon">Nagaon</option>
      <option value="Nalbari">Nalbari</option>
      <option value="Sivasagar">Sivasagar</option>
      <option value="Sonitpur">Sonitpur</option>
      <option value="South Salmara-Mankachar">South Salmara-Mankachar</option>
      <option value="Tamulpur">Tamulpur</option>
      <option value="Tinsukia">Tinsukia</option>
      <option value="Udalguri">Udalguri</option>
      <option value="West Karbi Anglong">West Karbi Anglong</option>
    </select>

  <label>Email:</label>
  <input type="email" name="email" value="<?= htmlspecialchars($row['email']) ?>" required>

  <label>Phone:</label>
  <input type="text" name="phone" value="<?= htmlspecialchars($row['phone']) ?>" required>

  <button type="submit">Update</button>
</form>

</body>
</html>
