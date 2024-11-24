<?php
$db_server = "localhost";
$db_user = "root";
$db_password = "";
$db_name = "attendance_management_system";

// Create connection
$conn = mysqli_connect($db_server, $db_user, $db_password, $db_name, 3307);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
