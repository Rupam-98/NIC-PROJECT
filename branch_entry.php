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
        'branch_type' => $_POST['branch_type'],
        'branch_lac' => $_POST['branch_lac'],
        'branch_name' => $_POST['branch_name'],
        'address' => $_POST['address'],
        'beeocode' => $_POST['beeocode'],
        'head' => $_POST['head'],
        
    ];

    // Insert query (id will auto-increment)
    $query = "
        INSERT INTO branches (
            branchcode, deptcode, branch_type, branch_lac, branch_name, address, beeocode, head
            
        ) VALUES (
            $1, $2, $3, $4, $5, $6, $7, $8 
        )
    ";

    $result = pg_query_params($conn, $query, array_values($data));

     if ($result) {
        echo "<script>alert('Branch Added successfully.'); window.location.href = 'branch_entry.php';</script>";
    } else {
        echo "<script>alert('Error Inserting Branch: " . pg_last_error() . "'); window.history.back();</script>";
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
    <h2>Branch Entry Form</h2>
    <form action="" method="POST">
      <div class="form-group">
        <label for="branchcode">Branch Code</label>
        <input type="text" id="branchcode" name="branchcode" placeholder="Enter Branch Code" required />
      </div> 

      <div class="form-group">
        <label for="deptcode">Department Code</label>
        <input type="text" id="deptcode" name="deptcode" placeholder="Enter Department Code" required />
      </div>

      <div class="form-group">
        <label for="branch_type">Branch Type</label>
        <select id="branch_type" name="branch_type" required>
          <option value="">-- Select Type --</option>
          <option value="c">College</option>
          <option value="h">High School</option>
          <option value="O">Office</option>
          <option value="g">Central Govt. Office</option>
          <option value="b">Bank</option>
        </select>
      </div>
     <div class="form-group">
          <label for="branch_lac">Branch LAC</label>
          <input type="text" id="branch_lac" name="branch_lac" placeholder="Enter Branch LAC" required />
      </div>

      <div class="form-group">
        <label for="branch_name">Branch Name</label>
        <input type="text" id="branch_name" name="branch_name" placeholder="Enter Branch Name" required />
      </div>
      <div class="form-group">
        <label for="address">Address</label>
        <textarea id="address" name="address" placeholder="Enter Address" required></textarea>
      </div>

      <div class="form-group">
        <label for="beeocode">BEEO Code</label>
        <input type="text" id="beeocode" name="beeocode" placeholder="Enter BEEO Code" />
      </div>

      <div class="form-group">
        <label for="head">Head</label>
        <select id="head" name="head" required>
          <option value="">-- Select Type --</option>
          <option value="Principal">Principal</option>
          <option value="Inspector of School">Inspector of School</option>
          <option value="Head Master">Head Master</option>
        </select>
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
