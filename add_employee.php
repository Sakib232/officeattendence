<?php
session_start();
require 'db.php';

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    // Check if email exists
    $check = $mysqli->prepare("SELECT id FROM employees WHERE email = ?");
    $check->bind_param('s', $email);
    $check->execute();
    $check->store_result();
    if ($check->num_rows > 0) {
        $message = 'Error: Email already exists.';
    } else {
        // Proceed to insert
        $name = $_POST['name'];
        $role = $_POST['role'];
        $password = $_POST['password'];
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $mysqli->prepare('INSERT INTO employees (name, email, password, role) VALUES (?, ?, ?, ?)');
        $stmt->bind_param('ssss', $name, $email, $hashed_password, $role);
        if ($stmt->execute()) {
            $message = 'Employee added successfully!';
        } else {
            $message = 'Error: ' . $stmt->error;
        }
        $stmt->close();
    }
    $check->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Employee</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background: #f5f7fa;
            font-family: 'Segoe UI', Arial, sans-serif;
        }
        .banner {
            background: linear-gradient(135deg, #0078d7 0%, #00c6fb 100%);
            color: #fff;
            padding: 32px 0 24px 0;
            text-align: center;
            font-size: 2.2em;
            font-weight: bold;
            letter-spacing: 2px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.18);
            border-radius: 0 0 32px 32px;
            margin-bottom: 40px;
        }
        .add-employee-container {
            background: rgba(255,255,255,0.85);
            box-shadow: 0 8px 32px rgba(0,0,0,0.12);
            border-radius: 18px;
            padding: 40px 44px 32px 44px;
            max-width: 420px;
            margin: 40px auto;
            backdrop-filter: blur(8px);
            border: 1.5px solid rgba(200,200,200,0.18);
        }
        .add-employee-container h2 {
            text-align: center;
            margin-bottom: 28px;
            font-size: 1.6em;
            color: #0078d7;
            font-weight: 700;
        }
        .add-employee-container label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #222;
        }
        .add-employee-container input,
        .add-employee-container select {
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
        .add-employee-container input:focus,
        .add-employee-container select:focus {
            border-color: #0078d7;
            outline: none;
        }
        .add-employee-container button {
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
        .add-employee-container button:hover {
            box-shadow: 0 8px 32px rgba(0,120,215,0.22);
            transform: translateY(-2px) scale(1.04);
            background: linear-gradient(135deg, #005fa3 0%, #00c6fb 100%);
        }
        .add-employee-container .message {
            padding: 12px;
            margin-bottom: 18px;
            border-radius: 8px;
            font-weight: 500;
            text-align: center;
        }
        .add-employee-container .message {
            background-color: #e3f0ff;
            color: #0078d7;
            border: 1px solid #b3d8ff;
        }
        .add-employee-container .message.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .add-employee-container a {
            display: block;
            text-align: center;
            margin-top: 18px;
            color: #0078d7;
            text-decoration: none;
            font-weight: 500;
        }
        .add-employee-container a:hover {
            text-decoration: underline;
            color: #005fa3;
        }
        @media (max-width: 600px) {
            .add-employee-container {
                padding: 18px 8px;
                max-width: 98vw;
            }
            .banner {
                font-size: 1.2em;
                padding: 18px 0 12px 0;
            }
        }
    </style>
</head>
<body>
    <div class="banner">Add Employee</div>
    <div class="add-employee-container">
        <h2>Add Employee</h2>
        <?php if ($message): ?>
            <div class="message<?php echo strpos($message, 'Error') !== false ? ' error' : ''; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        <form method="post" action="">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" required>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>
            <label for="role">Role:</label>
            <select name="role" id="role">
                <option value="employee">Employee</option>
                <option value="admin">Admin</option>
            </select>
            <button type="submit">Add Employee</button>
        </form>
        <a href="dashboard_admin.php">Back to Dashboard</a>
    </div>
</body>
</html>