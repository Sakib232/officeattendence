<?php
// db.php
$mysqli = new mysqli('localhost', 'root', '', 'office_attendence');

if ($mysqli->connect_error) {
    die('Database connection failed: ' . $mysqli->connect_error);
}
?>