<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'employee') {
    header('Location: login.php');
    exit();
}
require 'db.php';

$employee_id = $_SESSION['user_id'];
$date = date('Y-m-d');
$message = '';
$error = ''; // Added for error messages

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    $stmt = $mysqli->prepare('SELECT id, time_in, time_out FROM attendance WHERE employee_id = ? AND date = ?');
    $stmt->bind_param('is', $employee_id, $date);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        // Record exists
        if ($action === 'in' && !$row['time_in']) {
            $time_in = date('H:i:s');
            $update = $mysqli->prepare('UPDATE attendance SET time_in = ? WHERE id = ?');
            $update->bind_param('si', $time_in, $row['id']);
            $update->execute();
            $message = 'Checked IN at ' . $time_in;
        } elseif ($action === 'out' && !$row['time_out']) {
            $time_out = date('H:i:s');
            $update = $mysqli->prepare('UPDATE attendance SET time_out = ? WHERE id = ?');
            $update->bind_param('si', $time_out, $row['id']);
            $update->execute();
            $message = 'Checked OUT at ' . $time_out;
        } else {
            $message = 'Attendance already marked for this action.';
        }
    } else {
        // No record yet
        if ($action === 'in') {
            $time_in = date('H:i:s');
            $insert = $mysqli->prepare('INSERT INTO attendance (employee_id, date, time_in) VALUES (?, ?, ?)');
            $insert->bind_param('iss', $employee_id, $date, $time_in);
            $insert->execute();
            $message = 'Checked IN at ' . $time_in;
        } else {
            $message = 'You must check IN before checking OUT.';
        }
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mark Attendance - Office Attendance</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background: #f7f7f7;
            font-family: 'Segoe UI', Arial, sans-serif;
        }
        .banner {
            background: #0078d7;
            color: #fff;
            padding: 30px 0 20px 0;
            text-align: center;
            font-size: 2.2em;
            font-weight: bold;
            letter-spacing: 2px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        .attendance-card {
            background: #fff;
            max-width: 450px;
            margin: 40px auto;
            border-radius: 12px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.08);
            padding: 32px 36px 28px 36px;
            text-align: center;
        }
        .attendance-card h2 {
            margin-bottom: 24px;
            font-size: 1.6em;
            color: #222;
        }
        .attendance-btn {
            background: #0078d7;
            color: #fff;
            border: none;
            border-radius: 6px;
            padding: 12px 36px;
            font-size: 1.1em;
            margin: 0 10px 18px 10px;
            cursor: pointer;
            transition: background 0.2s;
        }
        .attendance-btn:hover {
            background: #005fa3;
        }
        .back-link {
            display: block;
            margin-top: 18px;
            color: #0078d7;
            text-decoration: none;
            font-weight: 500;
        }
        .back-link:hover {
            text-decoration: underline;
            color: #005fa3;
        }
        .message {
            margin-bottom: 18px;
            color: #008000;
            font-weight: 500;
        }
        .error {
            margin-bottom: 18px;
            color: #d8000c;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="banner">
        Office Attendance System
    </div>
    <div class="attendance-card">
        <h2>Mark Attendance</h2>
        <?php if (!empty($message)): ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>
        <?php if (!empty($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="post">
            <button type="submit" name="action" value="in" class="attendance-btn">Mark IN</button>
            <button type="submit" name="action" value="out" class="attendance-btn">Mark OUT</button>
        </form>
        <a href="dashboard_employee.php" class="back-link">Back to Dashboard</a>
    </div>
</body>
</html> 