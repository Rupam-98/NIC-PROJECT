<?php

$host = "localhost";
$dbname = "PROJECT";
$user = "postgres";
$password = "695847";


$conn = pg_connect("host=$host dbname=$dbname user=$user password=$password");

if (!$conn) {
    die("Connection failed: " . pg_last_error());
}


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


$query = "
    INSERT INTO employees (
        slno, depcode, department, branch_code, branch_address, name, desig, sex, age, epic, phone,
        home_lac, residential_lac, branch_lac, beeo_code, basic, gazeted, remarks, education, dor,
        ac_no, ifsc_code, branch_name, bank_branch_address
    ) VALUES (
        $1, $2, $3, $4, $5, $6, $7, $8, $9, $10,
        $11, $12, $13, $14, $15, $16, $17, $18, $19, $20,
        $21, $22, $23, $24
    )
";


$result = pg_query_params($conn, $query, array_values($data));

if ($result) {
    echo "Employee record inserted successfully!";
} else {
    echo "Error: " . pg_last_error($conn);
}

pg_close($conn);
?>
