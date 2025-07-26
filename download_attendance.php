<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'employee') {
    header('Location: login.php');
    exit();
}

$employee_id = $_SESSION['user_id'];

// Set headers to force download
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=attendance_records.csv');

// Output buffer
$output = fopen('php://output', 'w');

// Column headers
fputcsv($output, ['Date', 'Time IN', 'Time OUT']);

// Fetch attendance records
$stmt = $mysqli->prepare('SELECT date, time_in, time_out FROM attendance WHERE employee_id = ? ORDER BY date DESC');
$stmt->bind_param('i', $employee_id);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    fputcsv($output, [$row['date'], $row['time_in'], $row['time_out']]);
}

fclose($output);
exit();
?>
