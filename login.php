<?php
session_start();
require 'db.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $mysqli->prepare('SELECT id, name, password, role FROM employees WHERE email = ?');
    if (!$stmt) {
        $error = 'Database error: ' . $mysqli->error;
    } else {
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 1) {
            $stmt->bind_result($id, $name, $hashed_password, $role);
            $stmt->fetch();
            if (password_verify($password, $hashed_password)) {
                $_SESSION['user_id'] = $id;
                $_SESSION['user_name'] = $name;
                $_SESSION['role'] = $role;
                if ($role === 'admin') {
                    header('Location: dashboard_admin.php');
                } else {
                    header('Location: dashboard_employee.php');
                }
                exit();
            } else {
                $error = 'Invalid email or password.';
            }
        } else {
            $error = 'Invalid email or password.';
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Office Attendance</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background: linear-gradient(135deg, #0078d7 0%, #00c6fb 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Arial, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-container {
            background: rgba(255,255,255,0.85);
            box-shadow: 0 8px 32px rgba(0,0,0,0.12);
            border-radius: 18px;
            padding: 40px 44px 32px 44px;
            max-width: 380px;
            width: 100%;
            backdrop-filter: blur(8px);
            border: 1.5px solid rgba(200,200,200,0.18);
        }
        .login-container h2 {
            text-align: center;
            margin-bottom: 28px;
            font-size: 1.6em;
            color: #0078d7;
            font-weight: 700;
        }
        .login-container label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #222;
        }
        .login-container input {
            width: 100%;
            padding: 12px 16px;
            margin-bottom: 18px;
            border-radius: 8px;
            border: 1.5px solid #cfd8dc;
            background: rgba(245,248,255,0.95);
            font-size: 1em;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            transition: border-color 0.2s;
        }
        .login-container input:focus {
            border-color: #0078d7;
            outline: none;
        }
        .login-container button {
            width: 100%;
            background: linear-gradient(135deg, #0078d7 0%, #00c6fb 100%);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 14px 0;
            font-size: 1.08em;
            font-weight: 600;
            box-shadow: 0 4px 16px rgba(0,120,215,0.18);
            cursor: pointer;
            transition: box-shadow 0.2s, transform 0.2s;
            margin-top: 10px;
        }
        .login-container button:hover {
            box-shadow: 0 8px 32px rgba(0,120,215,0.22);
            transform: translateY(-2px) scale(1.04);
            background: linear-gradient(135deg, #005fa3 0%, #00c6fb 100%);
        }
        .login-container .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            padding: 12px;
            margin-bottom: 18px;
            border-radius: 8px;
            font-weight: 500;
            text-align: center;
        }
        .signup-btn {
            display: block;
            text-align: center;
            margin-top: 18px;
            color: #0078d7;
            text-decoration: none;
            font-weight: 500;
        }
        .signup-btn:hover {
            text-decoration: underline;
            color: #005fa3;
        }
        @media (max-width: 600px) {
            .login-container {
                padding: 18px 8px;
                max-width: 98vw;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <?php if ($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="post" action="">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>
            <button type="submit">Login</button>
            <a href="register.php" class="signup-btn">Sign Up</a>
        </form>
    </div>
</body>
</html>