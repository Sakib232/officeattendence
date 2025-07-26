<?php
require 'db.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Secure password
    $role = 'employee'; // Default role

    // Check if email already exists
    $check = $mysqli->prepare("SELECT id FROM employees WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $message = "Error: This email is already registered.";
    } else {
        $stmt = $mysqli->prepare("INSERT INTO employees (name, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $password, $role);

        if ($stmt->execute()) {
            $message = "Registration successful! <a href='login.php'>Login here</a>.";
        } else {
            $message = "Error: " . $stmt->error . " " . $mysqli->error;
        }
        $stmt->close();
    }
    $check->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register - Office Attendance</title>
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
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
        .login-container input[type="submit"] {
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
        .login-container input[type="submit"]:hover {
            box-shadow: 0 8px 32px rgba(0,120,215,0.22);
            transform: translateY(-2px) scale(1.04);
            background: linear-gradient(135deg, #005fa3 0%, #00c6fb 100%);
        }
        .login-container .success {
            background-color: #e3f0ff;
            color: #0078d7;
            border: 1px solid #b3d8ff;
            padding: 12px;
            margin-bottom: 18px;
            border-radius: 8px;
            font-weight: 500;
            text-align: center;
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
        .login-container a {
            color: #0078d7;
            text-decoration: none;
            font-weight: 500;
        }
        .login-container a:hover {
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
        <h2>Register</h2>
        <?php if ($message): ?>
            <div class="<?php echo strpos($message, 'successful') !== false ? 'success' : 'error'; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        <form method="post">
            <label>Name:</label>
            <input type="text" name="name" required>
            <label>Email:</label>
            <input type="email" name="email" required>
            <label>Password:</label>
            <input type="password" name="password" required>
            <input type="submit" value="Register">
        </form>
        <p>Already have an account? <a href="login.php">Login here</a></p>
    </div>
</body>
</html>
