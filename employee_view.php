<?php
$slno = $_GET['slno'];
$conn = pg_connect("host=localhost dbname=PROJECT user=postgres password=1035");
$query = "SELECT * FROM employees WHERE slno = $1";
$result = pg_query_params($conn, $query, [$slno]);
$data = pg_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head><title>View Employee</title>
<style>
    body {
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(135deg, #e0e7ff 0%, #f0f2f5 100%);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      min-height: 100vh;
      transition: background 0.5s;
    }
.div {
      background: rgba(255, 255, 255, 0.95);
      padding: 8px 36px 32px 36px;
      margin-top: 400px;
      border-radius: 18px;
      box-shadow: 0 12px 32px rgba(0,0,0,0.13);
      text-align: justify;
      max-width: 750px;
      width: 100%;
      transition: box-shadow 0.3s, transform 0.3s;
      border: 1.5px solid #e3e8f0;
    }

    .div h2 {
        text-align: center;
    }
</style>
</head>
<body>
    <div class="div">
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
    
    <a href="employee_list.php">Back to List</a>
    </div>
</body>
</html>
