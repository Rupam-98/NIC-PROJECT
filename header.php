<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <style>
        /* Reset some defaults */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            color: #333;
        }

        header {
            width: 80%;
            margin-left: 17%;
            position: fixed;
            top: 0;
            background-color: #2c3e50;
            padding: 15px 30px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .logo {
            font-size: 22px;
            font-weight: bold;
        }

        .nav-links {
            display: flex;
            gap: 20px;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            font-size: 16px;
            transition: color 0.3s ease;
        }

        .nav-links a:hover {
            color: #f39c12;
        }

        .logout {
            background-color: #e74c3c;
            padding: 5px 12px;
            border-radius: 5px;
            text-decoration: none;
            color: white;
            transition: background-color 0.3s ease;
        }

        .logout:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<body>

<header>
    <div class="logo">Admin Portal</div>
    <div class="nav-links">
        <a href="dashboard.php">Dashboard</a>
        <a href="profile.php">Profile</a>
        <a class="logout" href="logout.php">Logout</a>
    </div>
</header>
