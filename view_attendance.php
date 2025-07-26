<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
require 'db.php';

$role = $_SESSION['role'];
$employee_id = $_SESSION['user_id'];

$attendance = []; // Always initialize

if ($role === 'admin') {
    $sql = 'SELECT a.id, e.name, a.date, a.time_in, a.time_out FROM attendance a JOIN employees e ON a.employee_id = e.id ORDER BY a.date DESC, e.name';
    $result = $mysqli->query($sql);
    while ($row = $result->fetch_assoc()) {
        $attendance[] = $row;
    }
} else {
    $sql = 'SELECT id, date, time_in, time_out FROM attendance WHERE employee_id = ? ORDER BY date DESC';
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('i', $employee_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $attendance[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Attendance Records - Office Attendance</title>
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
            max-width: 550px;
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
        .attendance-table {
            width: 100%;
            border-collapse: collapse;
            margin: 0 auto 18px auto;
        }
        .attendance-table th, .attendance-table td {
            border: 1px solid #ddd;
            padding: 10px 12px;
            text-align: center;
        }
        .attendance-table th {
            background: #f0f4f8;
            color: #222;
            font-weight: 600;
        }
        .attendance-table tr:nth-child(even) {
            background: #f9f9f9;
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
    </style>
</head>
<body>
    <div class="banner">
        Office Attendance System
    </div>
    <div class="attendance-card">
        <h2>Attendance Records</h2>
        <table class="attendance-table">
            <tr>
                <?php if ($role === 'admin'): ?>
                    <th>Employee Name</th>
                <?php endif; ?>
                <th>Date</th>
                <th>Time IN</th>
                <th>Time OUT</th>
            </tr>
            <?php if (!empty($attendance)): ?>
                <?php foreach ($attendance as $row): ?>
                    <tr>
                        <?php if ($role === 'admin'): ?>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <?php endif; ?>
                        <td><?php echo htmlspecialchars($row['date']); ?></td>
                        <td><?php echo htmlspecialchars($row['time_in']); ?></td>
                        <td><?php echo htmlspecialchars($row['time_out']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="<?php echo ($role === 'admin' ? '4' : '3'); ?>">No attendance records found.</td>
                </tr>
            <?php endif; ?>
        </table>
        <a href="download_attendance.php" class="back-link" style="margin-bottom:18px;display:inline-block;">Download Attendance Sheet (CSV)</a>
                
    </div>
</body>
</html>