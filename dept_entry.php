<?php
// Database connection details — change these to match your database
$host = "localhost";
$port = "5432";
$dbname = "project";    // <-- Change this
$user = "postgre";      // <-- Change this
$password = "1035"; // <-- Change this

// Connect to PostgreSQL
$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

if (!$conn) {
    die("Connection failed: " . pg_last_error());
}

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize input
    $deptType = htmlspecialchars($_POST['deptType']);
    $deptCode = htmlspecialchars($_POST['deptcode']);
    $deptName = htmlspecialchars($_POST['deptName']);
    $officerName = htmlspecialchars($_POST['officerName']);
    $officerDesignation = htmlspecialchars($_POST['officerDesignation']);
    $officeEmail = htmlspecialchars($_POST['officeEmail']);
    $officePhone = htmlspecialchars($_POST['officePhone']);
    $officeAddress = htmlspecialchars($_POST['officeaddress']);

    // Insert into database using parameterized query to avoid SQL injection
    $query = "INSERT INTO departments (dept_type, dept_code, dept_name, officer_name, officer_designation, office_email, office_phone, office_address) 
              VALUES ($1, $2, $3, $4, $5, $6, $7, $8)";
              
    $result = pg_query_params($conn, $query, array(
        $deptType,
        $deptCode,
        $deptName,
        $officerName,
        $officerDesignation,
        $officeEmail,
        $officePhone,
        $officeAddress
    ));

    if ($result) {
        echo "<h3>Department entry added successfully!</h3>";
        echo "<a href='dept_entry.html'>Go back to form</a>";
    } else {
        echo "Error: " . pg_last_error($conn);
    }

    // Close connection
    pg_close($conn);
}
?>
