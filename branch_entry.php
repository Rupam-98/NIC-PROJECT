<?php
// PostgreSQL connection settings
$host = "localhost";
$port = "5432";
$dbname = "PROJECT";
$user = "postgres";
$password = "1035";

// Connect to PostgreSQL
$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

if (!$conn) {
    die("Connection failed: " . pg_last_error());
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data and sanitize
    $branchcode = $_POST['branchcode'];
    $deptcode = $_POST['deptcode'];
    $branchType = $_POST['branch_Type'];
    $branchName = $_POST['barnch_Name']; // note: this name matches your HTML field
    $beeocode = $_POST['beeocode'];
    $officerName = $_POST['officer_Name'];
    $officerDesignation = $_POST['officer_designation'];
    $officeEmail = $_POST['office_Email'];
    $officePhone = $_POST['office_Phone'];
    $officeaddress = $_POST['office_address'];

    // Prepare SQL INSERT query
    $query = "INSERT INTO branches (
        branchcode, deptcode, branchtype, branchname, beeocode, 
        officer_name, officer_designation, office_email, office_phone, office_address
    ) VALUES (
        $1, $2, $3, $4, $5, 
        $6, $7, $8, $9, $10
    )";

    $result = pg_query_params($conn, $query, [
        $branchcode, $deptcode, $branchType, $branchName, $beeocode,
        $officerName, $officerDesignation, $officeEmail, $officePhone, $officeaddress
    ]);

    if ($result) {
        echo "Branch entry added successfully!";
    } else {
        echo "Error in adding branch entry: " . pg_last_error($conn);
    }
}

// Close connection
pg_close($conn);
?>
