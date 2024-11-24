<?php
include('db_server.php');

if (isset($_GET['cid']) && isset($_GET['tid']) && isset($_GET['startTime'])) {
    $cid = $_GET['cid'];
    $tid = $_GET['tid'];
    $startTime = $_GET['startTime'];

    // Retrieve attendance details for the specified course, teacher, and start time
    $attendance_sql = "SELECT ca.*, s.name as student_name
                       FROM classAttendance ca
                       INNER JOIN student s ON ca.sid = s.sid
                       WHERE ca.cid = $cid AND ca.tid = $tid AND ca.startTime = '$startTime'";
    $attendance_result = mysqli_query($conn, $attendance_sql);

    if ($attendance_result && mysqli_num_rows($attendance_result) > 0) {
        echo "<h2>Attendance for Course ID: $cid, Teacher ID: $tid, Start Time: $startTime</h2>";
        echo "<table border='1'>
                <tr>
                    <th>Student Name</th>
                    <th>Attendance Status</th>
                    <th>Update</th>
                </tr>";

        while ($row = mysqli_fetch_assoc($attendance_result)) {
            $aid = $row['aid'];
            $studentName = $row['student_name'];
            $attendanceStatus = $row['attendance_status'];

            echo "<tr>
                    <td>$studentName</td>
                    <td>$attendanceStatus</td>
                    <td><a href='individual_update_form.php?cid=$cid&tid=$tid&aid=$aid'>Update</a></td>
                  </tr>";
        }

        echo "</table>";
    } else {
        echo "No attendance records found for this course, teacher, and start time.";
    }
} else {
    echo "Course ID, Teacher ID, or Start Time not provided.";
}

mysqli_close($conn);
