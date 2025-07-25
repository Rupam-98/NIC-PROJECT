<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  echo "<script>
    alert('Session expired or unauthorized access. Please log in first.');
    window.location.href = 'system_admin_login.php';
  </script>";
  exit();
}
$user_id = $_SESSION['user_id'];
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
  </style>
</head>

<body>
  <div class="sidebar">
    <h2>System Admin</h2>
    <ul>
      <li><a href="system_dashboard.php"><i class="fas fa-home"></i> Dashboard</a></li>

      <li class="dropdown">
        <a onclick="toggledropdown(event)">
          <i class="fas fa-users"></i> Department <i class="fa fa-plus"></i>
        </a>
        <ul class="dropdown-menu">
          <li><a href="dept_entry.php">Dept. Entry Form</a></li>
          <li><a href="add_dept_admin.html">Admin Entry</a></li>
          <li><a href="dept_admin_list.php">Dept. Admin List</a></li>
        </ul>
      </li>

      <li class="dropdown">
        <a onclick="toggledropdown(event)">
          <i class="fas fa-users"></i> Branch <i class="fa fa-plus"></i>
        </a>
        <ul class="dropdown-menu">
          <li><a href="branch_admin_list.php">Branch Admin List</a></li>
        </ul>
      </li>

      <li class="dropdown">
        <a onclick="toggledropdown(event)">
          <i class="fas fa-cog"></i> Settings <i class="fa fa-plus"></i>
        </a>
        <ul class="dropdown-menu">
          <li><a href="user_list.php">Update Profile</a></li>
          <li><a href="cng_user_pass.php?id=<?= htmlspecialchars($user_id) ?>">Change Password</a></li>
        </ul>
      </li>

      <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>

    </ul>
  </div>

  <div class="main-content">
    <header>
      <h1>Dashboard</h1>
    </header>

    <div class="cards">
      <div class="card">
        <h3>Total Dept. Admin</h3>
        <p>1</p>
      </div>
      <div class="card">
        <h3>Total Branch Admin</h3>
        <p>1</p>
      </div>
      <div class="card">
        <h3>Total Employees</h3>
        <p>3</p>
      </div>
      <div class="card">
        <h3>#</h3>
        <p>#</p>
      </div>
    </div>

    <div class="table-section">
      <h2>#</h2>
      <table>
        <thead>
          <tr>
            <th>###</th>
            <th>###</th>
            <th>###</th>
            <th>###</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>###</td>
            <td>###</td>
            <td>###</td>
            <td>###</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <script>
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
