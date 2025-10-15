<?php
session_start();

$host = "localhost";
$port = "5432";
$dbname = "PROJECT";
$user = "postgres";
$password = "1035";

$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");
if (!$conn) {
    die("Connection failed: " . pg_last_error());
}

include 'admin.php';

$loggedInDeptCode = $_SESSION['dept_code'] ?? '';
if (empty($loggedInDeptCode)) {
    die("Access denied. No department code in session.");
}

// Fetch department details
$dept_result = pg_query_params(
    $conn,
    "SELECT dept_code, dept_name FROM dept_entry WHERE dept_code = $1",
    [$loggedInDeptCode]
);
$deptData = pg_fetch_assoc($dept_result);
if (!$deptData) {
    die("Department not found.");
}

// Fetch branches for this department
$branch_result = pg_query_params(
    $conn,
    "SELECT branch_code, branch_name FROM branches WHERE dept_code = $1 ORDER BY branch_code ASC",
    [$loggedInDeptCode]
);
$branches = [];
while ($row = pg_fetch_assoc($branch_result)) {
    $branches[] = $row;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $deptCode = $deptData['dept_code'];
    $deptName = $deptData['dept_name'];
    $branchCode = $_POST['branchCode'];
    $branchName = $_POST['branchName'];
    $officerName = $_POST['officerName'];
    $designation = $_POST['designation'];
    $district = $_POST['district'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $role = "branch_admin";

    $query = "INSERT INTO admins (username, password, role, dept_code, branch_code, dept_name, branch_name, officer_name, designation, district, email, phone)
              VALUES ($1, $2, $3, $4, $5, $6, $7, $8, $9, $10, $11, $12)";

    $result = pg_query_params($conn, $query, [
        $username,
        $hashed_password,
        $role,
        $deptCode,
        $branchCode,
        $deptName,
        $branchName,
        $officerName,
        $designation,
        $district,
        $email,
        $phone
    ]);

    if ($result) {
        echo "<script>alert('Branch admin added successfully!'); window.location.href = 'add_branch_admin.php';</script>";
    } else {
        echo "Error: " . pg_last_error($conn);
    }
}

pg_close($conn);
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Add Branch Admin</title>
  <link rel="stylesheet" href="add_branch_admin.css" />
  <link rel="stylesheet" href="dept_dashboard.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

  <style>
    body {
      display: flex;
      margin: 0;
      font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f4f6f9;
    }

    .form-container {
      flex: 1;
      padding: 40px;
      margin-left: 450px;
    }

    h2 {
      text-align: center;
      margin-bottom: 20px;
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-group label {
      display: block;
      margin-bottom: 6px;
      font-weight: 600;
    }

    .form-group input {
      width: 97%;
      padding: 10px;
      border-radius: 6px;
      border: 1px solid #ccc;
    }

    form .form-group select {
     width: 100%;
      padding: 10px;
    }

    [type="submit"] {
      display: block;
      margin: 0 auto;
      background-color: #4CAF50;
      color: white;
      padding: 10px 25px;
      font-size: 16px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
    }

    [type="submit"]:hover {
      background-color: #45a049;
    }

    .sidebar ul li ul {
      display: none;
      list-style-type: none;
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
  </style>
</head>

<body>
  <!-- Sidebar -->
  <div class="sidebar">
    <div class="welcome-section">
      <img src="image/user.jpg" alt="User" />
      <h3>Welcome!</h3>
            <?php if (!empty($dept_name)) : ?>
        <h3><?= htmlspecialchars($dept_name) ?></h3>
      <?php endif; ?>
      <p>Department Admin</p>
    </div>
    <ul>
      <li><a href="dept_dashboard.php"><i class="fas fa-home"></i> Home</a></li>
      <li class="dropdown">
        <a href="#" onclick="toggledropdown(event)">
          <i class="fas fa-users"></i> Branch <i class="fa fa-plus"></i>
        </a>
        <ul class="dropdown-menu">
          <li><a href="branch_entry.php">Branch Entry Form</a></li>
          <li><a href="add_branch_admin.php">Admin Entry</a></li>
          <li><a href="b_admin_list.php">Branch Admin List</a></li>
        </ul>
      </li>
      <li><a href="#"><i class="fas fa-cog"></i> Settings</a></li>
      <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
    </ul>
  </div>

  <!-- Form -->
      <div class="form-container">
  <h2>Add Branch Admin</h2>
  <form method="POST" action="">
    
<!-- Department Code (read-only) -->
<div class="form-group">
  <label for="deptCode">Department Code</label>
  <input type="text" name="deptCode_display" id="deptCode_display" value="<?= htmlspecialchars($deptData['dept_code']) ?>" readonly>
  <input type="hidden" name="deptCode" value="<?= htmlspecialchars($deptData['dept_code']) ?>">
</div>

<!-- Department Name (read-only) -->
<div class="form-group">
  <label for="deptName">Department Name</label>
  <input type="text" name="deptName" id="deptName" value="<?= htmlspecialchars($deptData['dept_name']) ?>" readonly>
</div>


    <!-- Branch Dropdown -->
    <div class="form-group">
      <label for="branchCode">Branch Code</label>
      <select name="branchCode" id="branchCode" required>
        <option value="">-- Select Branch --</option>
        <?php foreach ($branches as $b): ?>
          <option value="<?= htmlspecialchars($b['branch_code']) ?>" data-name="<?= htmlspecialchars($b['branch_name']) ?>">
            <?= htmlspecialchars($b['branch_code']) ?> - <?= htmlspecialchars($b['branch_name']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <!-- Auto-filled Branch Name -->
    <div class="form-group">
      <label for="branchName">Branch Name</label>
      <input type="text" name="branchName" id="branchName" >
    </div>

    <!-- Rest of the fields -->
    <div class="form-group">
      <label for="officerName">Officer Name</label>
      <input type="text" name="officerName" id="officerName" required>
    </div>

    <div class="form-group">
      <label for="designation">Designation</label>
      <input type="text" name="designation" id="designation" required>
    </div>

    <div class="form-group">
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
  </div>

    <div class="form-group">
      <label for="email">Email</label>
      <input type="email" name="email" id="email" required>
    </div>

    <div class="form-group">
      <label for="phone">Phone</label>
      <input type="text" name="phone" id="phone" required>
    </div>

    <div class="form-group">
      <label for="username">Username</label>
      <input type="text" name="username" id="username" required>
    </div>

    <div class="form-group">
      <label for="password">Password</label>
      <input type="password" name="password" id="password" required>
    </div>

    <div class="form-group" style="text-align: center;">
      <button type="submit">Add Admin</button>
    </div>
  </form>
</div>

  <script>

          document.getElementById('deptCode').addEventListener('change', function() {
  const selected = this.options[this.selectedIndex];
  document.getElementById('deptName').value = selected.getAttribute('data-name') || '';
});

document.getElementById('branchCode').addEventListener('change', function() {
  const selected = this.options[this.selectedIndex];
  document.getElementById('branchName').value = selected.getAttribute('data-name') || '';
})

    function toggledropdown(event) {
      event.preventDefault();
      const parent = event.target.closest('li');
      parent.classList.toggle('active');

      const icon = parent.querySelector('.fa-plus, .fa-minus');
      if (icon) {
        if (parent.classList.contains('active')) {
          icon.classList.remove('fa-plus');
          icon.classList.add('fa-minus');
        } else {
          icon.classList.remove('fa-minus');
          icon.classList.add('fa-plus');
        }
      }
    }
  </script>
</body>
</html>
