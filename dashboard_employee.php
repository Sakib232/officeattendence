<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'employee') {
    header('Location: login.php');
    exit();
}
$user_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Employee';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Employee Dashboard - Office Attendance</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: #f7f7f7;
            font-family: 'Segoe UI', Arial, sans-serif;
        }
        .banner {
            background: linear-gradient(135deg, #0078d7 0%, #00c6fb 100%);
            color: #fff;
            padding: 38px 0 24px 0;
            text-align: center;
            font-size: 2.5em;
            font-weight: bold;
            letter-spacing: 2px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.18);
            border-radius: 0 0 32px 32px;
            margin-bottom: 40px;
        }
        .profile-section {
            position: absolute;
            top: 20px;
            right: 20px;
            display: flex;
            align-items: center;
            gap: 15px;
            background: rgba(255,255,255,0.1);
            padding: 10px 20px;
            border-radius: 50px;
            backdrop-filter: blur(5px);
        }
       
        .profile-section span {
            color: #fff;
            font-weight: 600;
            font-size: 1.1em;
            text-shadow: 0 1px 2px rgba(230, 22, 22, 0.1);
        }
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
            padding: 20px 0;
            max-width: 900px;
            margin: 0 auto;
        }
        .dashboard-card {
            background: rgba(255,255,255,0.9);
            border-radius: 15px;
            padding: 32px 24px;
            text-align: center;
            transition: transform 0.3s, box-shadow 0.3s;
            box-shadow: 0 4px 16px rgba(0,0,0,0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
        }
        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 32px rgba(0,0,0,0.15);
        }
        .dashboard-card i {
            font-size: 2.2em;
            margin-bottom: 15px;
            color: #0078d7;
        }
        .dashboard-card a {
            color: #0078d7;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.15em;
            display: block;
            margin-top: 10px;
            transition: color 0.2s;
        }
        .dashboard-card a:hover {
            color: #005fa3;
            text-decoration: underline;
        }
        .dashboard-card p {
            color: #666;
            margin-top: 10px;
            font-size: 0.98em;
        }
        @media (max-width: 700px) {
            .dashboard-grid {
                grid-template-columns: 1fr;
                gap: 16px;
            }
            .banner {
                font-size: 1.4em;
                padding: 18px 0 12px 0;
            }
        }
    </style>
</head>
<body>
    <div class="profile-section">
        
        <span><?php echo htmlspecialchars($user_name); ?></span>
        <a href="logout.php" class="logout-btn" style="color:#fff; background:rgba(255,255,255,0.2); border-radius:20px; padding:8px 15px; margin-left:10px;">Logout</a>
    </div>
    <div class="banner">
        Office Attendance System
    </div>
    <div class="dashboard-grid">
        <div class="dashboard-card">
            <i class="fas fa-calendar-check"></i>
            <a href="mark_attendance.php">Mark Attendance (IN/OUT)</a>
            <p>Record your attendance for today</p>
        </div>
        <div class="dashboard-card">
            <i class="fas fa-list-alt"></i>
            <a href="view_attendance.php">View My Attendance</a>
            <p>See your attendance history</p>
        </div>
        <div class="dashboard-card">
            <i class="fas fa-download"></i>
            <a href="attendance_download_center.php">Download Attendance Sheet</a>
            <p>Export your attendance records</p>
        </div>
        
    </div>
</body>
</html>