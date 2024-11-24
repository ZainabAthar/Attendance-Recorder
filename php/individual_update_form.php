<?php
include('db_server.php');

if (isset($_GET['aid'])) {
    $aid = $_GET['aid'];
    $cid = $_GET['cid'];
    $tid = $_GET['tid'];

    // Fetch the specific attendance record based on the aid
    $attendance_sql = "SELECT * FROM classAttendance WHERE aid = $aid";
    $attendance_result = mysqli_query($conn, $attendance_sql);

    if ($attendance_result && mysqli_num_rows($attendance_result) > 0) {
        $row = mysqli_fetch_assoc($attendance_result);
        $studentId = $row['sid'];

        // Display form to update attendance status
        echo "<h2>Update Attendance</h2>";
        echo "<form action='update_attendance.php?cid=$cid&tid=$tid' method='POST'>";
        echo "<input type='hidden' name='aid' value='$aid'>";
        echo "New Attendance Status: 
            <select name='new_attendance_status'>
                <option value='present'>Present</option>
                <option value='absent'>Absent</option>
            </select> <br>";
        echo "<input type='submit' value='Update'>";
        echo "</form>";
    } else {
        echo "Attendance record not found for this ID.";
    }
} else {
    echo "Attendance ID not provided.";
}

mysqli_close($conn);
