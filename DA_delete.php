<?php


$host = "localhost";
$port = "5432";
$dbname = "PROJECT";
$user = "postgres";
$password = "695847";

$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");
if (!$conn) {
  die("Connection failed: " . pg_last_error());
}

$id = $_GET['id'] ?? null;
if (!$id) {
  die("No student ID specified.");
}

$query = "DELETE FROM dept_admins WHERE id = $1";
$result = pg_query_params($conn, $query, [$id]);

if ($result) {
  header("Location: dept_admin_list.php");
  exit();
} else {
  echo "Delete failed: " . pg_last_error($conn);
}

pg_close($conn);
?>
