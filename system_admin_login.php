
<?php
$host = "localhost";
$port = "5432";
$dbname = "PROJECT";
$user = "postgres";
$password = "695847";

$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

if (!$conn) {-
    die("Connection failed: " . pg_last_error());
}

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password_input = $_POST['password'];

    $query = "SELECT id, password FROM systemlogin WHERE username = $1";
    $result = pg_query_params($conn, $query, array($username));

    if ($result && pg_num_rows($result) == 1) {
        $row = pg_fetch_assoc($result);
        $hashed_password = $row['password'];

        if (password_verify($password_input, $hashed_password)) {
            $_SESSION['user_id'] = $row['id'];
            echo "LOGIN SUCCESSFULL";
            exit();
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "User not found.";
    }
}

pg_close($conn);
?>
