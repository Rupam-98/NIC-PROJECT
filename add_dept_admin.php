<?php
$host = "localhost";
$port = "5432";
$dbname = "PROJECT";
$user = "postgres";
$password = "1035";

$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");
if (!$conn) {
  die("Connection failed: " . pg_last_error());
}

// Fetch department list
$dept_result = pg_query($conn, "SELECT dept_code, dept_name FROM dept_entry ORDER BY dept_code ASC");
$departments = [];
while ($row = pg_fetch_assoc($dept_result)) {
  $departments[] = $row;
}

// Form handling
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $deptCode = $_POST['deptCode'];
  $deptName = $_POST['deptName'];
  $officerName = $_POST['officerName'];
  $designation = $_POST['designation'];
  $district = $_POST['district'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  $username = $_POST['username'];
  $password = $_POST['password'];

  $hashed_password = password_hash($password, PASSWORD_DEFAULT);
  $role = "department_admin";

  $query = "INSERT INTO admins (username, password, role, dept_code, branch_code, dept_name, branch_name, officer_name, designation, district, email, phone)
              VALUES ($1, $2, $3, $4, NULL, $5, NULL, $6, $7, $8, $9, $10)";

  $result = pg_query_params($conn, $query, [
    $username,
    $hashed_password,
    $role,
    $deptCode,
    $deptName,
    $officerName,
    $designation,
    $district,
    $email,
    $phone
  ]);

  if ($result) {
    echo "<script>alert('Department admin added successfully!'); window.location.href = 'add_dept_admin.php';</script>";
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
  <title>System Admin Dashboard</title>
  <link rel="stylesheet" href="system_admin_dashboard.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <style>
    .sidebar ul li ul {
      display: none;
      list-style-type: none;
      margin-left: 30px;
      padding: 0;

    }

    .sidebar ul li.active>ul {
      display: block;
    }

    .sidebar ul li ul li {

      color: #fff;
    }

    .sidebar ul li ul li:hover {
      background: #555;
      cursor: pointer;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      /* background:linear-gradient(135deg,  #b0cce7, #808283); */
      margin: 0;
      padding: 0;
    }

    .form-container {
      background: #bde3f5;
      width: 65%;
      margin-left: 17%;
      margin-right: 7px;
      padding: 30px 40px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
      border-radius: 12px;
    }

    .form-container h2 {
      text-align: center;
      margin-bottom: 25px;
      color: #333333;
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-group label {
      display: block;
      margin-bottom: 8px;
      color: #080808;
      font-weight: 600;
    }

    .form-group input,
    .form-group select {
      width: 100%;
      padding: 10px 1px;
      border: 1px solid #cccccc;
      border-radius: 6px;
      font-size: 16px;
      transition: border-color 0.3s;
    }

    .form-group input:focus,
    .form-group select:focus {
      border-color: #4a90e2;
      outline: none;
    }

    .submit-btn {
      width: 100%;
      background-color: #4a90e2;
      color: #ffffff;
      padding: 12px;
      border: none;
      border-radius: 6px;
      font-size: 18px;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    .submit-btn:hover {
      background-color: #357ABD;
    }
  </style>
</head>

<body>
  <?php include 'sidebar.php'; ?>

  <div class="main-content">
    <div class="form-container">
      <h2>Add Department Admin</h2>

      <form action="" method="POST">

        <div class="form-group">
          <label for="deptCode">Department Code</label>
          <select id="deptCode" name="deptCode" onchange="fillDeptName()" required>
            <option value="">Select Department Code</option>
            <?php foreach ($departments as $dept): ?>
              <option value="<?= htmlspecialchars($dept['dept_code']) ?>" data-name="<?= htmlspecialchars($dept['dept_name']) ?>">
                <?= htmlspecialchars($dept['dept_code']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="form-group">
          <label for="deptName">Department Name</label>
          <input type="text" id="deptName" name="deptName" placeholder="Department Name " readonly required />
        </div>

        <div class="form-group">
          <label for="officerName">Officer Name</label>
          <input type="text" id="officerName" name="officerName" placeholder="Enter officer name" required />
        </div>

        <div class="form-group">
          <label for="designation">Officer Designation</label>
          <select id="designation" name="designation" required>
            <option value="Officer Designation">Officer Designation</option>
            <option value="DDO">DDO</option>
            <option value="HOD">HOD</option>
            <option value="ADC">ADC</option>
          </select>
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
          <label for="email">Office Email</label>
          <input type="email" id="email" name="email" placeholder="Enter email" required />
        </div>

        <div class="form-group">
          <label for="phone">Officer Phone</label>
          <input type="tel" id="phone" name="phone" placeholder="Enter phone number" required />
        </div>

        <!-- Hidden role input -->
        <input type="hidden" name="role" value="Department Admin" />

        <!-- Username and Password moved to the bottom -->
        <div class="form-group">
          <label for="username">Username</label>
          <input type="text" id="username" name="username" placeholder="Enter username" required />
        </div>

        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" id="password" name="password" placeholder="Enter password" required />
        </div>

        <button type="submit" class="submit-btn">Submit</button>
      </form>

    </div>

    <script>
      function toggledropdown(event) {
        event.stopPropagation(); // stops bubbling up
        const li = event.target.closest('li');
        li.classList.toggle('active');
      }

      function toggledropdown(event) {
        event.preventDefault();
        const parent = event.target.closest('li');
        parent.classList.toggle('active');

        const icon = parent.querySelector('.fa-plus, .fa-minus');
        if (parent.classList.contains('active')) {
          icon.classList.remove('fa-plus');
          icon.classList.add('fa-minus');
        } else {
          icon.classList.remove('fa-minus');
          icon.classList.add('fa-plus');
        }
      }

      function fillDeptName() {
        const select = document.getElementById("deptCode");
        const selectedOption = select.options[select.selectedIndex];
        const deptName = selectedOption.getAttribute("data-name");
        document.getElementById("deptName").value = deptName || '';
      }
    </script>
</body>

</html>