<?php
$host = "localhost";
$port = "5432";
$dbname = "PROJECT";
$user = "postgres";
$password = "1035";

$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");
if (!$conn) {
  die("Connection failed: " . pg_last_error());
}

$id = $_POST['id'] ?? $_GET['id'] ?? null;
if (!$id) {
  die("No branch admin ID specified.");
}

$query = "SELECT * FROM branch_admins WHERE id = $1";
$result = pg_query_params($conn, $query, [$id]);

if (!$result || pg_num_rows($result) != 1) {
  die("Branch admin not found.");
}

$admin = pg_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $branch_code = $_POST['branch_code'];
  $dept_code = $_POST['dept_code'];
  $branch_name = $_POST['branch_name'];
  $officer_name = $_POST['officer_name'];
  $designation = $_POST['designation'];
  $district = $_POST['district'];
  $phone = $_POST['phone'];
  $email = $_POST['email'];

  $query = "UPDATE branch_admins
            SET branch_code = $1, dept_code = $2, branch_name = $3, officer_name = $4,
                designation = $5, district = $6, phone = $7, email = $8
            WHERE id = $9";

  $result = pg_query_params($conn, $query, [
    $branch_code, $dept_code, $branch_name, $officer_name, $designation, $district, $phone, $email, $id
  ]);

  if ($result) {
    echo "<script>
      alert('Update successful!');
      window.top.location.reload();
    </script>";
    exit;
  } else {
    echo "<div style='background:#ffe6e6;padding:12px;border-radius:6px;margin:20px 0;color:#a00;'>
            Update failed: " . pg_last_error($conn) . "
          </div>";
  }
}
?>

<style>
  body {
    background: #f4f6fb;
    font-family: 'Segoe UI', Arial, sans-serif;
    margin: 0;
    padding: 0;
  }

  .edit-container {
    max-width: 420px;
    margin: 40px auto;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
    padding: 36px 32px 28px 32px;
  }

  .edit-container h1 {
    text-align: center;
    color: #2d3a4b;
    margin-bottom: 28px;
    font-size: 1.7rem;
    letter-spacing: 1px;
  }

  .edit-form label {
    display: block;
    margin-bottom: 6px;
    color: #34495e;
    font-weight: 500;
    font-size: 1rem;
  }

  .edit-form input[type="text"],
  .edit-form input[type="email"] {
    width: 100%;
    padding: 10px 12px;
    margin-bottom: 18px;
    border: 1px solid #d1d9e6;
    border-radius: 6px;
    font-size: 1rem;
    background: #f8fafc;
    transition: border 0.2s;
  }

  .edit-form input[type="text"]:focus,
  .edit-form input[type="email"]:focus {
    border-color: #4f8cff;
    outline: none;
    background: #fff;
  }

  .edit-form button[type="submit"] {
    width: 100%;
    background: linear-gradient(90deg, #4f8cff 0%, #2355d6 100%);
    color: #fff;
    border: none;
    border-radius: 6px;
    padding: 12px 0;
    font-size: 1.1rem;
    font-weight: 600;
    cursor: pointer;
    box-shadow: 0 2px 8px rgba(79, 140, 255, 0.08);
    transition: background 0.2s;
    margin-top: 8px;
  }

  .edit-form button[type="submit"]:hover {
    background: linear-gradient(90deg, #2355d6 0%, #4f8cff 100%);
  }
</style>

<div class="edit-container">
  <h1>Edit Branch Admin</h1>
  <form class="edit-form" method="POST">
    <input type="hidden" name="id" value="<?php echo htmlspecialchars($admin['id']); ?>">

    <label>Branch Code:</label>
    <input type="text" name="branch_code" value="<?php echo htmlspecialchars($admin['branch_code']); ?>" required>

    <label>Dept Code:</label>
    <input type="text" name="dept_code" value="<?php echo htmlspecialchars($admin['dept_code']); ?>" required>

    <label>Branch Name:</label>
    <input type="text" name="branch_name" value="<?php echo htmlspecialchars($admin['branch_name']); ?>" required>

    <label>Officer Name:</label>
    <input type="text" name="officer_name" value="<?php echo htmlspecialchars($admin['officer_name']); ?>" required>

    <label>Designation:</label>
    <input type="text" name="designation" value="<?php echo htmlspecialchars($admin['designation']); ?>" required>

    <label>District:</label>
    <input type="text" name="district" value="<?php echo htmlspecialchars($admin['district']); ?>" required>

    <label>Phone:</label>
    <input type="text" name="phone" value="<?php echo htmlspecialchars($admin['phone']); ?>" required>

    <label>Email:</label>
    <input type="email" name="email" value="<?php echo htmlspecialchars($admin['email']); ?>" required>

    <button type="submit">Save Changes</button>
  </form>
</div>
