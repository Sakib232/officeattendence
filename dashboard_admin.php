<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .dashboard-container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 0 20px;
        }

        .admin-header {
            background: linear-gradient(135deg, #0078d7 0%, #00c6fb 100%);
            color: #fff;
            padding: 32px 0;
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.18);
            text-align: center;
            margin-bottom: 40px;
        }

        .admin-header h2 {
            margin: 0;
            font-size: 2.2em;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .admin-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
            padding: 20px 0;
        }

        .admin-card {
            background: rgba(255,255,255,0.9);
            border-radius: 15px;
            padding: 25px;
            text-align: center;
            transition: transform 0.3s, box-shadow 0.3s;
            box-shadow: 0 4px 16px rgba(0,0,0,0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
        }

        .admin-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 32px rgba(0,0,0,0.15);
        }

        .admin-card i {
            font-size: 2.5em;
            margin-bottom: 15px;
            color: #0078d7;
        }

        .admin-card a {
            color: #333;
            text-decoration: none;
            font-size: 1.1em;
            font-weight: 600;
            display: block;
        }

        .admin-card p {
            color: #666;
            margin-top: 10px;
            font-size: 0.9em;
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

       

        .logout-btn {
            background: rgba(164, 8, 8, 0.2);
            border: none;
            padding: 8px 15px;
            border-radius: 20px;
            color: #fff;
            cursor: pointer;
            transition: background 0.3s;
            padding-left: 20px;
            margin-left: 50px;
        }

        .logout-btn:hover {
            background: rgba(8, 0, 0, 0.3);
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <div class="profile-section">
            
            <span><?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>

        <div class="admin-header">
            <h2>Admin Dashboard</h2>
        </div>

        <div class="admin-grid">
            <div class="admin-card">
                <i class="fas fa-user-plus"></i>
                <a href="add_employee.php">Add Employee</a>
                <p>Add new employees to the system</p>
            </div>

            <div class="admin-card">
                <i class="fas fa-clock"></i>
                <a href="view_attendance.php">View Attendance</a>
                <p>Monitor employee attendance records</p>
            </div>

            <div class="admin-card">
                <i class="fas fa-chart-bar"></i>
                <a href="generate_report.php">Generate Reports</a>
                <p>Create and export detailed reports</p>
            </div>

            <div class="admin-card">
                <i class="fas fa-money-bill-wave"></i>
                <a href="salary_management.php">Salary Management</a>
                <p>Manage employee salaries</p>
            </div>

            <div class="admin-card">
                <i class="fas fa-users-cog"></i>
                <a href="assign_hr.php">HR Management</a>
                <p>Assign HR roles to employees</p>
            </div>

            
        </div>
    </div>
</body>
</html>