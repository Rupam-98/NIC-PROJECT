<?php
$dept_code = $_GET['dept_code'];
$conn = pg_connect("host=localhost dbname=PROJECT user=postgres password=1035");

$query = "SELECT branch_code, branch_name FROM branches WHERE dept_code = $1 ORDER BY branch_code";
$result = pg_query_params($conn, $query, [$dept_code]);

$branches = [];
while ($row = pg_fetch_assoc($result)) {
    $branches[] = $row;
}
echo json_encode($branches);
