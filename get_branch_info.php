<?php
if (isset($_GET['branch_code'])) {
    $branch_code = $_GET['branch_code'];

    $conn = pg_connect("host=localhost dbname=PROJECT user=postgres password=1035");

    if (!$conn) {
        echo json_encode(['error' => 'Database connection failed']);
        exit;
    }

    $query = "SELECT address, branch_lac, beeo_code FROM branches WHERE branchcode = $1";
    $result = pg_query_params($conn, $query, [$branch_code]);

    if ($result && pg_num_rows($result) > 0) {
        $row = pg_fetch_assoc($result);
        echo json_encode($row);
    } else {
        echo json_encode(['error' => 'Branch not found']);
    }

    pg_close($conn);
}
?>
