<?php

session_start();
require 'db.php';
if ($_SESSION['role'] !== 'admin') { header('Location: dashboard_employee.php'); exit(); }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $emp_id = $_POST['employee_id'];
    $sql = "UPDATE employees SET role='hr' WHERE id=?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('i', $emp_id);
    $stmt->execute();
    $stmt->close();
    header('Location: assign_hr.php?success=1');
    exit();
}

$employees = $mysqli->query("SELECT id, name, role FROM employees WHERE role='employee'");
?>
<!DOCTYPE html>
<html>
<head><title>Assign HR Role</title></head>
<body>
<h2>Assign HR Role</h2>
<form method="post">
    <select name="employee_id">
        <?php while ($row = $employees->fetch_assoc()): ?>
            <option value="<?= $row['id'] ?>"><?= htmlspecialchars($row['name']) ?></option>
        <?php endwhile; ?>
    </select>
    <button type="submit">Make HR</button>
</form>
<?php
if ($_SESSION['role'] === 'admin') {
    echo '<a href="assign_hr.php">Assign HR Role</a>';
    echo '<a href="salary_management.php">Manage Salaries</a>';
}
if ($_SESSION['role'] === 'hr') {
    echo '<a href="salary_management.php">Manage Salaries</a>';
}
echo '<a href="view_attendance.php">View Attendance</a>';
?>
</body>
</html>