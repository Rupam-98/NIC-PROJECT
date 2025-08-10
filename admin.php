<?php

// // Database connection
// $host = "localhost";
// $dbname = "PROJECT";
// $user = "postgres";
// $password = "1035";
// $conn = pg_connect("host=$host dbname=$dbname user=$user password=$password");

// if (!$conn) {
//     die("Connection failed: " . pg_last_error());
// }

// Initialize name variables
$dept_name = "";
$branch_name = "";

// Get department name for department_admin
if (isset($_SESSION['dept_code']) && $_SESSION['role'] === 'department_admin') {
    $dept_code = $_SESSION['dept_code'];
    $query = "SELECT dept_name FROM admins WHERE dept_code = '$dept_code'";
    $result = pg_query($conn, $query);
    if ($result && pg_num_rows($result) > 0) {
        $row = pg_fetch_assoc($result);
        $dept_name = $row['dept_name'];
    }
}

// Get branch name for branch_admin
if (isset($_SESSION['branch_code']) && $_SESSION['role'] === 'branch_admin') {
    $branch_code = $_SESSION['branch_code'];
    $query = "SELECT branch_name FROM admins WHERE branch_code = '$branch_code'";
    $result = pg_query($conn, $query);
    if ($result && pg_num_rows($result) > 0) {
        $row = pg_fetch_assoc($result);
        $branch_name = $row['branch_name'];
    }
}
?>
