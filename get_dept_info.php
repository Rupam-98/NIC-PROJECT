<?php
$host = "localhost";
$dbname = "PROJECT";
$user = "postgres";
$password = "1035";

$conn = pg_connect("host=$host dbname=$dbname user=$user password=$password");

$dept_code = $_GET['dept_code'] ?? '';

$query = "SELECT dept_name FROM dept_entry WHERE dept_code = $1";
$result = pg_query_params($conn, $query, [$dept_code]);

$data = pg_fetch_assoc($result);

header('Content-Type: application/json');
echo json_encode($data);
?>
