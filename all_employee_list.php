<?php
// Base query
$query = "SELECT * FROM employees";

// Restrict data based on role
if ($_SESSION['role'] === 'department_admin' && isset($_SESSION['dept_code'])) {
  $dept_code = pg_escape_string($conn, $_SESSION['dept_code']);
  $query .= " WHERE dept_code = '$dept_code'";
} elseif ($_SESSION['role'] === 'branch_admin' && isset($_SESSION['branch_code'])) {
  $branch_code = pg_escape_string($conn, $_SESSION['branch_code']);
  $query .= " WHERE branch_code = '$branch_code'";
}

// Add ordering
$query .= " ORDER BY slno ASC";

// Execute
$result = pg_query($conn, $query);
if (!$result) {
  die("Query failed: " . pg_last_error());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f4f7f8;
      padding: 20px;
    }
    .container {
      position: absolute;
      top: 40%;
      width: 78%;
      margin-left: 18%;
      background: #eeeeee73;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }
    h2 { text-align: center; margin-bottom: 20px; }
    #searchInput {
      width: 100%; padding: 10px; margin-bottom: 20px;
      font-size: 16px; border: 2px solid #ccc; border-radius: 6px;
    }
    table { width: 100%; border-collapse: collapse; font-size: 14px; }
    th, td { padding: 12px 15px; border: 1px solid #ddd; text-align: left; }
    thead { background-color: #007BFF; color: white; }
    tr:nth-child(even) { background-color: #f2f2f2; }
    .action-btns button {
      margin-right: 5px; padding: 6px 10px; border: none;
      border-radius: 4px; cursor: pointer; font-size: 12px;
    }
    .view { background-color: #17a2b8; color: white; }
    .edit { background-color: #ffc107; color: black; }
    .delete { background-color: #dc3545; color: white; }

    /* Modal styling */
    #viewModal {
      position: fixed; top: 0; left: 0; width: 100%; height: 100%;
      background: rgba(0, 0, 0, 0.5);
      z-index: 1000;
      display: none;
      justify-content: center;
      align-items: center;
    }
    #viewModal .modal-content {
      position: relative;
      width: 63%; height: 80%;
      background: #fff; border-radius: 8px;
      overflow: hidden; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
    }
    #viewModal iframe {
      width: 100%; height: 100%; border: none;
    }
    #viewModal button.close-btn {
      position: absolute; top: 5px; right: 18px;
      background: #dc3545; color: #fff; border: none;
      padding: 8px 12px; cursor: pointer; border-radius: 4px; font-weight: bold;
    }
    #viewModal button.close-btn:hover { background: #c82333; }
  </style>
</head>
<body>
  <div class="container">
    <h2>Employee List</h2>
    <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search by Name, Branch Code or Employee Type">

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
            </td>
          </tr>
          <?php $i++; endwhile; ?>
      </tbody>
    </table>
  </div>

  <!--  MODAL HTML  -->
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
        const name = rows[i].getElementsByTagName("td")[3].textContent.toUpperCase();   // Name col
        const branch = rows[i].getElementsByTagName("td")[6].textContent.toUpperCase(); // Branch col
        const empType = rows[i].getElementsByTagName("td")[2].textContent.toUpperCase(); // Employee Type col
        rows[i].style.display = (name.includes(input) || branch.includes(input) || empType.includes(input)) ? "" : "none";
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
