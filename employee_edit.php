<?php
// === DB CONNECTION ===
$host = "localhost";
$dbname = "PROJECT";
$user = "postgres";
$password = "1035";

$conn = pg_connect("host=$host dbname=$dbname user=$user password=$password");
if (!$conn) {
    die("Connection failed: " . pg_last_error());
}

if (!isset($_GET['slno'])) {
    die("No employee ID specified.");
}

$slno = $_GET['slno'];

$query = "SELECT * FROM employees WHERE slno = $1";
$result = pg_query_params($conn, $query, [$slno]);

if (!$row = pg_fetch_assoc($result)) {
    die("Employee not found.");
}

// === HANDLE UPDATE ===
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fields = [
        'depcode', 'department', 'branch_code', 'branch_address',
        'name', 'desig', 'sex', 'age', 'epic', 'phone',
        'home_lac', 'residential_lac', 'branch_lac', 'beeo_code',
        'basic', 'gazeted', 'remarks', 'education', 'dor',
        'ac_no', 'ifsc_code', 'branch_name', 'bank_branch_address'
    ];

    $values = [];
    foreach ($fields as $field) {
        $values[] = $_POST[$field] ?? null;
    }
    $values[] = $slno;

    $set = implode(", ", array_map(
        fn($f, $i) => "$f = $" . ($i + 1),
        $fields,
        array_keys($fields)
    ));

    $sql = "UPDATE employees SET $set WHERE slno = $" . (count($fields) + 1);

    $update_result = pg_query_params($conn, $sql, $values);

    if ($update_result) {
        echo "<script>alert('Employee updated successfully!'); window.location.href = 'employee_list.php';</script>";
        exit();
    } else {
        echo "Update failed: " . pg_last_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Edit Employee</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f4f7f8;
      padding: 0;
      margin: 0;
    }

    .sidebar {
      position: fixed;
      top: 0;
      left: 0;
      width: 275px;
      height: 100vh;
      background: #2c3e50;
      color: #fff;
      overflow-y: auto;
    }

    .sidebar .welcome-section {
      text-align: center;
      padding: 30px 20px 20px;
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .sidebar .welcome-section img {
      width: 70px;
      height: 70px;
      border-radius: 50%;
      object-fit: cover;
      margin-bottom: 10px;
      border: 2px solid #3498db;
    }

    .sidebar .welcome-section h3 {
      margin: 5px 0 0;
    }

    .sidebar .welcome-section p {
      margin: 5px 0 0;
      font-size: 14px;
      color: #ddd;
    }

    .sidebar ul {
      list-style: none;
      padding: 0;
      margin-top: 20px;
    }

    .sidebar ul li {
      border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }

    .sidebar ul li a {
      color: #fff;
      text-decoration: none;
      display: block;
      padding: 15px 20px;
      transition: all 0.5s ease;
    }

    .sidebar ul li a:hover {
      background: #3498db;
      padding-left: 30px;
    }

    .sidebar ul li ul {
      display: none;
      list-style: none;
      padding-left: 20px;
    }

    .sidebar ul li.active > ul {
      display: block;
    }

    .sidebar ul li ul li {
      padding: 8px 10px;
      color: #fff;
    }

    .sidebar ul li ul li:hover {
      background: #555;
      cursor: pointer;
    }

    .sidebar i {
      margin-right: 10px;
    }

    .container {
      margin-left: 275px;
      padding: 40px;
      max-width: 900px;
    }

    .edit-form {
      background: #fff;
      position: relative;
      left: 125px;
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    }

    .edit-form h2 {
      text-align: center;
      margin-bottom: 20px;
    }

    .edit-form label {
      display: block;
      margin: 10px 0 5px;
      font-weight: bold;
    }

    .edit-form input, .edit-form select {
      width: 100%;
      padding: 8px;
      margin-bottom: 10px;
      border: 1px solid #ccc;
      border-radius: 6px;
    }

    .edit-form button {
      width: 100%;
      padding: 12px;
      background: #007bff;
      color: #fff;
      border: none;
      border-radius: 6px;
      font-size: 16px;
      cursor: pointer;
      margin-top: 15px;
    }

    .edit-form button:hover {
      background: #0056b3;
    }
  </style>
</head>
<body>

<div class="sidebar">
  <div class="welcome-section">
    <img src="image/user.jpg" alt="User" />
    <h3>Welcome!</h3>
    <p>Branch Admin</p>
  </div>
  <ul>
    <li><a href="branch_dashboard.html"><i class="fas fa-home"></i> Home</a></li>
    <li><a href="#"><i class="fas fa-user"></i> Profile</a></li>
    <li class="dropdown">
      <a href="#" onclick="toggleDropdown(event)">
        <i class="fas fa-users"></i> Employees <i class="fa fa-plus"></i>
      </a>
      <ul>
        <li><a href="employee_list.php">Employee List</a></li>
        <li><a href="employee.php">Employee Entry</a></li>
      </ul>
    </li>
    <li><a href="#"><i class="fas fa-chart-line"></i> Reports</a></li>
    <li><a href="#"><i class="fas fa-cog"></i> Settings</a></li>
    <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
  </ul>
</div>

<div class="container">
  <form class="edit-form" method="POST">
    <h2>Edit Employee</h2>

    <?php
    function input($label, $name, $value) {
      echo "<label>$label</label><input type='text' name='$name' value='" . htmlspecialchars($value) . "' required>";
    }

    input('Dept Code', 'depcode', $row['depcode']);
    input('Department', 'department', $row['department']);
    input('Branch Code', 'branch_code', $row['branch_code']);
    input('Branch Address', 'branch_address', $row['branch_address']);
    input('Name', 'name', $row['name']);
    input('Designation', 'desig', $row['desig']);
    ?>

    <label>Gender</label>
    <select name="sex" required>
      <option value="Male" <?= $row['sex'] === 'Male' ? 'selected' : '' ?>>Male</option>
      <option value="Female" <?= $row['sex'] === 'Female' ? 'selected' : '' ?>>Female</option>
      <option value="Other" <?= $row['sex'] === 'Other' ? 'selected' : '' ?>>Other</option>
    </select>

    <?php
    echo "<label>Age</label><input type='number' name='age' value='" . htmlspecialchars($row['age']) . "' required>";
    input('Voter (Epic)', 'epic', $row['epic']);
    input('Phone', 'phone', $row['phone']);
    input('Home LAC', 'home_lac', $row['home_lac']);
    input('Residential LAC', 'residential_lac', $row['residential_lac']);
    input('Branch LAC', 'branch_lac', $row['branch_lac']);
    input('BEEO Code', 'beeo_code', $row['beeo_code']);
    input('Basic', 'basic', $row['basic']);
    input('Gazeted', 'gazeted', $row['gazeted']);
    input('Remarks', 'remarks', $row['remarks']);
    input('Education', 'education', $row['education']);
    echo "<label>Date of Retirement</label><input type='date' name='dor' value='" . htmlspecialchars($row['dor']) . "'>";
    input('A/c No', 'ac_no', $row['ac_no']);
    input('IFSC Code', 'ifsc_code', $row['ifsc_code']);
    input('Branch Name', 'branch_name', $row['branch_name']);
    input('Bank Branch Address', 'bank_branch_address', $row['bank_branch_address']);
    ?>

    <button type="submit">Update Employee</button>
  </form>
</div>

<script>
function toggleDropdown(event) {
  event.preventDefault();
  const li = event.target.closest('li');
  li.classList.toggle('active');

  const icon = li.querySelector('.fa-plus, .fa-minus');
  if (li.classList.contains('active')) {
    icon.classList.remove('fa-plus');
    icon.classList.add('fa-minus');
  } else {
    icon.classList.remove('fa-minus');
    icon.classList.add('fa-plus');
  }
}
</script>

</body>
</html>

<?php pg_close($conn); ?>
