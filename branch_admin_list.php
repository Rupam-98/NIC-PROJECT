<?php
// Connect to PostgreSQL DB
$host = "localhost";
$port = "5432";
$dbname = "PROJECT";
$user = "postgres";
$password = "1035";
$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

if (!$conn) {
    die("Connection failed: " . pg_last_error());
}

// Fetch data from branch_admins table
$query = "SELECT * FROM branch_admins ORDER BY id ASC";
$result = pg_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Branch Admin List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7f8;
            padding: 20px;
        }

        .container {
            max-width: 1100px;
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

        table thead {
            background-color: #007BFF;
            color: white;
        }

        table th, table td {
            padding: 12px 15px;
            border: 1px solid #ddd;
            text-align: left;
        }

        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        table tr:hover {
            background-color: #e0e0e0;
        }

        @media screen and (max-width: 768px) {
            table, thead, tbody, th, td, tr {
                display: block;
            }

            thead tr {
                display: none;
            }

            td {
                padding-left: 50%;
                position: relative;
                border: none;
                border-bottom: 1px solid #ddd;
            }

            td::before {
                position: absolute;
                top: 12px;
                left: 15px;
                width: 45%;
                padding-right: 10px;
                white-space: nowrap;
                font-weight: bold;
            }

            td:nth-of-type(1)::before { content: "ID"; }
            td:nth-of-type(2)::before { content: "Branch Code"; }
            td:nth-of-type(3)::before { content: "Dept Code"; }
            td:nth-of-type(4)::before { content: "Branch Name"; }
            td:nth-of-type(5)::before { content: "Officer Name"; }
            td:nth-of-type(6)::before { content: "Designation"; }
            td:nth-of-type(7)::before { content: "District"; }
            td:nth-of-type(7)::before { content: "Phone"; }
            td:nth-of-type(8)::before { content: "Email"; }
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Branch Admin List</h2>

    <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search by Officer Name or Branch Code">

    <table id="adminTable">
        <thead>
            <tr>
                <th>Id</th>
                <th>Branch Code</th>
                <th>Dept Code</th>
                <th>Branch Name</th>
                <th>Officer Name</th>
                <th>Designation</th>
                <th>District</th>
                <th>Phone</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = pg_fetch_assoc($result)): ?>
                <tr>
                    <td><?= htmlspecialchars($row['id']) ?></td>
                    <td><?= htmlspecialchars($row['branch_code']) ?></td>
                    <td><?= htmlspecialchars($row['dept_code']) ?></td>
                    <td><?= htmlspecialchars($row['branch_name']) ?></td>
                    <td><?= htmlspecialchars($row['officer_name']) ?></td>
                    <td><?= htmlspecialchars($row['designation']) ?></td>
                    <td><?= htmlspecialchars($row['district']) ?></td>
                    <td><?= htmlspecialchars($row['phone']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script>
function searchTable() {
    const input = document.getElementById("searchInput").value.toUpperCase();
    const table = document.getElementById("adminTable");
    const tr = table.getElementsByTagName("tr");

    for (let i = 1; i < tr.length; i++) {
        const officerName = tr[i].getElementsByTagName("td")[4];
        const branchCode = tr[i].getElementsByTagName("td")[1];

        if (officerName || branchCode) {
            const officerVal = officerName.textContent || officerName.innerText;
            const branchVal = branchCode.textContent || branchCode.innerText;
            tr[i].style.display = (officerVal.toUpperCase().indexOf(input) > -1 || branchVal.toUpperCase().indexOf(input) > -1)
                ? ""
                : "none";
        }
    }
}
</script>

</body>
</html>
<?php pg_close($conn); ?>
