<?php
session_start();

// include ('header.php'); 


if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'department_admin') {
  echo "<script>
        alert('Unauthorized access. Please try logging in again.');
        window.location.href = 'admin_login.php';
    </script>";
  exit();
}

$deptCode = $_SESSION['dept_code'] ?? null;
$branchCode = $_SESSION['branch_code'] ?? null;

$conn = pg_connect("host=localhost dbname=PROJECT user=postgres password=1035");
if (!$conn) {
  die("Connection failed: " . pg_last_error());
}

$query = "SELECT * FROM admins WHERE role = 'branch_admin' AND dept_code = $1 ORDER BY branch_code ASC";
$result = pg_query_params($conn, $query, [$deptCode]);

// Initialize name variables
$dept_name = "";
// $branch_name = "";

// For department admin
if (isset($_SESSION['dept_code']) && $_SESSION['role'] === 'department_admin') {
  $dept_code = $_SESSION['dept_code'];
  $query = "SELECT dept_name FROM admins WHERE dept_code = '$dept_code'";
  $result = pg_query($conn, $query);
  if ($row = pg_fetch_assoc($result)) {
    $dept_name = $row['dept_name'];
  }
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
  </style>
</head>

<body>
  <div class="sidebar">
    <div class="welcome-section">
      <img src="image\user.jpg" alt="User" />
      <h3>Welcome!</h3>
      <p>
      <h3><?= htmlspecialchars($dept_name) ?></h3>
      </p>
      <p>Department Admin</p>
    </div>
    <ul>
      <li><a href="dept_dashboard.php"> <i class="fas fa-home"></i> Home</a></li>
      <li class="dropdown">
        <a onclick="toggledropdown(event)">
          <i class="fas fa-users"></i> Branch <i class="fa fa-plus"></i>
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
      <?php if (!empty($dept_name)) : ?>
        <h1><?= htmlspecialchars($dept_name) ?> Department Dashboard</h1>
      <?php endif; ?>
    </header>

    <div class="cards">
      <?php
      $count = "select count(*) as total from branches  where dept_code = $1";
      $countResult = pg_query_params($conn, $count, [$deptCode]);
      $totalBranches = 0;
      if ($countResult && pg_num_rows($countResult) > 0) {
        $row = pg_fetch_assoc($countResult);
        $totalBranches = $row['total'];
      }

      ?>
      <div class="card">
        <h3>Total Branches</h3>
        <p><?php echo $totalBranches; ?></p>
      </div>

      <?php
      $totalEmployees = 0;

      if ($deptCode && $conn) {
        $query = "
    SELECT COUNT(*) AS total
    FROM employees
    WHERE branch_code IN (
        SELECT branch_code::text FROM branches WHERE dept_code = $1
    )";
        $result = pg_query_params($conn, $query, [$deptCode]);

        if ($result && pg_num_rows($result) > 0) {
          $row = pg_fetch_assoc($result);
          $totalEmployees = $row['total'];
        }
      }
      ?>

      <div class="card">
        <h3>Total Employees</h3>
        <p><?php echo $totalEmployees; ?></p>
      </div>

    </div>


  </div>

  <!-- ✅ Modal Wrapper -->
  <div id="iframeModal">
    <div class="modal-content">
      <span class="close-btn" onclick="closeIframeModal()">&times;</span>
      <h2>Edit Admin Info</h2>
      <iframe id="iframeEdit" src="" frameborder="0"></iframe>
    </div>
  </div>

  <style>
    /* Modal Background */
    #iframeModal {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.6);
      display: none;
      /* Hidden by default */
      justify-content: center;
      align-items: center;
      z-index: 2000;
    }

    /* Modal Box */
    #iframeModal .modal-content {
      background: #fff;
      border-radius: 8px;
      max-width: 600px;
      width: 100%;
      height: 66%;
      display: flex;
      flex-direction: column;
      position: relative;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
      overflow: hidden;
    }

    /* Close button */
    #iframeModal .close-btn {
      position: absolute;
      top: 8px;
      right: 12px;
      font-size: 22px;
      font-weight: bold;
      cursor: pointer;
      color: #333;
    }

    /* Iframe */
    #iframeEdit {
      flex: 1;
      width: 100%;
      border: none;
    }

    /* Title */
    #iframeModal h2 {
      margin: 12px 0;
      text-align: center;
      color: #444;
    }
  </style>


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

  // ✅ Open iframe modal
  function openIframeModal(url) {
    document.getElementById("iframeEdit").src = url;
    document.getElementById("iframeModal").style.display = "flex";
  }

  // ✅ Close iframe modal
  function closeIframeModal() {
    document.getElementById("iframeModal").style.display = "none";
    document.getElementById("iframeEdit").src = ""; // reset iframe
  }

    function openModal(slno) {
      // Show modal
      const modal = document.getElementById("employeeModal");
      modal.style.display = "block";

      // Load employee data into modal content
      const content = document.getElementById("modalContent");
      content.innerHTML = "<p>Loading...</p>";

      fetch("employee_view.php?slno=" + slno)
        .then(response => response.text())
        .then(data => {
          content.innerHTML = data;
        })
        .catch(err => {
          content.innerHTML = "<p style='color:red;'>❌ Error loading employee data.</p>";
          console.error(err);
        });
    }

    function closeModal() {
      document.getElementById("employeeModal").style.display = "none";
    }
  </script>

</body>

</html>
<?php include('employee_list_dept.php'); ?>