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

$query = "SELECT * FROM admins WHERE role = 'branch_admin' ORDER BY branch_code ASC";
$result = pg_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Branch Admin List</title>
     <link rel="stylesheet" href="system_admin_dashboard.css" />
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <style>

     .sidebar ul li ul {
      display: none;
      list-style-type: none;
     margin-left: 30px;
      padding: 0;
      
    }
    .sidebar ul li.active > ul {
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

        /* table tr:hover {
            background-color: #e0e0e0;
        } */
          .action-links {
        display: inline-flex;
        margin-top: 4px;
        margin-right: 20px;
        background: #1f9d00;
        color: #fff;
       padding: 5px 5px;
        border-radius: 4px;
        text-decoration: none;
        transition: background 0.2s ease;
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

        <div class="main-content">
    
  <div class="sidebar">
    <h2>System Admin</h2>
    <ul>
      <li><a href="system_dashboard.html"><i class="fas fa-home"></i> Dashboard</a></li>

      <li class="dropdown">
        <a onclick="toggledropdown(event)">
          <i class="fas fa-users" ></i> Department<i class="fa fa-plus"></i>
        </a>
        <ul class="dropdown-menu">
          <li><a href="dept_entry.html"> Dept. Entry Form</a></li>
          <li><a href="add_dept_admin.html"> Admin Entry</a></li>
          <li><a href="dept_admin_list.php">Dept. Admin List</a></li>
        </ul>
      </li>



       <li class="dropdown">
        <a onclick="toggledropdown(event)">
          <i class="fas fa-users" ></i> Branch<i class="fa fa-plus"></i>
        </a>
        <ul class="dropdown-menu">
          <!-- <li><a href="branch_entry.html"> Branch Entry Form</a></li>
          <li><a href="add_branch_admin.html"> Admin Entry</a></li> -->
          <li><a href="branch_admin_list.php"> Branch Admin List</a></li>
        </ul>
      </li>

      <li class="dropdown">
        <a onclick="toggledropdown(event)">
          <i class="fas fa-cog"></i>Settings<i class="fa fa-plus"></i>
        </a>
        <ul class="dropdown-menu">
          <li><a href="#">Update</a></li>
          <li><a href="#">Change Password</a></li>
        </ul>
      </li>

      <li><a href="main.html"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
    </ul>
  </div>

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
                <th>Actions</th>
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
                     <td>
                <a class="action-links" href="javascript:void(0);" onclick="openIframeModal(<?php echo $row['id']; ?>)">
                <i class="fas fa-edit"></i> Edit
                </a>
              
                <a class="action-links" href="BA_delete.php?id=<?php echo $row['id']; ?>"
                onclick="return confirm('Are you sure you want to delete this record?');">
                <i class="fas fa-trash"></i> Delete
              </a>
            </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

              
  <!-- ✅ New iframe modal -->
  <div id="editModal" class="modal" style="display:none;">
    <div class="modal-content">
      <span class="close" style="float:right; cursor:pointer; font-size:24px;">&times;</span>
      <iframe id="editIframe" style="width:100%; height:600px; border:none;"></iframe>
    </div>
  </div>

  <style>
    .modal {
      display: none;
      position: fixed;
      z-index: 9999;
      padding-top: 60px;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgba(0, 0, 0, 0.5);
    }

    .modal-content {
      background-color: #fff;
      margin: auto;
      padding: 0;
      border: 1px solid #888;
      width: 60%;
      border-radius: 8px;
      overflow: hidden;
    }
  </style>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    function openIframeModal(id) {
      $('#editIframe').attr('src', 'BA_edit.php?id=' + id);
      $('#editModal').show();
    }

    $('.close').click(function() {
      $('#editModal').hide();
      $('#editIframe').attr('src', '');
    });

    window.onclick = function(event) {
      if (event.target.id === 'editModal') {
        $('#editModal').hide();
        $('#editIframe').attr('src', '');
      }
    };


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
  

</script>

</body>
</html>
<?php pg_close($conn); ?>
