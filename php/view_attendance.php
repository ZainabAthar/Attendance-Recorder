<?php
include('db_server.php');

if (isset($_GET['cid'])) {
    $cid = $_GET['cid'];
    $tid = $_GET['tid'];

    // Fetch unique dates from attendance table corresponding to a particular 'teacher id', and 'course id'
    $attendance_dates_sql = "SELECT DISTINCT ca.aid as aid, ca.startTime as startTime
    FROM classAttendance ca
    WHERE ca.tid = $tid AND ca.cid = $cid
        ";

    $attendance_dates_result = mysqli_query($conn, $attendance_dates_sql);

    // Print the dates
    echo "<h2>Previous Sessions</h2>";

    if (mysqli_num_rows($attendance_dates_result) > 0) {
        echo "<ul>";
        while ($attendance_dates_row = mysqli_fetch_assoc($attendance_dates_result)) {
            $startTime = $attendance_dates_row['startTime'];
            $aid = $attendance_dates_row['aid'];
            echo "<li>
            <a href='view_attendance_indi.php?cid=$cid&tid=$tid&startTime=$startTime&aid=$aid'>$startTime</a>
            </li>";
        }
        echo "</ul>";
    }


    // // Fetch attendance records for the selected course
    // $attendance_sql = "SELECT s.name as student_name, ca.startTime, ca.endTime, ca.attendance_status
    //                    FROM classAttendance ca
    //                    INNER JOIN student s ON ca.sid = s.sid
    //                    WHERE ca.cid = $cid";
    // $attendance_result = mysqli_query($conn, $attendance_sql);

    // // Display attendance records
    // echo "<h2>View Attendance</h2>";
    // echo "<h3>Course ID: $cid</h3>";

    // if (mysqli_num_rows($attendance_result) > 0) {
    //     echo "<table border='1'>
    //             <tr>
    //                 <th>Student Name</th>
    //                 <th>Start Time</th>
    //                 <th>End Time</th>
    //                 <th>Status</th>
    //             </tr>";

    //     while ($attendance_row = mysqli_fetch_assoc($attendance_result)) {
    //         echo "<tr>";
    //         echo "<td>{$attendance_row['student_name']}</td>";
    //         echo "<td>{$attendance_row['startTime']}</td>";
    //         echo "<td>{$attendance_row['endTime']}</td>";
    //         echo "<td>{$attendance_row['attendance_status']}</td>";
    //         echo "</tr>";
    //     }

    //     echo "</table>";
    // } else {
    //     echo "No attendance records found for this course.";
    // }
} else {
    echo "Course ID not provided.";
}

mysqli_close($conn);
