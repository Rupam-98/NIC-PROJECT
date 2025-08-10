<?php
$host = "localhost";
$dbname = "PROJECT";
$user = "postgres";
$password = "1035";
$conn = pg_connect("host=$host dbname=$dbname user=$user password=$password");

$dept_code = $_GET['dept_code'] ?? null;
$branch_code = $_GET['branch_code'] ?? null;

$branches = [];
$dept_admins = [];
$branch_admins = [];
$super_admin = null;

if ($dept_code) {
    // Get branches for department
    $res = pg_query_params($conn, "SELECT DISTINCT branch_code, branch_name FROM admins WHERE dept_code = $1 AND branch_code IS NOT NULL ORDER BY branch_name", [$dept_code]);
    while ($row = pg_fetch_assoc($res)) {
        $branches[] = $row;
    }

    // Get department admins
    $res2 = pg_query_params($conn, "SELECT username FROM admins WHERE dept_code = $1 AND role = 'department_admin'", [$dept_code]);
    while ($row = pg_fetch_assoc($res2)) {
        $dept_admins[] = $row;
    }

    // Get branch admins if branch selected
    if ($branch_code) {
        $res3 = pg_query_params($conn, "SELECT username FROM admins WHERE dept_code = $1 AND branch_code = $2 AND role = 'branch_admin'", [$dept_code, $branch_code]);
        while ($row = pg_fetch_assoc($res3)) {
            $branch_admins[] = $row;
        }
    }
}

// Always fetch super admin (for global login access)
$res4 = pg_query($conn, "SELECT username FROM admins WHERE role = 'super_admin' LIMIT 1");
$super_admin = pg_fetch_assoc($res4);

echo json_encode([
    'branches' => $branches,
    'dept_admins' => $dept_admins,
    'branch_admins' => $branch_admins,
    'super_admin' => $super_admin
]);
