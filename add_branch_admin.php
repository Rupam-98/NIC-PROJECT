<?php
// Database connection details
$host = "localhost";
$port = "5432";
$dbname = "your_database_name";
$user = "your_username";
$password = "1035";

// Connect to PostgreSQL
$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

if (!$conn) {
    die("Connection failed: " . pg_last_error());
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get data and sanitize
    $branchCode = $_POST['branchCode'];
    $deptCode = $_POST['deptCode'];
    $branchName = $_POST['branchName'];
    $officerName = $_POST['officerName'];
    $designation = $_POST['designation'];
    $district = $_POST['district'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $username = $_POST['username'];
    $password_raw = $_POST['password'];

    // Hash the password before saving
    $hashed_password = password_hash($password_raw, PASSWORD_DEFAULT);

    // Prepare query
    $query = "INSERT INTO branch_admin (
        branch_code, dept_code, branch_name, officer_name, designation, 
        district, email, phone, username, password
    ) VALUES (
        $1, $2, $3, $4, $5, $6, $7, $8, $9, $10
    )";

    // Execute query
    $result = pg_query_params($conn, $query, [
        $branchCode, $deptCode, $branchName, $officerName, $designation,
        $district, $email, $phone, $username, $hashed_password
    ]);

    if ($result) {
        echo "Branch admin added successfully!";
    } else {
        echo "Error: " . pg_last_error($conn);
    }
}

// Close connection
pg_close($conn);
?>
