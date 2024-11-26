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
        echo "<div style='display: flex; justify-content: center; align-items: center; height: 100vh; font-family: Arial, sans-serif; background: #f4f4f4;'>
                <div style='text-align: center; background: white; padding: 20px 30px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);'>
                    <h2 style='color: #4caf50;'>Attendance Updated Successfully</h2>
                    <p style='color: #333;'>Redirecting to the attendance overview...</p>
                    <a href='view_attendance.php?cid=$cid&tid=$tid' style='display: inline-block; padding: 10px 20px; background: #007bff; color: white; text-decoration: none; border-radius: 5px; font-size: 16px;'>View Attendance</a>
                </div>
              </div>";
        header("refresh:3;url=view_attendance.php?cid=$cid&tid=$tid");
        exit();
    } else {
        echo "<div style='display: flex; justify-content: center; align-items: center; height: 100vh; font-family: Arial, sans-serif; background: #f4f4f4;'>
                <div style='text-align: center; background: white; padding: 20px 30px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);'>
                    <h2 style='color: #f44336;'>Error Updating Attendance</h2>
                    <p style='color: #333;'>". mysqli_error($conn) ."</p>
                    <a href='view_attendance.php?cid=$cid&tid=$tid' style='display: inline-block; padding: 10px 20px; background: #007bff; color: white; text-decoration: none; border-radius: 5px; font-size: 16px;'>Go Back</a>
                </div>
              </div>";
    }
} else {
    echo "<div style='display: flex; justify-content: center; align-items: center; height: 100vh; font-family: Arial, sans-serif; background: #f4f4f4;'>
            <div style='text-align: center; background: white; padding: 20px 30px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);'>
                <h2 style='color: #f44336;'>Invalid Request</h2>
                <p style='color: #333;'>Attendance ID not provided or invalid request method.</p>
                <a href='view_attendance.php' style='display: inline-block; padding: 10px 20px; background: #007bff; color: white; text-decoration: none; border-radius: 5px; font-size: 16px;'>Go Back</a>
            </div>
          </div>";
}

mysqli_close($conn);
