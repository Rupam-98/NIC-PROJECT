<?php
require_once('fpdf186/fpdf.php'); // ✅ Include FPDF library (make sure the folder exists)
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
$selected_branch = $_POST['branch_code'] ?? '';
$dept_info = null;
$branch_info = null;
$employees = [];

// 🔹 Fetch all departments for first dropdown
$codeQuery = "SELECT DISTINCT dept_code, dept_name FROM dept_entry ORDER BY dept_code";
$codeResult = pg_query($conn, $codeQuery);

// 🔹 Fetch department info if selected
if ($selected_code !== '') {
  $deptQuery = "SELECT * FROM dept_entry WHERE dept_code = $1";
  $deptResult = pg_query_params($conn, $deptQuery, [$selected_code]);
  if ($deptResult && pg_num_rows($deptResult) === 1) {
    $dept_info = pg_fetch_assoc($deptResult);
  }

  // 🔹 Fetch branch list for that department
  $branchListQuery = "SELECT branch_code, branch_name FROM branches WHERE dept_code = $1 ORDER BY branch_name";
  $branchListResult = pg_query_params($conn, $branchListQuery, [$selected_code]);
}

// 🔹 Fetch branch info if selected
if ($selected_branch !== '') {
  $branchQuery = "SELECT * FROM branches WHERE branch_code = $1";
  $branchResult = pg_query_params($conn, $branchQuery, [$selected_branch]);
  if ($branchResult && pg_num_rows($branchResult) === 1) {
    $branch_info = pg_fetch_assoc($branchResult);
  }

  // 🔹 Fetch employees for that branch
  $empQuery = "SELECT slno, name, emp_type, desig, phone FROM employees WHERE branch_code = $1 ORDER BY slno ASC";
  $empResult = pg_query_params($conn, $empQuery, [$selected_branch]);
  if ($empResult) {
    while ($row = pg_fetch_assoc($empResult)) {
      $employees[] = $row;
    }
  }
}

// 🔹 Handle PDF Download
if (isset($_POST['download_pdf']) && !empty($employees)) {
  class PDF extends FPDF {
    function Header() {
      $this->SetFont('Arial', 'B', 14);
      $this->Cell(0, 10, 'Employee List Report', 0, 1, 'C');
      $this->Ln(5);
    }

    function Footer() {
      $this->SetY(-15);
      $this->SetFont('Arial', 'I', 8);
      $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
    }
  }

  $pdf = new PDF();
  $pdf->AddPage();
  $pdf->SetFont('Arial', '', 12);

  $pdf->Cell(0, 10, "Department Code: $selected_code", 0, 1);
  $pdf->Cell(0, 10, "Branch Code: $selected_branch", 0, 1);
  $pdf->Ln(5);

  // Table header
  $pdf->SetFont('Arial', 'B', 11);
  $pdf->Cell(20, 10, 'ID', 1);
  $pdf->Cell(50, 10, 'Name', 1);
  $pdf->Cell(35, 10, 'Type', 1);
  $pdf->Cell(45, 10, 'Designation', 1);
  $pdf->Cell(35, 10, 'Phone', 1);
  $pdf->Ln();

  // Table content
  $pdf->SetFont('Arial', '', 10);
  foreach ($employees as $emp) {
    $pdf->Cell(20, 10, $emp['slno'], 1);
    $pdf->Cell(50, 10, $emp['name'], 1);
    $pdf->Cell(35, 10, $emp['emp_type'], 1);
    $pdf->Cell(45, 10, $emp['desig'], 1);
    $pdf->Cell(35, 10, $emp['phone'], 1);
    $pdf->Ln();
  }

  $pdf->Output('D', 'employee_list.pdf');
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>View Department & Branch Info</title>
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

    .sidebar ul li.active>ul {
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

    select,
    button {
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
      margin-bottom: 30px;
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
      width: 160px;
      color: #555;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
      font-size: 0.95rem;
    }

    th,
    td {
      border: 1px solid #ddd;
      padding: 8px 10px;
      text-align: left;
    }

    th {
      background: #4f8cff;
      color: white;
    }

    tr:nth-child(even) {
      background: #f9f9f9;
    }

    .pdf-btn {
      background-color: #2d9f3e;
      color: white;
      width: 15%;
      padding: 10px 16px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      margin-top: 15px;
      font-size: 1rem;
    }

    .pdf-btn:hover {
      background-color: #1e722d;
    }
  </style>
</head>

<body>
  <?php include('sidebar.php'); ?>

  <div class="main-content">

    <!-- Department Selection -->
    <div class="form-box">
      <h2>Select Department</h2>
      <form method="POST">
        <select name="dept_code" required onchange="this.form.submit()">
          <option value="">-- Select Department --</option>
          <?php while ($row = pg_fetch_assoc($codeResult)) { ?>
            <option value="<?php echo htmlspecialchars($row['dept_code']); ?>"
              <?php if ($row['dept_code'] == $selected_code) echo 'selected'; ?>>
              <?php echo htmlspecialchars($row['dept_code']) . ' - ' . htmlspecialchars($row['dept_name']); ?>
            </option>
          <?php } ?>
        </select>
      </form>

      <!-- Branch Selection -->
      <?php if ($dept_info): ?>
        <h2>Select Branch</h2>
        <form method="POST">
          <input type="hidden" name="dept_code" value="<?php echo htmlspecialchars($selected_code); ?>">
          <select name="branch_code" required onchange="this.form.submit()">
            <option value="">-- Select Branch --</option>
            <?php while ($branch = pg_fetch_assoc($branchListResult)) { ?>
              <option value="<?php echo htmlspecialchars($branch['branch_code']); ?>"
                <?php if ($branch['branch_code'] == $selected_branch) echo 'selected'; ?>>
                <?php echo htmlspecialchars($branch['branch_name']); ?>
              </option>
            <?php } ?>
          </select>
        </form>
    </div>
  <?php endif; ?>

  <!-- Branch Info -->
  <?php if ($branch_info): ?>
    <div class="info-box">
      <h3>Branch Details</h3>
      <div><strong>Branch Code:</strong> <?php echo htmlspecialchars($branch_info['branch_code']); ?></div>
      <div><strong>Branch Name:</strong> <?php echo htmlspecialchars($branch_info['branch_name']); ?></div>
      <div><strong>Branch Type:</strong> <?php echo htmlspecialchars($branch_info['branch_type']); ?></div>
      <div><strong>Branch Head:</strong> <?php echo htmlspecialchars($branch_info['head']); ?></div>
      <div><strong>Location:</strong> <?php echo htmlspecialchars($branch_info['address']); ?></div>
    </div>

    <!-- Employee Table -->
    <div class="info-box">
      <h3>Employees in This Branch</h3>
      <?php if (count($employees) > 0): ?>
        <form method="POST">
          <input type="hidden" name="dept_code" value="<?php echo htmlspecialchars($selected_code); ?>">
          <input type="hidden" name="branch_code" value="<?php echo htmlspecialchars($selected_branch); ?>">
          <table>
            <thead>
              <tr>
                <th>Emp ID</th>
                <th>Name</th>
                <th>Type</th>
                <th>Designation</th>
                <th>Phone</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($employees as $emp): ?>
                <tr>
                  <td><?php echo htmlspecialchars($emp['slno']); ?></td>
                  <td><?php echo htmlspecialchars($emp['name']); ?></td>
                  <td><?php echo htmlspecialchars($emp['emp_type']); ?></td>
                  <td><?php echo htmlspecialchars($emp['desig']); ?></td>
                  <td><?php echo htmlspecialchars($emp['phone']); ?></td>
                  <td>
                    <a href="employee_details.php?id=<?php echo urlencode($emp['slno']); ?>" class="btn-action">View</a>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
          <button type="submit" name="download_pdf" class="pdf-btn"><i class="fa fa-download"></i> Download PDF</button>
        </form>
      <?php else: ?>
        <p>No employees found for this branch.</p>
      <?php endif; ?>
    </div>
  <?php endif; ?>

  </div>
  <script>
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

