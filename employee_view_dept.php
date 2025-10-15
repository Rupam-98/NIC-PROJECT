<?php
session_start();
$conn = pg_connect("host=localhost dbname=PROJECT user=postgres password=1035");

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'department_admin') {
    echo "<p style='color:red;'>Unauthorized access</p>";
    exit;
}

$deptCode = $_SESSION['dept_code'] ?? null;
$slno = $_GET['slno'] ?? null;

if (!$deptCode || !$slno || !is_numeric($slno)) {
    echo "<p style='color:red;'>Invalid employee request</p>";
    exit;
}

$query = "SELECT * FROM employees WHERE slno = $1 AND dept_code = $2";
$result = pg_query_params($conn, $query, [$slno, $deptCode]);

if (!$result || pg_num_rows($result) === 0) {
    echo "<p style='color:red;'>No employee found</p>";
    exit;
}

$data = pg_fetch_assoc($result);
?>

<h2>Employee Details</h2>
<p><strong>Dept code :</strong> <?= htmlspecialchars($data['dept_code']) ?></p>
<p><strong>Department :</strong> <?= htmlspecialchars($data['department']) ?></p>
<p><strong>Branch Code :</strong> <?= htmlspecialchars($data['branch_code']) ?></p>
<p><strong>Branch Address:</strong> <?= htmlspecialchars($data['branch_address']) ?></p>
<p><strong>Name:</strong> <?= htmlspecialchars($data['name']) ?></p>
<p><strong>Designation:</strong> <?= htmlspecialchars($data['desig']) ?></p>
<p><strong>Gender :</strong> <?= htmlspecialchars($data['sex']) ?></p>
<p><strong>Age :</strong> <?= htmlspecialchars($data['age']) ?></p>
<p><strong>Voter (Epic):</strong> <?= htmlspecialchars($data['epic']) ?></p>
<p><strong>Phone:</strong> <?= htmlspecialchars($data['phone']) ?></p>
<p><strong>Home LAC :</strong> <?= htmlspecialchars($data['home_lac']) ?></p>
<p><strong>Residential LAC:</strong> <?= htmlspecialchars($data['residential_lac']) ?></p>
<p><strong>Work LAC:</strong> <?= htmlspecialchars($data['branch_lac']) ?></p>
<p><strong>Basic :</strong> <?= htmlspecialchars($data['basic']) ?></p>
<p><strong>Gazeted :</strong> <?= htmlspecialchars($data['gazeted']) ?></p>
<p><strong>Remarks :</strong> <?= htmlspecialchars($data['remarks']) ?></p>
<p><strong>Education :</strong> <?= htmlspecialchars($data['education']) ?></p>
<p><strong>Date of Retirement :</strong> <?= htmlspecialchars($data['dor']) ?></p>
<p><strong>A/c No :</strong> <?= htmlspecialchars($data['ac_no']) ?></p>
<p><strong>IFSC Code :</strong> <?= htmlspecialchars($data['ifsc_code']) ?></p>
<p><strong>Branch Name:</strong> <?= htmlspecialchars($data['branch_name']) ?></p>
<p><strong>Bank Branch Address:</strong> <?= htmlspecialchars($data['bank_branch_address']) ?></p>
