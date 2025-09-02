<?php
$dept_code = $_GET['dept_code'];
$branch_code = $_GET['branch_code'] ?? '';

$conn = pg_connect("host=localhost dbname=PROJECT user=postgres password=1035");

if ($branch_code !== '') {
    $query = "SELECT username FROM admins WHERE dept_code = $1 AND branch_code = $2 ORDER BY username";
    $params = [$dept_code, $branch_code];
} else {
    $query = "SELECT username FROM admins WHERE dept_code = $1 AND (branch_code IS NULL OR branch_code = '') ORDER BY username";
    $params = [$dept_code];
}

$result = pg_query_params($conn, $query, $params);

$usernames = [];
while ($row = pg_fetch_assoc($result)) {
    $usernames[] = $row;
}
echo json_encode($usernames);
