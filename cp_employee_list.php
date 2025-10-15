<?php
session_start();
// include ('header.php'); 
// Only allow super_admins
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'super_admin') {
  echo "<script>
        alert('Unauthorized access. Only Super Admins are allowed.');
        window.location.href = 'admin_login.php';
    </script>";
  exit();
}

$branchCode = $_SESSION['branch_code'];

$host = "localhost";
$port = "5432";
$dbname = "PROJECT";
$user = "postgres";
$password = "1035";
$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

if (!$conn) {
  die("Connection failed: " . pg_last_error());
}
include 'admin.php';
$query = $query = "SELECT * FROM employees 
          WHERE LOWER(emp_type) IN ('central employee', 'psu employee')
          ORDER BY slno ASC";

$result = pg_query($conn, $query);


?>

<!DOCTYPE html>
<html lang="en">

<head>
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


    body {
      font-family: Arial, sans-serif;
      background: #f4f7f8;
      padding: 20px;
    }

    .container {
      position: relative;
      max-width: 1200px;
      margin-left: 275px;
      background: #eeeeee73;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    h2 {
      text-align: center;
      margin-bottom: 20px;
    }

    #searchInput {
      width: 100%;
      padding: 10px;
      margin-bottom: 20px;
      font-size: 16px;
      border: 2px solid #ccc;
      border-radius: 6px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      font-size: 14px;
    }

    th,
    td {
      padding: 12px 15px;
      border: 1px solid #ddd;
      text-align: left;
    }

    thead {
      background-color: #007BFF;
      color: white;
    }

    tr:nth-child(even) {
      background-color: #f2f2f2;
    }

    /* tr:hover {
            background-color: #e0e0e0;
        } */

    .action-btns button {
      margin-right: 5px;
      padding: 6px 10px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-size: 12px;
    }

    .view {
      background-color: #17a2b8;
      color: white;
    }

    .edit {
      background-color: #ffc107;
      color: black;
    }

    .delete {
      background-color: #dc3545;
      color: white;
    }

    #viewModal {
      position: fixed;
      top: 40px;
      left: 0;
      width: 100%;
      height: 100%;
      /* background: rgba(0, 0, 0, 0.7); */
      z-index: 1000;
      justify-content: center;
      align-items: center;
      display: none;
      /* this MUST be last */
    }


    #viewModal .modal-content {
      position: relative;
      width: 80%;
      height: 80%;
      background: #fff;
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
    }

    #viewModal iframe {
      width: 100%;
      height: 100%;
      border: none;
    }

    #viewModal button.close-btn {
      position: absolute;
      top: 10px;
      right: 10px;
      background: #dc3545;
      color: #fff;
      border: none;
      padding: 8px 12px;
      cursor: pointer;
      border-radius: 4px;
      font-weight: bold;
    }

    #viewModal button.close-btn:hover {
      background: #c82333;
    }
  </style>
</head>

<body>
  <?php include('sidebar.php'); ?>

  <div class="container">
    <h2>Employee List</h2>
    <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search by Name or Branch Code">

    <table id="employeeTable">
      <thead>
        <tr>
          <th>ID</th>
          <th>Sl No</th>
          <th>Employee Type</th>
          <th>Name</th>
          <th>Designation</th>
          <th>Phone</th>
          <th>Branch Code</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php $i = 1; while ($row = pg_fetch_assoc($result)) : ?>
          <tr>
            <td><?= $i ?></td>
            <td><?= htmlspecialchars($row['slno']) ?></td>
            <td><?= htmlspecialchars($row['emp_type']) ?></td>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['desig']) ?></td>
            <td><?= htmlspecialchars($row['phone']) ?></td>
            <td><?= htmlspecialchars($row['branch_code']) ?></td>
            <td class="action-btns">
              <button class="view" onclick="openModal(<?= $row['slno'] ?>)">View More</button>

              <form method="get" action="sys_emp_edit.php" style="display:inline;">
                <input type="hidden" name="slno" value="<?= $row['slno'] ?>">
                <button class="edit">Edit</button>
              </form>

              <form method="post" action="employee_delete.php" style="display:inline;" onsubmit="return confirm('Are you sure to delete?');">
                <input type="hidden" name="slno" value="<?= $row['slno'] ?>">
                <button class="delete">Delete</button>
              </form>
            </td>

          </tr>
        <?php $i++; endwhile; ?>
      </tbody>
    </table>
  </div>

  <!-- Add this inside your <body>, ideally just above </body> -->

  <!-- ✅✅✅ MODAL HTML ✅✅✅ -->
  <div id="viewModal">
    <div class="modal-content">
      <iframe id="modalIframe" src=""></iframe>
      <button onclick="closeModal()" class="close-btn">Close</button>
    </div>
  </div>

  <script>
    function searchTable() {
      const input = document.getElementById("searchInput").value.toUpperCase();
      const table = document.getElementById("employeeTable");
      const rows = table.getElementsByTagName("tr");

      for (let i = 1; i < rows.length; i++) {
        const name = rows[i].getElementsByTagName("td")[1].textContent.toUpperCase();
        const branch = rows[i].getElementsByTagName("td")[4].textContent.toUpperCase();
        rows[i].style.display = name.includes(input) || branch.includes(input) ? "" : "none";
      }
    }

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

    function openModal(slno) {
      const modal = document.getElementById('viewModal');
      const iframe = document.getElementById('modalIframe');
      iframe.src = 'employee_view.php?slno=' + slno;
      modal.style.display = 'flex';
    }

    function closeModal() {
      const modal = document.getElementById('viewModal');
      const iframe = document.getElementById('modalIframe');
      iframe.src = '';
      modal.style.display = 'none';
    }
  </script>
</body>

</html>
<?php pg_close($conn); ?>