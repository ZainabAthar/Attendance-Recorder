<?php
include('db_server.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cid = $_GET['cid'];
    $tid = $_GET['tid'];
    $aid = $_POST['aid'];
    $attendanceStatus = $_POST['new_attendance_status'];

    // Update the attendance status in the database
    $update_query = "UPDATE classAttendance SET attendance_status = '$attendanceStatus' WHERE aid = $aid";

    if (mysqli_query($conn, $update_query)) {
        // Redirect to view_attendance.php after updating
        header("Location: view_attendance.php?cid=$cid&tid=$tid");
        exit();
    } else {
        echo "Error updating attendance: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request or attendance ID not provided.";
}

mysqli_close($conn);
