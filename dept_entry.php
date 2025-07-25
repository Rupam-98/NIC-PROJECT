<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $host = "localhost";
    $port = "5432";
    $dbname = "PROJECT"; 
    $user = "postgres";     
    $password = "1035";   

    // Connect to PostgreSQL
    $conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

    if (!$conn) {
        die("<script>alert('Connection failed: " . pg_last_error() . "');</script>");
    }

    // Get form data safely
    $dept_type = $_POST['dept_type'];
    $dept_code = $_POST['dept_code'];
    $dept_name = $_POST['dept_name'];
    $address = $_POST['address'];
    $head = $_POST['head'];

    // Insert query
    $query = "INSERT INTO dept_entry (dept_type, dept_code, dept_name, address, head) VALUES ($1, $2, $3, $4, $5)";
    $result = pg_query_params($conn, $query, array($dept_type, $dept_code, $dept_name, $address, $head));

    if ($result) {
        echo "<script>alert('Department added successfully.'); window.location.href = 'dept_entry.php';</script>";
    } else {
        echo "<script>alert('Error inserting department: " . pg_last_error() . "'); window.history.back();</script>";
    }

    // Close connection
    pg_close($conn);
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>System Admin Dashboard</title>
  <link rel="stylesheet" href="system_admin_dashboard.css" />
  <!-- <link rel="stylesheet" href="dept_entry.css" /> -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <style>
    .sidebar ul li ul {
      display: none;
      list-style-type: none;
     margin-left: 30px;
      padding: 0;
      
    }
    .sidebar ul li.active > ul {
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
  background:linear-gradient(135deg,  #b0cce7, #808283);
  margin: 0;
  padding: 0;
}

.form-container {
  background: #bde3f5;
  min-width: 600px;
  margin-left: -220px ;
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
  <div class="main-content">
    
  <div class="sidebar">
    <h2>System Admin</h2>
    <ul>
      <li><a href="system_dashboard.html"><i class="fas fa-home"></i> Dashboard</a></li>

      <li class="dropdown">
        <a onclick="toggledropdown(event)">
          <i class="fas fa-users" ></i> Department<i class="fa fa-plus"></i>
        </a>
        <ul class="dropdown-menu">
          <li><a href="dept_entry.php"> Dept. Entry Form</a></li>
          <li><a href="add_dept_admin.html"> Admin Entry</a></li>
          <li><a href="dept_admin_list.php">Dept. Admin List</a></li>
        </ul>
      </li>



       <li class="dropdown">
        <a onclick="toggledropdown(event)">
          <i class="fas fa-users" ></i> Branch<i class="fa fa-plus"></i>
        </a>
        <ul class="dropdown-menu">
          <!-- <li><a href="branch_entry.html"> Branch Entry Form</a></li>
          <li><a href="add_branch_admin.html"> Admin Entry</a></li> -->
          <li><a href="branch_admin_list.php"> Branch Admin List</a></li>
        </ul>
      </li>

      <li class="dropdown">
        <a onclick="toggledropdown(event)">
          <i class="fas fa-cog"></i>Settings<i class="fa fa-plus"></i>
        </a>
        <ul class="dropdown-menu">
          <li><a href="#">Update</a></li>
          <li><a href="#">Change Password</a></li>
        </ul>
      </li>

      <li><a href="main.html"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
    </ul>
  </div>

  <div class="main-content">
      <div class="form-container">
    <h2>Department Entry Form</h2>
    <form action="" method="POST">
      
      <div class="form-group">
        <label for="dept_type">Department Type</label>
        <select id="dept_type" name="dept_type" required>
          <option value="">-- Select Type --</option>
          <option value="c">College</option>
          <option value="h">High School</option>
          <option value="O">Office</option>
          <option value="g">Central Govt. Office</option>
          <option value="b">Bank</option>
        </select>
      </div>
       <div class="form-group">
        <label for="dept_code">Department Code</label>
        <input type="text" id="dept_code" name="dept_code" placeholder="Enter Department Code" required />
      </div>
      <div class="form-group">
        <label for="dept_name">Department Name</label>
        <input type="text" id="dept_name" name="dept_name" placeholder="Enter department name" required />
      </div>
    
      <div class="form-group">
        <label for="address">Address</label>
        <input type="text" id="address" name="address" placeholder="Enter Address" required />
      </div>
      <div class="form-group">
        <label for="head">Head</label>
        <input type="text" id="head" name="head" placeholder="Enter Department Head" required />
      </div>
      
      <button type="submit" class="submit-btn">Submit</button>
    </form>
  </div>
  </div>
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











