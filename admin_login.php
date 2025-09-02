<?php
session_start();
$host = "localhost";
$dbname = "PROJECT";
$user = "postgres";
$password = "1035";
$conn = pg_connect("host=$host dbname=$dbname user=$user password=$password");

if (!$conn) {
    die("Connection failed: " . pg_last_error());
}

$departments = pg_query($conn, "SELECT dept_code, dept_name FROM admins ORDER BY dept_name");


// Verify OTP and Login
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $enteredOtp = $_POST['otp'];
    $enteredPassword = $_POST['password'];

    if ($_SESSION['otp_username'] === $username && $_SESSION['otp'] == $enteredOtp) {
        $query = "SELECT * FROM admins WHERE username = $1";
        $result = pg_query_params($conn, $query, [$username]);
        $admin = pg_fetch_assoc($result);

        if ($admin && password_verify($enteredPassword, $admin['password'])) {
            $_SESSION['id'] = $admin['id'];
            $_SESSION['username'] = $admin['username'];
            $_SESSION['role'] = $admin['role'];
            $_SESSION['dept_code'] = $admin['dept_code'];
            $_SESSION['branch_code'] = $admin['branch_code'];

            if ($admin['role'] === 'super_admin') {
                header("Location: system_dashboard.php");
            } elseif ($admin['role'] === 'department_admin') {
                header("Location: dept_dashboard.php");
            } elseif ($admin['role'] === 'branch_admin') {
                header("Location: branch_dashboard.php");
            }
            exit();
        } else {
            echo "<script>alert('Incorrect password');</script>";
        }
    } else {
        echo "<script>alert('Invalid OTP');</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <style>
        body {
            background: linear-gradient(to right, #6dd5ed, #2193b0);
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            background: #ffffff;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 500px;
            transition: all 0.3s ease;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }

        label {
            font-weight: 600;
            margin-top: 15px;
            display: block;
            color: #444;
        }

        select,
        input[type="text"],
        input[type="submit"],
        input[type="button"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-top: 8px;
            border-radius: 10px;
            border: 1px solid #ccc;
            font-size: 16px;
            transition: border 0.2s ease;
        }

        select:focus,
        input[type="text"]:focus {
            border-color: #2193b0;
            outline: none;
            
        }

        input[type="submit"],
        input[type="button"] {
            background: #2193b0;
            color: white;
            font-weight: bold;
            margin-top: 20px;
            border: none;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        input[type="submit"]:hover,
        input[type="button"]:hover {
            background: #186a8d;
        }

        .readonly {
            background: #e9ecef;
        }
    </style>
</head>

<body>

    <div class="login-container">
        <h2>Admin Login</h2>
        <form method="POST" action="">
            <label>Department</label>
            <select id="dept" name="dept_code" required>
                <option value="">--Select Department--</option>
                <?php
                $res = pg_query($conn, "SELECT DISTINCT dept_code, dept_name FROM admins ORDER BY dept_name");
                while ($row = pg_fetch_assoc($res)) {
                    echo "<option value='{$row['dept_code']}'>{$row['dept_name']} ({$row['dept_code']})</option>";
                }
                ?>
            </select>

            <label>Branch</label>
            <select id="branch" name="branch_code">
                <option value="">--Select Branch--</option>
            </select>

            <label>Username</label>
            <select id="username" name="username" required>
                <option value="">--Select Username--</option>
            </select>

            <label>Password</label>
            <input type="password" name="password" placeholder="Enter Password" required>


            <label>Enter OTP</label>
            <input type="text" name="otp" placeholder="Enter OTP" maxlength="6">

            <input type="button" id="generateOtpBtn" value="Generate OTP">
            <input type="submit" name="login" value="Login">
        </form>
    </div>

    <script>
        const deptSelect = document.getElementById('dept');
        const branchSelect = document.getElementById('branch');
        const usernameSelect = document.getElementById('username');

        deptSelect.addEventListener('change', () => {
            const deptCode = deptSelect.value;
            branchSelect.innerHTML = '<option value="">--Select Branch--</option>';
            usernameSelect.innerHTML = '<option value="">--Select Username--</option>';

            if (deptCode) {
                fetch('fetch_options.php?dept_code=' + deptCode)
                    .then(res => res.json())
                    .then(data => {
                        data.branches.forEach(branch => {
                            const opt = document.createElement('option');
                            opt.value = branch.branch_code;
                            opt.textContent = branch.branch_name + ' (' + branch.branch_code + ')';
                            branchSelect.appendChild(opt);
                        });

                        let users = [];
                        if (data.super_admin && data.super_admin.username) {
                            users.push({
                                username: data.super_admin.username
                            });
                        }
                        if (Array.isArray(data.dept_admins)) {
                            users = users.concat(data.dept_admins);
                        }
                        updateUsernames(users);
                    });
            }
        });

        branchSelect.addEventListener('change', () => {
            const deptCode = deptSelect.value;
            const branchCode = branchSelect.value;

            if (branchCode) {
                fetch('fetch_options.php?dept_code=' + deptCode + '&branch_code=' + branchCode)
                    .then(res => res.json())
                    .then(data => updateUsernames(data.branch_admins));
            }
        });

        function updateUsernames(users) {
            usernameSelect.innerHTML = '<option value="">--Select Username--</option>';

            users.forEach(user => {
                const opt = document.createElement('option');
                opt.value = user.username;
                opt.textContent = user.username;
                usernameSelect.appendChild(opt);
            });

            if (users.length === 1) {
                usernameSelect.value = users[0].username;
                usernameSelect.setAttribute('readonly', true);
                usernameSelect.classList.add('readonly');
            } else {
                usernameSelect.removeAttribute('readonly');
                usernameSelect.classList.remove('readonly');
            }
        }

        document.getElementById('generateOtpBtn').addEventListener('click', function() {
            const username = document.getElementById('username').value;

            if (!username) {
                alert("Please select a username first.");
                return;
            }

            fetch('generate_otp.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: 'username=' + encodeURIComponent(username)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.otp) {
                        alert(data.message);
                    } else {
                        alert("Failed to generate OTP.");
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert("Error generating OTP.");
                });
        });
    </script>

</body>

</html>