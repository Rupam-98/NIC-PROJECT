<?php
// DB Connection
$host = "localhost";
$dbname = "PROJECT";
$user = "postgres";
$password = "1035";
$conn = pg_connect("host=$host dbname=$dbname user=$user password=$password");
if (!$conn) {
    die("Connection failed: " . pg_last_error());
}

$query = "SELECT * FROM employees ORDER BY slno ASC";
$result = pg_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Employee List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f7f8;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
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

        th, td {
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

        tr:hover {
            background-color: #e0e0e0;
        }

        .action-btns button {
            margin-right: 5px;
            padding: 6px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
        }

        .view { background-color: #17a2b8; color: white; }
        .edit { background-color: #ffc107; color: black; }
        .delete { background-color: #dc3545; color: white; }
    </style>
</head>
<body>
<div class="container">
    <h2>Employee List</h2>
    <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search by Name or Branch Code">

    <table id="employeeTable">
        <thead>
            <tr>
                <th>Sl No</th>
                <th>Name</th>
                <th>Designation</th>
                <th>Phone</th>
                <th>Branch Code</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = pg_fetch_assoc($result)) : ?>
            <tr>
                <td><?= htmlspecialchars($row['slno']) ?></td>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['desig']) ?></td>
                <td><?= htmlspecialchars($row['phone']) ?></td>
                <td><?= htmlspecialchars($row['branch_code']) ?></td>
                <td class="action-btns">
                    <form method="get" action="employee_view.php" style="display:inline;">
                        <input type="hidden" name="slno" value="<?= $row['slno'] ?>">
                        <button class="view">View</button>
                    </form>
                    <form method="get" action="employee_edit.php" style="display:inline;">
                        <input type="hidden" name="slno" value="<?= $row['slno'] ?>">
                        <button class="edit">Edit</button>
                    </form>
                    <form method="post" action="employee_delete.php" style="display:inline;" onsubmit="return confirm('Are you sure to delete?');">
                        <input type="hidden" name="slno" value="<?= $row['slno'] ?>">
                        <button class="delete">Delete</button>
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
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
</script>
</body>
</html>
<?php pg_close($conn); ?>
