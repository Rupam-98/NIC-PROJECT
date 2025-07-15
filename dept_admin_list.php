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

$query = "SELECT * FROM dept_admins";
$result = pg_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Department Admin List</title>
  <link rel="stylesheet" href="DA_List.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
  <div class="admin-container">
    <h1>Admin List</h1>
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
              &nbsp;&nbsp;
              <a class="action-links" href="delete_student.php?id=<?php echo $row['id']; ?>"
                onclick="return confirm('Are you sure you want to delete this record?');">
                <i class="fas fa-trash"></i> Delete
              </a>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>

    <a href="#" target="_blank">Download data</a>
    <a href="#" target="_blank">HOME</a>
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
      $('#editIframe').attr('src', 'DA_edit.php?id=' + id);
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
  </script>
</body>

</html>