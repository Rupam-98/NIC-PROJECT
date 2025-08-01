<?php
$host = "localhost";
$dbname = "PROJECT";
$user = "postgres";
$password = "1035";
$conn = pg_connect("host=$host dbname=$dbname user=$user password=$password");
if (!$conn) {
  die("Connection failed: " . pg_last_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Fix: use correct field names for department and branch_code
  $data = [
    'slno' => $_POST['slno'],
    'dept_code' => $_POST['dept_code'],
    'department' => $_POST['dept_name'], // from readonly input
    'branch_code' => $_POST['branchcode'],
    'branch_address' => $_POST['branch_address'],
    'name' => $_POST['name'],
    'desig' => $_POST['desig'],
    'sex' => $_POST['sex'],
    'age' => $_POST['age'],
    'epic' => $_POST['epic'],
    'phone' => $_POST['phone'],
    'home_lac' => $_POST['home_lac'],
    'residential_lac' => $_POST['residential_lac'],
    'branch_lac' => $_POST['branch_lac'],
    'basic' => $_POST['basic'],
    'gazeted' => $_POST['gazeted'] === "1" ? "Yes" : "No",
    'remarks' => $_POST['remarks'],
    'education' => $_POST['education'],
    'dor' => $_POST['dor'],
    'ac_no' => $_POST['ac_no'],
    'ifsc_code' => $_POST['ifsc_code'],
    'branch_name' => $_POST['branch_name'],
    'bank_branch_address' => $_POST['bank_branch_address']
  ];

  $query = "
        INSERT INTO employees (
            slno, dept_code, department, branch_code, branch_address, name, desig, sex, age, epic, phone,
            home_lac, residential_lac, branch_lac, basic, gazeted, remarks, education, dor,
            ac_no, ifsc_code, branch_name, bank_branch_address
        ) VALUES (
            $1, $2, $3, $4, $5, $6, $7, $8, $9, $10,
            $11, $12, $13, $14, $15, $16, $17, $18, $19, $20,
            $21, $22, $23
        )
    ";
  $result = pg_query_params($conn, $query, array_values($data));
  if ($result) {
    echo "<script>alert('Employee entry added successfully.');window.location.href = 'employee.php';</script>";
  } else {
    echo "Error: " . pg_last_error($conn);
  }
}
?>

<!DOCTYPE html>
<html>

<head>
  <title>Employee Entry Form</title>
  <link rel="stylesheet" href="employee_entry.css" />

  <head>
    <link rel="stylesheet" href="" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <style>
      .sidebar ul li ul {
        display: none;
        list-style-type: none;
        padding-left: 20px;

      }

      .sidebar ul li.active>ul {
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


      .sidebar {
        margin-left: 0px;
        position: relative;
        top: 0;
        left: 0;
        width: 275px;
        height: 100vh;
        background-color: #2c3e50;
        color: #fff;
        position: fixed;
        overflow-y: auto;
        box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
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

      .sidebar i {
        margin-right: 10px;
      }
    </style>

  </head>

<body>
  <div class="sidebar">
    <div class="welcome-section">
      <img src="image\user.jpg" alt="User" />
      <h3>Welcome!</h3>
      <p>Branch Admin</p>
    </div>
    <ul>
      <li><a href="branch_dashboard.php"> <i class="fas fa-home"></i> Home</a></li>
      <li class="dropdown">
        <a onclick="toggledropdown(event)">
          <i class="fas fa-users"></i> Employees <i class="fa fa-plus"></i>
        </a>
        <ul class="dropdown-menu">
          <li><a href="employee_list.php"> Employee List</a></li>
          <li><a href="employee.php"> Employee Entry</a></li>
        </ul>
      </li>
      <li><a href="#"><i class="fas fa-cog"></i> Settings</a></li>
      <li><a href=""><i class="fas fa-sign-out-alt"></i> Logout</a></li>
    </ul>
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


  <form method="post">
    <h2>Employee Entry Form</h2>
    <label for="slno">Sl. No</label>
    <input type="number" id="slno" name="slno" required>


    <label for="dept_code">DEPARTMENT CODE</label>
    <select id="dept_code" name="dept_code" class="form-control" required>
      <option value="">-- Select Department --</option>
      <?php
      $query = "SELECT dept_code, dept_name FROM dept_entry ORDER BY dept_code";
      $result = pg_query($conn, $query);
      while ($row = pg_fetch_assoc($result)) {
        $dept_code = htmlspecialchars($row['dept_code']);
        $dept_name = htmlspecialchars($row['dept_name']);
        echo "<option value='$dept_code'>$dept_code - $dept_name</option>";
      }
      ?>
    </select>



    <label for="department">DEPARTMENT NAME</label>
    <input type="text" id="dept_name" name="dept_name" readonly placeholder="Department Name">



    <label for="branchcode">BRANCH CODE</label>
    <select id="branchcode" name="branchcode" required>
      <option value="">-- Select Branch --</option>
      <?php
      $query = "SELECT branch_code, branch_name FROM branches ORDER BY branch_code";
      $result = pg_query($conn, $query);
      while ($row = pg_fetch_assoc($result)) {
        $branch_code = htmlspecialchars($row['branch_code']);
        $branch_name = htmlspecialchars($row['branch_name']);
        echo "<option value='$branch_code'>$branch_code - $branch_name</option>";
      }
      ?>
    </select>

    <label for="branch_address">BRANCH ADDRESS</label>
    <input type="text" id="branchAddress" name="branch_address" required>
     
    </select>



    <label for="name">NAME</label>
    <input type="text" id="name" name="name" required>

    <label for="desig">DESIGNATION</label>
    <input type="text" id="desig" name="desig" required>

    <label for="sex">SEX</label>
    <select id="sex" name="sex" required>
      <option value="">Select</option>
      <option value="Male">Male</option>
      <option value="Female">Female</option>
      <option value="Other">Other</option>
    </select>

    <label for="age">AGE</label>
    <input type="number" id="age" name="age" required>

    <label for="epic">VOTER ID (EPIC)</label>
    <input type="text" id="epic" name="epic" required>

    <label for="phone">PHONE</label>
    <input type="text" id="phone" name="phone" required>

    <label for="home_lac">HOME LAC</label>
    <input type="text" id="home_lac" name="home_lac" required>

    <label for="residential_lac">RESIDENTIAL LAC</label>
    <input type="text" id="residential_lac" name="residential_lac" required>

    <label for="branch_lac">WORK LAC</label>

    <input type="text" id="branch_lac" name="branch_lac" required>
    <!-- <option value="">Select Branch LAC </option> -->





    <label for="basic">BASIC</label>
    <input type="number" id="basic" name="basic" step="0.01" required>

    <label for="gazeted">GAZETED</label>
    <select id="gazeted" name="gazeted" required>
      <option value="">Select</option>
      <option value="1">Yes</option>
      <option value="0">No</option>
    </select>

    <label for="remarks">REMARKS</label>
    <input type="text" id="remarks" name="remarks" required>

    <label for="education">EDUCATION</label>
    <input type="text" id="education" name="education" required>

    <label for="dor">DOR (Date of Retirement)</label>
    <input type="date" id="dor" name="dor" required>

    <label for="ac_no">ACCOUNT NUMBER</label>
    <input type="text" id="ac_no" name="ac_no" required>

    <label for="ifsc_code">IFSC CODE</label>
    <input type="text" id="ifsc_code" name="ifsc_code" required>

    <label for="branch_name">BANK BRANCH NAME</label>
    <input type="text" id="branch_name" name="branch_name" required>

    <label for="bank_branch_address">BANK BRANCH ADDRESS</label>
    <input type="text" id="bank_branch_address" name="bank_branch_address" required>

    <input type="submit" value="Submit">



  </form>

  <form action="employee_import.php" method="POST" enctype="multipart/form-data">
    <h2>Import Employees (Excel)</h2>
    <a>
      <label for="import_file">Select Excel File:</label>
      <input type="file" name="import_file" accept=".xlsx, .xls" required>
      <button>Import</button>
  </form>
  <script>
    document.getElementById('dept_code').addEventListener('change', function() {
      const deptCode = this.value;
      if (deptCode !== "") {
        fetch(`get_dept_info.php?dept_code=${deptCode}`)
          .then(response => response.json())
          .then(data => {
            document.getElementById('dept_name').value = data.dept_name || '';

          });
      } else {
        document.getElementById('dept_name').value = '';

      }
    });


    document.getElementById('branchcode').addEventListener('change', function() {
      const branchCode = this.value;
      if (branchCode !== "") {
        fetch(`get_branch_info.php?branch_code=${branchCode}`)
          .then(response => response.json())
          .then(data => {
            document.getElementById('branchAddress').value = data.address || '';

          });
      } else {
        document.getElementById('branchAddress').value = '';

      }
    });
  </script>


</body>

</html>