<?php
// Database connection details
$host = "localhost";
$port = "5432";
$dbname = "PROJECT";
$user = "postgres";
$password = "695847";

// Connect to PostgreSQL
$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

if (!$conn) {
    die("Connection failed: " . pg_last_error());
}

// Check if form submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $deptCode = $_POST['deptCode'];
    $deptName = $_POST['deptName'];
    $officerName = $_POST['officerName'];
    $designation = $_POST['designation'];
    $district = $_POST['district'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // You can hash password if needed
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert into database
    $query = "INSERT INTO dept_admins (dept_code, dept_name, officer_name, designation,  district, email, phone, username, password) 
              VALUES ($1, $2, $3, $4, $5, $6, $7, $8, $9 )";

    $result = pg_query_params($conn, $query, array($deptCode, $deptName, $officerName, $designation, $district, $email, $phone, $username, $hashed_password));

    if ($result) {
        echo "<script>alert('Department admin added successfully!'); window.location.href = 'add_dept_admin.html';</script>";
    } else {
        echo "Error: " . pg_last_error($conn);
    }
}
pg_close($conn);
?>
