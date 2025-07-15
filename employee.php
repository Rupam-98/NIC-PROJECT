<?php
// Database connection settings
$host = "localhost";
$dbname = "employee_db";
$user = "postgres";
$password = "yourpassword";

// Connect to PostgreSQL
$conn = pg_connect("host=$host dbname=$dbname user=$user password=$password");

if (!$conn) {
    die("Connection failed: " . pg_last_error());
}

// Collect POST data
$data = [
    'slno' => $_POST['slno'],
    'depcode' => $_POST['depcode'],
    'department' => $_POST['department'],
    'branch_code' => $_POST['branch_code'],
    'branch_address' => $_POST['branch_address'],
    'name' => $_POST['name'],
    'desig' => $_POST['desig'],
    'sex' => $_POST['sex'],
    'age' => $_POST['age'],
    'epic' => $_POST['epic'],
    'phone' => $_POST['phone'],
    'home_lac' => $_POST['home_lac'],
    'residential_lac' => $_POST['residential_lac'],
    'branch_lac' => $_POST['branch_lac'],
    'beeo_code' => $_POST['beeo_code'],
    'basic' => $_POST['basic'],
    'gazeted' => $_POST['gazeted'] === "1" ? "TRUE" : "FALSE",
    'remarks' => $_POST['remarks'],
    'education' => $_POST['education'],
    'dor' => $_POST['dor'],
    'ac_no' => $_POST['ac_no'],
    'ifsc_code' => $_POST['ifsc_code'],
    'branch_name' => $_POST['branch_name'],
    'bank_branch_address' => $_POST['bank_branch_address']
];

// Insert query
$query = "INSERT INTO employees (
    slno, depcode, department, branch_code, branch_address, name, desig, sex, age, epic, phone,
    home_lac, residential_lac, branch_lac, beeo_code, basic, gazeted, remarks, education, dor,
    ac_no, ifsc_code, branch_name, bank_branch_address
) VALUES (
    '{$data['slno']}', '{$data['depcode']}', '{$data['department']}', '{$data['branch_code']}',
    '{$data['branch_address']}', '{$data['name']}', '{$data['desig']}', '{$data['sex']}',
    '{$data['age']}', '{$data['epic']}', '{$data['phone']}', '{$data['home_lac']}',
    '{$data['residential_lac']}', '{$data['branch_lac']}', '{$data['beeo_code']}',
    '{$data['basic']}', {$data['gazeted']}, '{$data['remarks']}', '{$data['education']}',
    '{$data['dor']}', '{$data['ac_no']}', '{$data['ifsc_code']}', '{$data['branch_name']}',
    '{$data['bank_branch_address']}'
)";

// Execute query
$result = pg_query($conn, $query);

if ($result) {
    echo "Employee record inserted successfully!";
} else {
    echo "Error: " . pg_last_error($conn);
}

pg_close($conn);
?>
