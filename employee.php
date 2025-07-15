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

<!DOCTYPE html>
<html>
<head>
    <title>Employee Entry Form</title>
    <link rel="stylesheet" href="employee_entry.css" />
</head>
<body>

    <h2>Employee Entry Form</h2>

    <form action="employee.php" method="post">
        <label for="slno">Sl. No</label>
        <input type="number" id="slno" name="slno" required>

        <label for="depcode">DEPCODE</label>
        <input type="text" id="depcode" name="depcode" required>

        <label for="department">DEPARTMENT</label>
        <input type="text" id="department" name="department" required>

        <label for="branch_code">BRANCH CODE</label>
        <input type="text" id="branch_code" name="branch_code" required>

        <label for="branch_address">BRANCH ADDRESS</label>
        <input type="text" id="branch_address" name="branch_address" required>

        <label for="name">NAME</label>
        <input type="text" id="name" name="name" required>

        <label for="desig">DESIGNATION</label>
        <input type="text" id="desig" name="desig" required>

        <label for="sex">SEX</label>
        <select id="sex" name="sex" required>
            <option value="">Select</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="Other">Other</option>
        </select>

        <label for="age">AGE</label>
        <input type="number" id="age" name="age" required>

        <label for="epic">VOTER ID (EPIC)</label>
        <input type="text" id="epic" name="epic" required>

        <label for="phone">PHONE</label>
        <input type="text" id="phone" name="phone" required>

        <label for="home_lac">HOME LAC</label>
        <input type="text" id="home_lac" name="home_lac" required>

        <label for="residential_lac">RESIDENTIAL LAC</label>
        <input type="text" id="residential_lac" name="residential_lac" required>

        <label for="branch_lac">BRANCH LAC</label>
        <input type="text" id="branch_lac" name="branch_lac" required>

        <label for="beeo_code">BEEO CODE</label>
        <input type="text" id="beeo_code" name="beeo_code" required>

        <label for="basic">BASIC</label>
        <input type="number" id="basic" name="basic" step="0.01" required>

        <label for="gazeted">GAZETED</label>
        <select id="gazeted" name="gazeted" required>
            <option value="">Select</option>
            <option value="1">Yes</option>
            <option value="0">No</option>
        </select>

        <label for="remarks">REMARKS</label>
        <input type="text" id="remarks" name="remarks" required>

        <label for="education">EDUCATION</label>
        <input type="text" id="education" name="education" required>

        <label for="dor">DOR (Date of Retirement)</label>
        <input type="date" id="dor" name="dor" required>

        <label for="ac_no">ACCOUNT NUMBER</label>
        <input type="text" id="ac_no" name="ac_no" required>

        <label for="ifsc_code">IFSC CODE</label>
        <input type="text" id="ifsc_code" name="ifsc_code" required>

        <label for="branch_name">BANK BRANCH NAME</label>
        <input type="text" id="branch_name" name="branch_name" required>

        <label for="bank_branch_address">BANK BRANCH ADDRESS</label>
        <input type="text" id="bank_branch_address" name="bank_branch_address" required>

        <input type="submit" value="Submit">
    </form>

</body>
</html>
