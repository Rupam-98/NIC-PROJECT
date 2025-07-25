<?php
$host = "localhost";
$dbname = "PROJECT";
$user = "postgres";
$password = "1035";

$conn = pg_connect("host=$host dbname=$dbname user=$user password=$password");
if (!$conn) {
  die("Connection failed: " . pg_last_error());
}

$query = "SELECT * FROM systemlogin ORDER BY id ASC";
$result = pg_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>User List</title>
  <style>
    body {
      background: #f4f6fb;
      font-family: 'Segoe UI', Arial, sans-serif;
      margin: 0;
      padding: 40px;
    }

    h1 {
      text-align: center;
      color: #333;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
      background: #fff;
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 2px 12px rgba(0,0,0,0.05);
    }

    th, td {
      padding: 12px 16px;
      border: 1px solid #ddd;
      text-align: left;
      font-size: 0.95rem;
    }

    th {
      background: #4f8cff;
      color: #fff;
    }

    tr:nth-child(even) {
      background: #f9f9f9;
    }

    a.action-btn {
      text-decoration: none;
      padding: 6px 10px;
      border-radius: 4px;
      color: #fff;
      font-weight: 500;
      font-size: 0.85rem;
    }

    .edit {
      background: #4f8cff;
    }

    .delete {
      background: #d9534f;
    }
  </style>
</head>
<body>
  <h1>User Profile</h1>

  <table>
    <thead>
      <tr>
        <!-- <th>ID</th> -->
        <th>Full Name</th>
        <th>Gender</th>
        <th>DOB</th>
        <!-- <th>Username</th> -->
        <th>Phone</th>
        <!-- <th>Admin Type</th> -->
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
    <?php while ($row = pg_fetch_assoc($result)): ?>
      <tr>
        <!-- <td><?= htmlspecialchars($row['id']) ?></td> -->
        <td><?= htmlspecialchars($row['full_name']) ?></td>
        <td><?= htmlspecialchars($row['gender']) ?></td>
        <td><?= htmlspecialchars($row['dob']) ?></td>
        <!-- <td><?= htmlspecialchars($row['username']) ?></td> -->
        <td><?= htmlspecialchars($row['phone_number']) ?></td>
        <!-- <td><?= htmlspecialchars($row['admin_type']) ?></td> -->
        <td>
          <a class="action-btn edit" href="edit_user.php?id=<?= $row['id'] ?>">Edit</a>
          <a class="action-btn delete" href="delete_user.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure?');">Delete</a>
        </td>
      </tr>
    <?php endwhile; ?>
    </tbody>
  </table>
  <!-- Modal -->
<div id="modal" style="display:none; position:fixed; top:10%; left:20%; width:60%; height:70%; background:white; border:2px solid #444; z-index:9999;">
  <button onclick="closeModal()" style="float:right;">X</button>
  <iframe id="modalFrame" style="width:100%; height:90%; border:none;"></iframe>
</div>

<script>
function openModal(id) {
  document.getElementById('modalFrame').src = 'edit_user.php?id=' + id;
  document.getElementById('modal').style.display = 'block';
}
function closeModal() {
  document.getElementById('modal').style.display = 'none';
  document.getElementById('modalFrame').src = '';
}
</script>
</body>
</html>

<?php pg_close($conn); ?>
