<?php
require 'vendor/autoload.php'; // if you use PhpSpreadsheet

use PhpOffice\PhpSpreadsheet\IOFactory;

if (isset($_FILES['import_file']['tmp_name'])) {
  $file = $_FILES['import_file']['tmp_name'];

  $spreadsheet = IOFactory::load($file);
  $sheet = $spreadsheet->getActiveSheet();
  $rows = $sheet->toArray();

  $conn = pg_connect("host=localhost dbname=PROJECT user=postgres password=1035");

  foreach ($rows as $index => $row) {
    if ($index === 0) continue; // skip header

    list($slno, $dept_code, $department, $branch_code, $branch_address, $name,
         $desig, $sex, $age, $epic, $phone, $home_lac, $residential_lac,
         $branch_lac, $basic, $gazeted, $remarks, $education,
         $dor, $ac_no, $ifsc_code, $branch_name, $bank_branch_address, $emp_type) = $row;

    $gazeted = $gazeted == "1" ? "yes" : "no";

    $query = "
      INSERT INTO employees (
        slno, dept_code, department, branch_code, branch_address, name, desig, sex, age, epic, phone,
        home_lac, residential_lac, branch_lac, basic, gazeted, remarks, education, dor,
        ac_no, ifsc_code, branch_name, bank_branch_address, emp_type
      ) VALUES (
        $1, $2, $3, $4, $5, $6, $7, $8, $9, $10,
        $11, $12, $13, $14, $15, $16, $17, $18, $19, $20,
        $21, $22, $23, $24
      )
    ";

    $result = pg_query_params($conn, $query, [
      $slno, $dept_code, $department, $branch_code, $branch_address, $name,
      $desig, $sex, $age, $epic, $phone, $home_lac, $residential_lac,
      $branch_lac,  $basic, $gazeted, $remarks, $education,
      $dor, $ac_no, $ifsc_code, $branch_name, $bank_branch_address, $emp_type
    ]);

    if (!$result) {
      die("Error inserting row $index: " . pg_last_error($conn));
    }
  }

  pg_close($conn);

  echo "<script>alert('Employees imported successfully!'); window.location.href='employee.php';</script>";
} else {
  echo "No file uploaded.";
}
