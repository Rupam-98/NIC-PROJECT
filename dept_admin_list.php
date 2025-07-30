<?php
// Connect to your DB
$host = "localhost";
$port = "5432";
$dbname = "PROJECT";
$user = "postgres";
$password = "1035";
$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");
if (!$conn) {
  die("Connection failed: " . pg_last_error());
}

// Fetch only department admins from unified admins table
$query = "SELECT * FROM admins WHERE role = 'department_admin'";
$result = pg_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Department Admin List</title>
  <link rel="stylesheet" href="DA_List.css" />
  <link rel="stylesheet" href="system_admin_dashboard.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

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
  </style>
</head>

<body>

  <div class="main-content">

    <div class="sidebar">
      <h2>System Admin</h2>
      <ul>
        <li><a href="system_dashboard.php"><i class="fas fa-home"></i> Dashboard</a></li>

        <li class="dropdown">
          <a onclick="toggledropdown(event)">
            <i class="fas fa-users"></i> Department <i class="fa fa-plus"></i>
          </a>
          <ul class="dropdown-menu">
            <li><a href="dept_entry.php">Dept. Entry Form</a></li>
            <li><a href="add_dept_admin.php">Admin Entry</a></li>
            <li><a href="dept_admin_list.php">Dept. Admin List</a></li>
          </ul>
        </li>

        <li class="dropdown">
          <a onclick="toggledropdown(event)">
            <i class="fas fa-users"></i> Branch <i class="fa fa-plus"></i>
          </a>
          <ul class="dropdown-menu">
            <li><a href="branch_admin_list.php">Branch Admin List</a></li>
          </ul>
        </li>

        <li class="dropdown">
          <a onclick="toggledropdown(event)">
            <i class="fas fa-cog"></i> Settings <i class="fa fa-plus"></i>
          </a>
          <ul class="dropdown-menu">
            <li><a href="#">Update</a></li>
            <li><a href="#">Change Password</a></li>
          </ul>
        </li>

        <li><a href="main.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
      </ul>
    </div>

    <div class="admin-container">
      <h1>Department Admin List</h1>
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>DEPT CODE</th>
            <th>DEPT NAME</th>
            <th>OFFICER NAME</th>
            <th>DESIGNATION</th>
            <th>DISTRICT</th>
            <th>EMAIL</th>
            <th>PHONE</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = pg_fetch_assoc($result)) : ?>
            <tr>
              <td><?php echo htmlspecialchars($row['id']); ?></td>
              <td><?php echo htmlspecialchars($row['dept_code']); ?></td>
              <td><?php echo htmlspecialchars($row['dept_name']); ?></td>
              <td><?php echo htmlspecialchars($row['officer_name']); ?></td>
              <td><?php echo htmlspecialchars($row['designation']); ?></td>
              <td><?php echo htmlspecialchars($row['district']); ?></td>
              <td><?php echo htmlspecialchars($row['email']); ?></td>
              <td><?php echo htmlspecialchars($row['phone']); ?></td>
              <td>
                <a class="action-links" href="javascript:void(0);" onclick="openIframeModal(<?php echo $row['id']; ?>)">
                  <i class="fas fa-edit"></i> Edit
                </a>
                <a class="action-links" href="delete_admin.php?id=<?php echo $row['id']; ?>"
                  onclick="return confirm('Are you sure you want to delete this record?');">
                  <i class="fas fa-trash"></i> Delete
                </a>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>

    <!-- ✅ Modal for Edit -->
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
        $('#editIframe').attr('src', 'DA_edit.php?id=' + id);
        $('#editModal').show();
      }

      $('.close').click(function () {
        $('#editModal').hide();
        $('#editIframe').attr('src', '');
      });

      window.onclick = function (event) {
        if (event.target.id === 'editModal') {
          $('#editModal').hide();
          $('#editIframe').attr('src', '');
        }
      };

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
  </div>
</body>

</html>
