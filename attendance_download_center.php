<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'employee') {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Download Attendance Sheet - Office Attendance</title>
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
        .download-card {
            background: #fff;
            max-width: 420px;
            margin: 48px auto;
            border-radius: 16px;
            box-shadow: 0 6px 32px rgba(0,0,0,0.10);
            padding: 38px 40px 32px 40px;
            text-align: center;
        }
        .download-icon {
            font-size: 3.2em;
            color: #0078d7;
            margin-bottom: 12px;
            display: inline-block;
        }
        .download-card h2 {
            margin-bottom: 10px;
            font-size: 1.5em;
            color: #222;
        }
        .download-card p {
            color: #555;
            margin-bottom: 28px;
        }
        .download-btn {
            background: linear-gradient(90deg, #0078d7 60%, #005fa3 100%);
            color: #fff;
            border: none;
            border-radius: 6px;
            padding: 14px 38px;
            font-size: 1.1em;
            margin: 18px 0 0 0;
            cursor: pointer;
            transition: background 0.2s, box-shadow 0.2s;
            text-decoration: none;
            display: inline-block;
            font-weight: 600;
            box-shadow: 0 2px 8px rgba(0,120,215,0.08);
        }
        .download-btn:hover {
            background: linear-gradient(90deg, #005fa3 60%, #0078d7 100%);
            box-shadow: 0 4px 16px rgba(0,120,215,0.15);
        }
        .back-link {
            display: block;
            margin-top: 22px;
            color: #0078d7;
            text-decoration: none;
            font-weight: 500;
            font-size: 1em;
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
    <div class="download-card">
        <span class="download-icon">&#128190;</span>
        <h2>Download Your Attendance Sheet</h2>
        <p>Click the button below to download your attendance records as a CSV file.<br>
        You can open it in Excel, Google Sheets, or any spreadsheet program.</p>
        <a href="download_attendance.php" class="download-btn">Download Attendance Sheet (CSV)</a>
        <a href="view_attendance.php" class="back-link">Back to Attendance Records</a>
    </div>
</body>
</html>
