<?php
session_start();
require 'db.php';

if (!in_array($_SESSION['role'], ['admin', 'hr'])) { 
    header('Location: dashboard_employee.php'); 
    exit(); 
}

$success_message = $error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $emp_id = $_POST['employee_id'];
    $amount = $_POST['amount'];
    $month = $_POST['salary_month'];  // Form field name remains same
    $paid_date = $_POST['paid_date'];
    $remarks = $_POST['remarks'] ?? '';

    try {
        $sql = "INSERT INTO salary (employee_id, amount, month, paid_date, remarks) 
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param('idsss', $emp_id, $amount, $month, $paid_date, $remarks);
        
        if($stmt->execute()) {
            $success_message = "Salary record added successfully!";
        } else {
            $error_message = "Error adding salary record.";
        }
        $stmt->close();
    } catch (Exception $e) {
        $error_message = "Error: " . $e->getMessage();
    }
}

// Updated query to use correct column name 'month' instead of 'salary_month'
try {
    $salaries = $mysqli->query("SELECT s.*, e.name 
                               FROM salary s 
                               JOIN employees e ON s.employee_id = e.id 
                               ORDER BY s.month DESC, s.paid_date DESC");
    $employees = $mysqli->query("SELECT id, name 
                               FROM employees 
                               WHERE role != 'admin'");
} catch (Exception $e) {
    die("Database error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Salary Management</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .salary-form {
            background: rgba(255,255,255,0.9);
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 8px;
            border-radius: 8px;
            border: 1px solid #ddd;
        }
        .salary-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 16px rgba(0,0,0,0.1);
        }
        .salary-table th, .salary-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .salary-table th {
            background: linear-gradient(135deg, #0078d7 0%, #00c6fb 100%);
            color: white;
        }
        .salary-table tr:nth-child(even) {
            background-color: #f8f9fa;
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
        .back-link {
            display: inline-block;
            align-self: center;
            margin-top: 20px;
            padding: 10px 20px;
            background: #0078d7;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            transition: background 0.3s ease;
        }
    </style>
</head>
<body>
    <div class="banner">Salary Management</div>
    <div class="container">
        <div class="salary-form">
            <h2>Add Salary Record</h2>
            <form method="post">
                <div class="form-group">
                    <label>Employee</label>
                    <select name="employee_id" required>
                        <?php while ($row = $employees->fetch_assoc()): ?>
                            <option value="<?= htmlspecialchars($row['id']) ?>">
                                <?= htmlspecialchars($row['name']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Amount</label>
                    <input type="number" name="amount" step="0.01" required>
                </div>
                <div class="form-group">
                    <label>Month</label>
                    <input type="month" name="salary_month" required>
                </div>
                <div class="form-group">
                    <label>Paid Date</label>
                    <input type="date" name="paid_date" required>
                </div>
                <div class="form-group">
                    <label>Remarks</label>
                    <input type="text" name="remarks">
                </div>
                <button type="submit" class="action-btn">Add Salary Record</button>
            </form>
        </div>

        <h2>Salary Records</h2>
        <table class="salary-table">
            <tr>
                <th>Employee</th>
                <th>Month</th>
                <th>Amount</th>
                <th>Paid Date</th>
                <th>Remarks</th>
            </tr>
            <?php while ($row = $salaries->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['month']) ?></td>  <!-- Changed from salary_month to month -->
                    <td><?= htmlspecialchars($row['amount']) ?></td>
                    <td><?= htmlspecialchars($row['paid_date']) ?></td>
                    <td><?= htmlspecialchars($row['remarks']) ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
        <a href="dashboard_admin.php" class="back-link">Back to Dashboard</a>
    </div>
</body>
</html>