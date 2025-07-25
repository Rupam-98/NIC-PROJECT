<?php
session_start();
if ( !isset($_SESSION['dept_admin_id'])) {
  echo "<script>
    alert('Session expired or unauthorized access. Please log in first.');
    window.location.href = 'dept_admin.php';
  </script>";
  exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Department Dashboard</title>
  <link rel="stylesheet" href="dept_dashboard.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
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
      <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
    </ul>
  </div>

  <div class="main-content">
    <header>
      <h1>Department Dashboard</h1>
    </header>

    <div class="cards">
      <div class="card">
        <h3>Total Staff</h3>
        <p>24</p>
      </div>
      <div class="card">
        <h3>Active Users</h3>
        <p>180</p>
      </div>
      <div class="card">
        <h3>Pending Tasks</h3>
        <p>12</p>
      </div>
      <div class="card">
        <h3>New Messages</h3>
        <p>5</p>
      </div>
    </div>

    <div class="table-section">
      <h2>Recent Activities</h2>
      <table>
        <thead>
          <tr>
            <th>Activity</th>
            <th>User</th>
            <th>Date</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Updated Profile</td>
            <td>John Doe</td>
            <td>2025-07-05</td>
            <td>Completed</td>
          </tr>
          <tr>
            <td>Added New User</td>
            <td>Jane Smith</td>
            <td>2025-07-04</td>
            <td>Completed</td>
          </tr>
          <tr>
            <td>Generated Report</td>
            <td>Michael</td>
            <td>2025-07-03</td>
            <td>Pending</td>
          </tr>
        </tbody>
      </table>
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
