<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // DB connection
    $host = "localhost";
    $dbname = "PROJECT";
    $user = "postgres";
    $password = "1035";

    $conn = pg_connect("host=$host dbname=$dbname user=$user password=$password");
    if (!$conn) {
        die("Connection failed: " . pg_last_error());
    }

    // Collect POST data
    $data = [
        'branchcode' => $_POST['branchcode'],
        'deptcode' => $_POST['deptcode'],
        'branch_name' => $_POST['branch_name'],
        'officer_name' => $_POST['officer_name'],
        'designation' => $_POST['designation'],
        'district' => $_POST['district'],
        'email' => $_POST['email'],
        'phone' => $_POST['phone'],
        'username' => $_POST['username'],
        'password' => $_POST['password']
    ];

    // Hash the password before saving
    $hashed_password = password_hash($password_raw, PASSWORD_DEFAULT);

    // Prepare query
    

    // Execute query
    $result = pg_query_params($conn, $query, [
        $branchCode, $deptCode, $branchName, $officerName, $designation,
        $district, $email, $phone, $username, $hashed_password
    ]);




    // Insert query (id will auto-increment)

    $query = "INSERT INTO branch_admins (
        branch_code, dept_code, branch_name, officer_name, designation, 
        district, email, phone, username, password
    ) VALUES (
        $1, $2, $3, $4, $5, $6, $7, $8, $9, $10
    )
    ";


    $result = pg_query_params($conn, $query, array_values($data));

    if ($result) {
        echo "<p style='color: green;'>Branch Admin record inserted successfully!</p>";
    } else {
        echo "<p style='color: red;'>Error: " . pg_last_error($conn) . "</p>";
    }

    pg_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Branch Entry</title>
  <link rel="stylesheet" href="branch_entry.css" />
  <link rel="stylesheet" href="dept_dashboard.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

  <style>
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

    <div class="sidebar">
    <div class="welcome-section">
      <img src="image\user.jpg" alt="User" />
      <h3>Welcome!</h3>
      <p>Department Admin</p>
    </div>
    <ul>
      <li><a href="dept_dashboard.html"> <i class="fas fa-home"></i> Home</a></li>
      <li><a href="#"><i class="fas fa-user"></i> Profile</a></li>
      <li class="dropdown">
        <a onclick="toggledropdown(event)">
          <i class="fas fa-users" ></i> Branch  <i class="fa fa-plus"></i>
        </a>
        <ul class="dropdown-menu">
          <li><a href="branch_entry.php"> Branch Entry Form</a></li>
          <li><a href="add_branch_admin.php"> Admin Entry</a></li>
          <li><a href="b_admin_list.php">Branch Admin List</a></li>
        </ul>
      </li>
      <li><a href="#"><i class="fas fa-chart-line"></i> Reports</a></li>
      <li><a href="#"><i class="fas fa-cog"></i> Settings</a></li>
      <li><a href="main.html"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
    </ul>
  </div>
  
  <div class="form-container">
    <h2>Branch Admin Entry Form</h2>
    <form action="" method="POST">


      <div class="form-group">
        <label for="branchCode">Branch Code</label>
        <input type="text" id="branchCode" name="branchCode" placeholder="Enter branch code" required />
      </div>

       <div class="form-group">
        <label for="deptCode">Department Code</label>
        <input type="text" id="deptCode" name="deptCode" placeholder="Enter department code" required />
      </div>

      <div class="form-group">
        <label for="branchName">Branch Name</label>
        <input type="text" id="branchName" name="branchName" placeholder="Enter branch name" required />
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
          <option value="district">District Name</option>
          <option value="">Bajali</option>
          <option value="Baksa">Baksa</option>
          <option value="Barpeta">Barpeta</option>
          <option value="">Biswanath</option>
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
          <option value="">Hojai</option>
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
          <option value="">Tamulpur</option>
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
  </script>
</body>
</html>