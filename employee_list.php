<?php
session_start();

// Only allow branch_admins
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'branch_admin') {
    echo "<script>
        alert('Unauthorized access. Only Branch Admins are allowed.');
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

$query = "SELECT * FROM employees WHERE branch_code = $1 ORDER BY slno ASC";
$result = pg_query_params($conn, $query, [$branchCode]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="" />
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

        
.sidebar {
    margin-left: -28px;
  position: relative;
  top: 0;
  width: 275px;
  height: 100vh;
  background-color: #2c3e50;
  color: #fff;
  position: fixed;
  overflow-y: auto;
  box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
}

.sidebar .welcome-section {
  text-align: center;
  padding: 30px 20px 20px;
  border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.sidebar .welcome-section img {
  width: 70px;
  height: 70px;
  border-radius: 50%;
  object-fit: cover;
  margin-bottom: 10px;
  border: 2px solid #3498db;
}

.sidebar .welcome-section h3 {
  margin: 5px 0 0;
}

.sidebar .welcome-section p {
  margin: 5px 0 0;
  font-size: 14px;
  color: #ddd;
}

.sidebar ul {
  list-style: none;
  padding: 0;
  margin-top: 20px;
}

.sidebar ul li {
  border-bottom: 1px solid rgba(255, 255, 255, 0.05);
}

.sidebar ul li a {
  color: #fff;
  text-decoration: none;
  display: block;
  padding: 15px 20px;
  transition: all 0.5s ease;
}

.sidebar ul li a:hover {
  background: #3498db;
  padding-left: 30px;
}

.sidebar i {
  margin-right: 10px;
}

        body {
            font-family: Arial, sans-serif;
            background: #f4f7f8;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin-left: 275px;
            background: #eeeeee73;
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

        .view { background-color: #17a2b8; color: white; }
        .edit { background-color: #ffc107; color: black; }
        .delete { background-color: #dc3545; color: white; }
        
      #viewModal {
  position: fixed;
  top: 40px;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.7);
  z-index: 1000;
  justify-content: center;
  align-items: center;
  display: none; /* this MUST be last */
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

        <div class="sidebar">
    <div class="welcome-section">
      <img src="image\user.jpg" alt="User" />
      <h3>Welcome!</h3>
      <p>Branch Admin</p>
    </div>
    <ul>
      <li><a href="branch_dashboard.html"> <i class="fas fa-home"></i> Home</a></li>
      <li><a href="#"><i class="fas fa-user"></i> Profile</a></li>
      <li class="dropdown">
        <a onclick="toggledropdown(event)">
          <i class="fas fa-users" ></i> Employees  <i class="fa fa-plus"></i>
        </a>
        <ul class="dropdown-menu">
          <li><a href="employee_list.php">Employee List</a></li>
          <li><a href="employee.php"> Employee Entry</a></li>

        </ul>
      </li>
      <li><a href="#"><i class="fas fa-chart-line"></i> Reports</a></li>
      <li><a href="#"><i class="fas fa-cog"></i> Settings</a></li>
      <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
    </ul>
  </div>

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
                <button class="view" onclick="openModal(<?= $row['slno'] ?>)">View More</button>

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
