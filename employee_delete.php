<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $slno = $_POST['slno'];
    $conn = pg_connect("host=localhost dbname=PROJECT user=postgres password=1035");
    $query = "DELETE FROM employees WHERE slno = $1";
    $result = pg_query_params($conn, $query, [$slno]);

    if ($result) {
        echo "<script>alert('Record deleted successfully'); window.location.href='cp_employee_list.php';</script>";
        exit;
    } else {
        echo "Error deleting record.";
    }
}
?>
