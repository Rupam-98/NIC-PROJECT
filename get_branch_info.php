<?php
$host = "localhost";
$dbname = "PROJECT";
$user = "postgres";
$password = "1035";

$conn = pg_connect("host=$host dbname=$dbname user=$user password=$password");

if (!$conn) {
    die("Connection failed: " . pg_last_error());
}

$branch_code = $_GET['branch_code'];

$query = "SELECT address  FROM branches WHERE branch_code = $1::int";
$result = pg_query_params($conn, $query, array($branch_code));

$data = array();
if ($row = pg_fetch_assoc($result)) {
    $data = $row;
}

echo json_encode($data);

pg_close($conn);
?>
