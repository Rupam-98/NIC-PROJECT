<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $slno = $_POST['slno'];
    $conn = pg_connect("host=localhost dbname=PROJECT user=postgres password=1035");
    $query = "DELETE FROM employees WHERE slno = $1";
    $result = pg_query_params($conn, $query, [$slno]);

    if ($result) {
        header("Location: employee_list.php");
        exit;
    } else {
        echo "Error deleting record.";
    }
}
?>
