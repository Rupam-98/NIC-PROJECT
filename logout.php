<?php
session_start();

/*
  If you want, you can manually unset specific keys, for example:
  unset($_SESSION['system_admin']);
  unset($_SESSION['branch_admin']);
  unset($_SESSION['dept_admin']);
  unset($_SESSION['employee_id']);
  unset($_SESSION['user_id']);
  // etc.
*/

// Or simply clear everything:
$_SESSION = array();

// Destroy the whole session
session_destroy();

// Remove session cookie (good practice)
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Redirect to your main login or landing page
header("Location: index.html");
exit();
?>
