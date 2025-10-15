<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'super_admin') {
  echo "<script>
    alert('Unauthorized access. Please try logging in again.');
    window.location.href = 'system_admin_login.php';
  </script>";
  exit();
}

// $username = $_SESSION['username'];
$deptCode = $_SESSION['dept_code'];

$conn = pg_connect("host=localhost dbname=PROJECT user=postgres password=1035");
if (!$conn) {
  die("Connection failed: " . pg_last_error());
}


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
  </style>
</head>

<body>
<?php include('sidebar.php'); ?>
  <div class="main-content">
    <header>
      <h1>System Dashboard</h1>
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
    background: rgba(0,0,0,0.6);
    display: none; /* Hidden by default */
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
    box-shadow: 0 5px 15px rgba(0,0,0,0.3);
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
    // function toggledropdown(event) {
    //   event.stopPropagation(); // stops bubbling up
    //   const li = event.target.closest('li');
    //   li.classList.toggle('active');
    // }

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

  </script>
</body>

</html>