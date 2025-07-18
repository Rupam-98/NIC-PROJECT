<?php
$conn = pg_connect("host=localhost dbname=PROJECT user=postgres password=1035");
$slno = $_GET['slno'];
$query = "SELECT * FROM employees WHERE slno = $1";
$result = pg_query_params($conn, $query, [$slno]);
$data = pg_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Update logic here
}
?>
<!-- Build a form with method="post", pre-fill inputs using $data, and use pg_query_params to update -->
