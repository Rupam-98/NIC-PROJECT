<?php
$host = "localhost";
$dbname = "PROJECT";
$user = "postgres";
$password = "1035";

$conn = pg_connect("host=$host dbname=$dbname user=$user password=$password");

if (!$conn) {
    die("Connection failed: " . pg_last_error());
}

$dept_code = $_GET['dept_code'];

$query = "SELECT dept_name, address, head FROM dept_entry WHERE dept_code = $1";
$result = pg_query_params($conn, $query, array($dept_code));

if ($result && pg_num_rows($result) > 0) {
    $row = pg_fetch_assoc($result);
    echo json_encode($row);
} else {
    echo json_encode(['dept_name' => '', 'address' => '', 'head' => '']);
}

pg_close($conn);
?>
