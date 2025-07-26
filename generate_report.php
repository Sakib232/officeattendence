<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename=attendance_report.csv');

$output = fopen('php://output', 'w');
fputcsv($output, ['Employee Name', 'Date', 'Time IN', 'Time OUT']);

$sql = 'SELECT e.name, a.date, a.time_in, a.time_out FROM attendance a JOIN employees e ON a.employee_id = e.id ORDER BY a.date DESC, e.name';
$result = $mysqli->query($sql);

while ($row = $result->fetch_assoc()) {
    fputcsv($output, [$row['name'], $row['date'], $row['time_in'], $row['time_out']]);
}

fclose($output);
exit();