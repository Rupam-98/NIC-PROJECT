<?php


// Protect access
if ($_SESSION['role'] !== 'department_admin' || !isset($_SESSION['dept_code'])) {
    die("Access denied");
}

$dept_code = pg_escape_string($conn, $_SESSION['dept_code']);

// Only employees from this department
$query = "SELECT * FROM employees WHERE dept_code = '$dept_code' ORDER BY slno ASC";

$result = pg_query($conn, $query);
if (!$result) {
    die("Query failed: " . pg_last_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Department Dashboard - Employees</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f7f8;
            padding: 20px;
        }

        .container {
            margin: auto;
            width: 78%;
            margin-left: 18%;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        #searchInput {
            width: 98%;
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
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        thead {
            background: #007BFF;
            color: white;
        }

        tr:nth-child(even) {
            background: #f2f2f2;
        }

        .view {
            background: #17a2b8;
            color: #fff;
            border: none;
            padding: 6px 10px;
            cursor: pointer;
            border-radius: 4px;
        }

        #viewModal {
            position: fixed;
            top: 0;
            left: 0;
            width: 50%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            justify-content: center;
            align-items: center;
            overflow-y: scroll;
        }

        #viewModal .modal-content {
            position: relative;
            width: 50%;
            height: 80%;
            background: #fff;
            border-radius: 8px;
            overflow-y: scroll;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            padding: 20px;
        }

        #viewModal {
            width: 100%;
            height: 100%;
            border: none;
        }

        #viewModal .close-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background: #dc3545;
            color: #fff;
            border: none;
            padding: 8px 12px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
        }

        .modal-content {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            overflow-x: hidden;
        }

        #modalBody {
            padding: 20px;
            background-color: #f6f6f6;
            width: 80%;
            height: auto;
            /* overflow-y: auto; */
            border: 1px solid #dddadaff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            margin-top: 320px;
            border-radius: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>My Department Employees</h2>
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
                <?php $i = 1;
                while ($row = pg_fetch_assoc($result)) : ?>
                    <tr>
                        <td><?= $i ?></td>
                        <td><?= htmlspecialchars($row['slno']) ?></td>
                        <td><?= htmlspecialchars($row['emp_type']) ?></td>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td><?= htmlspecialchars($row['desig']) ?></td>
                        <td><?= htmlspecialchars($row['phone']) ?></td>
                        <td><?= htmlspecialchars($row['branch_code']) ?></td>
                        <td><button class="view" onclick="openModal(<?= $row['slno'] ?>)">View</button></td>
                    </tr>
                <?php $i++;
                endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div id="viewModal">
        <div class="modal-content">
            <div id="modalBody"></div>
            <button class="close-btn" onclick="closeModal()">Close</button>
        </div>
    </div>

    <script>
        function searchTable() {
            const input = document.getElementById("searchInput").value.toUpperCase();
            const rows = document.getElementById("employeeTable").getElementsByTagName("tr");
            for (let i = 1; i < rows.length; i++) {
                const name = rows[i].getElementsByTagName("td")[3].textContent.toUpperCase();
                const branchCode = rows[i].getElementsByTagName("td")[6].textContent.toUpperCase();
                const empType = rows[i].getElementsByTagName("td")[2].textContent.toUpperCase();

                rows[i].style.display = name.includes(input) || branchCode.includes(input) || empType.includes(input) ? "" : "none";
            }
        }

        function openModal(slno) {
            const modal = document.getElementById('viewModal');
            const modalBody = document.getElementById('modalBody');

            fetch('employee_view_dept.php?slno=' + slno)
                .then(response => response.text())
                .then(html => {
                    modalBody.innerHTML = html;
                    modal.style.display = 'flex';
                })
                .catch(err => {
                    modalBody.innerHTML = "<p style='color:red;'>Error loading data.</p>";
                    modal.style.display = 'flex';
                });
        }

        function closeModal() {
            document.getElementById('viewModal').style.display = 'none';
            document.getElementById('modalBody').innerHTML = '';
        }
    </script>
</body>

</html>