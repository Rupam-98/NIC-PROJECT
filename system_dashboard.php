<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'super_admin') {
  echo "<script>
    alert('Unauthorized access. Only Super Admins are allowed.');
    window.location.href = 'admin_login.php';
  </script>";
  exit();
}

$username = $_SESSION['username'];
$deptCode = $_SESSION['dept_code'];

$conn = pg_connect("host=localhost dbname=PROJECT user=postgres password=1035");
if (!$conn) {
  die("Connection failed: " . pg_last_error());
}

$query = "SELECT * FROM admins WHERE role = 'department_admin' AND dept_code = $1 ORDER BY dept_code ASC";
$result = pg_query_params($conn, $query, [$deptCode]);
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
    .sidebar ul li a {
      color: #dcdde1;
      text-decoration: none;
      font-size: 16px;
      display: flex;
      align-items: center;
      gap: 6px;
      padding: 10px 14px;
      border-radius: 6px;
      transition: background 0.2s, color 0.2s;
      background: linear-gradient(135deg, #2f3542 80%, #2355d6 100%); 

    }

    /* .sidebar ul li ul {
      display: none;
      list-style-type: none;
      margin-left: 30px;
      padding: 0;
    } */
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
          <li><a href="add_dept_admin.php">Admin Entry</a></li>
          <li><a href="dept_admin_list.php">Dept. Admin List</a></li>
          <li><a href="dept_info.php">Dept. Info List</a></li>
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
          <li><a href="#" onclick="openIframeModal('edit_user.php')">Update Profile</a></li>


          <li><a href="#" onclick="openIframeModal('cng_user_pass.php')">Change Password</a></li>
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
      <?php
      $count = "select count(*) as total from dept_entry";
      $countResult = pg_query($conn, $count);
      $totalAdmins = 0;
      if ($countResult && pg_num_rows($countResult) > 0) {
        $row = pg_fetch_assoc($countResult);
        $totalAdmins = $row['total'];
      }

      ?>
      <div class="card">
        <h3>Total Dept. Admin</h3>
        <p><?php echo $totalAdmins; ?></p>
      </div>


      <?php
      $count = "select count(*) as total from branches";
      $countResult = pg_query($conn, $count);
      $totalBranches = 0;
      if ($countResult && pg_num_rows($countResult) > 0) {
        $row = pg_fetch_assoc($countResult);
        $totalBranches = $row['total'];
      }

      ?>
      <div class="card">
        <h3>Total Branch Admin</h3>
        <p><?php echo $totalBranches; ?></p>
      </div>


      <?php
      $count = "select count(*) as total from employees";
      $countResult = pg_query($conn, $count);
      $totalEmployees = 0;
      if ($countResult && pg_num_rows($countResult) > 0) {
        $row = pg_fetch_assoc($countResult);
        $totalEmployees = $row['total'];
      }

      ?>
      <div class="card">
        <h3>Total Employees</h3>
        <p><?php echo $totalEmployees; ?></p>
      </div>

      <!-- <div class="card">
        <h3>#</h3>
        <p>#</p>
      </div> -->
    </div>
  </div>

  <?php include('all_employee_list.php'); ?>

  <!-- IFRAME MODAL -->
  <div id="iframeModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:70%; background-color:rgba(251, 251, 251, 0.5); z-index:1;">
    <div style="position:relative; width:90%; max-width:600px; height:90%; margin:5% auto; background:#fff; border-radius:10px; box-shadow:0 0 10px rgba(0,0,0,0.3); overflow:hidden;">
      <span onclick="closeIframeModal()" style="position:absolute; top:10px; right:15px; font-size:22px; font-weight:bold; cursor:pointer;">&times;</span>
      <iframe id="modalIframe" src="" style="width:100%; height:100%; border:none;"></iframe>
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

    function openIframeModal(url) {
      document.getElementById('modalIframe').src = url;
      document.getElementById('iframeModal').style.display = 'block';
    }

    function closeIframeModal() {
      document.getElementById('modalIframe').src = '';
      document.getElementById('iframeModal').style.display = 'none';
      location.reload(); // Optional: Reload page after closing
    }
  </script>
</body>

</html>