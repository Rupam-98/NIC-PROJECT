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

$selected_code = $_POST['dept_code'] ?? '';
$selected_name = $_POST['dept_name'] ?? '';
$dept_info = null;

if ($selected_code !== '') {
  $query = "SELECT * FROM dept_entry WHERE dept_code = $1 ";
  $result = pg_query_params($conn, $query, [$selected_code]);

  if ($result && pg_num_rows($result) === 1) {
    $dept_info = pg_fetch_assoc($result);
  }
}

// Fetch list of all dept_codes
$codeQuery = "SELECT DISTINCT dept_code, dept_name FROM dept_entry ORDER BY dept_code, dept_name";
$codeResult = pg_query($conn, $codeQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>View Department Info</title>
    <link rel="stylesheet" href="system_admin_dashboard.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <style>
    body {
      background: #f4f6fb;
      font-family: 'Segoe UI', Arial, sans-serif;
      margin: 0;
      padding: 0;
      display: flex;
    }
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
    .main-content {
      flex-grow: 1;
      padding: 40px;
    }

    .form-box {
      background: #fff;
      border-radius: 12px;
      margin-left: 30%;
      padding: 28px;
      max-width: 480px;
      margin-bottom: 30px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    .form-box h2 {
      margin-bottom: 20px;
      color: #2d3a4b;
      font-size: 1.5rem;
      text-align: center;
    }

    select, button {
      width: 100%;
      padding: 10px;
      margin-bottom: 20px;
      font-size: 1rem;
      border-radius: 6px;
      border: 1px solid #ccc;
    }

    button {
      background-color: #4f8cff;
      color: white;
      font-weight: bold;
      border: none;
      cursor: pointer;
      transition: background 0.3s;
    }

    button:hover {
      background-color: #2355d6;
    }

    .info-box {
      background: #fff;
      padding: 24px;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    .info-box h3 {
      margin-top: 0;
      color: #333;
      margin-bottom: 16px;
    }

    .info-item {
      margin-bottom: 10px;
      font-size: 1rem;
    }

    .info-item strong {
      display: inline-block;
      width: 140px;
      color: #555;
    }
  </style>
</head>
<body>
  <?php include('sidebar.php'); ?>

  <div class="main-content">
    <div class="form-box">
      <h2>Select Department Code</h2>
      <form method="POST">
        <select name="dept_code" required>
          <option value="">-- Select Department Code --</option>
          <?php while ($row = pg_fetch_assoc($codeResult)) { ?>
            <option value="<?php echo htmlspecialchars($row['dept_code']); ?>" <?php if ($row['dept_code'] == $selected_code) echo 'selected'; ?>>
              <?php echo htmlspecialchars($row['dept_code']); ?> - <?php echo htmlspecialchars($row['dept_name']); ?>
            </option>
          <?php } ?>
        </select>
        <button type="submit">View Info</button>
      </form>
    </div>

    <?php if ($dept_info): ?>
      <div class="info-box">
        <h3>Department Details</h3>
        <div class="info-item"><strong>Department Code:</strong> <?php echo htmlspecialchars($dept_info['dept_code']); ?></div>
        <div class="info-item"><strong>Department Name:</strong> <?php echo htmlspecialchars($dept_info['dept_name']); ?></div>
        <div class="info-item"><strong>Department Type:</strong> <?php echo htmlspecialchars($dept_info['dept_type']); ?></div>
        <div class="info-item"><strong>Department Location:</strong> <?php echo htmlspecialchars($dept_info['address']); ?></div>
        <div class="info-item"><strong>Department Head:</strong> <?php echo htmlspecialchars($dept_info['head']); ?></div>

      </div>
    <?php elseif ($selected_code !== ''): ?>
      <div class="info-box">
        <p>No department found for the selected code.</p>
      </div>
    <?php endif; ?>
  </div>

    <script>
    function toggledropdown(event) {
      event.stopPropagation(); 
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
