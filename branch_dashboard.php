<?php
session_start();

// include ('header.php'); 

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'branch_admin') {
    echo "<script>
        alert('Unauthorized access. Only Branch Admins are allowed.');
        window.location.href = 'admin_login.php';
    </script>";
    exit();
}

$deptCode = $_SESSION['dept_code'];

$conn = pg_connect("host=localhost dbname=PROJECT user=postgres password=1035");
if (!$conn) {
    die("Connection failed: " . pg_last_error());
}

$query = "SELECT * FROM admins WHERE role = 'branch_admin' AND dept_code = $1 ORDER BY branch_code ASC";
$result = pg_query_params($conn, $query, [$deptCode]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Branch Dashboard</title>
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
    .sidebar{
      width: 265px;
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
          <i class="fas fa-users" ></i> Branch  <i class="fa fa-plus"></i>
        </a>
        <ul class="dropdown-menu">
          <li><a href="branch_entry.php"> Branch Entry Form</a></li>
          <li><a href="add_branch_admin.php"> Admin Entry</a></li>
          <li><a href="b_admin_list.php">Branch Admin List</a></li>
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
      <h1>Branch Dashboard</h1>
    </header>

    <div class="cards">
      <div class="card">
        <h3>Total employees</h3>
        <p>#</p>
      </div>
      
    </div>

    
  </div>
          <!-- IFRAME MODAL -->
<div id="iframeModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:70%; z-index:1;">
  <div style="position:relative; width:90%; max-width:600px; height:90%; margin:5% auto; background:#fff; border-radius:10px; box-shadow:0 0 10px rgba(0,0,0,0.3); overflow:hidden;">
    <span onclick="closeIframeModal()" style="position:absolute; top:10px; right:15px; font-size:22px; font-weight:bold; cursor:pointer;">&times;</span>
    <iframe id="modalIframe" src="" style="width:100%; height:100%; border:none;"></iframe>
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

