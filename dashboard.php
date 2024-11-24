<?php
include('db_server.php');

if (isset($_GET['sid'])) {
    $sid = $_GET['sid'];

    // Fetch student details
    $student_sql = "SELECT name, email FROM student WHERE sid = $sid";
    $student_result = mysqli_query($conn, $student_sql);
    $student_row = mysqli_fetch_assoc($student_result);

    // Display student details
    echo "<h2>Welcome, {$student_row['name']}</h2>";
    echo "<p>Email: {$student_row['email']}</p>";

    // Fetch attendance details
    $attendance_sql = "SELECT c.name as course_name, ca.startTime, ca.endTime, ca.attendance_status 
                      FROM classAttendance ca
                      INNER JOIN course c ON c.cid = ca.cid
                      WHERE ca.sid = $sid";
    $attendance_result = mysqli_query($conn, $attendance_sql);

    // Display attendance details
    if (mysqli_num_rows($attendance_result) > 0) {
        echo "<h3>Attendance Details</h3>";
        echo "<table border='1'>
                <tr>
                    <th>Course</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Status</th>
                </tr>";

        while ($attendance_row = mysqli_fetch_assoc($attendance_result)) {
            echo "<tr>";
            echo "<td>{$attendance_row['course_name']}</td>";
            echo "<td>{$attendance_row['startTime']}</td>";
            echo "<td>{$attendance_row['endTime']}</td>";
            echo "<td>{$attendance_row['attendance_status']}</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No attendance records found.";
    }

    // Calculate percentage attendance in each subject
    $percentage_sql = "SELECT c.name as course_name, 
                        COUNT(*) as total_classes, 
                        SUM(CASE WHEN ca.attendance_status = 'present' THEN 1 ELSE 0 END) as attended_classes,
                        (SUM(CASE WHEN ca.attendance_status = 'present' THEN 1 ELSE 0 END) / COUNT(*)) * 100 as percentage
                      FROM classAttendance ca
                      INNER JOIN course c ON c.cid = ca.cid
                      WHERE ca.sid = $sid
                      GROUP BY c.name";
    $percentage_result = mysqli_query($conn, $percentage_sql);

    // Display percentage attendance
    if (mysqli_num_rows($percentage_result) > 0) {
        echo "<h3>Percentage Attendance in Each Subject</h3>";
        echo "<table border='1'>
                <tr>
                    <th>Course</th>
                    <th>Total Classes</th>
                    <th>Attended Classes</th>
                    <th>Percentage</th>
                </tr>";

        while ($percentage_row = mysqli_fetch_assoc($percentage_result)) {
            if ($percentage_row['percentage'] > 75) {
                $rowColor = 'style="background-color: lightgreen;"';
            } elseif ($percentage_row['percentage'] < 60) {
                $rowColor = 'style="background-color: red;"';
            } else {
                $rowColor = 'style="background-color: yellow;"';
            }
            echo "<tr>";
            echo "<td>{$percentage_row['course_name']}</td>";
            echo "<td>{$percentage_row['total_classes']}</td>";
            echo "<td>{$percentage_row['attended_classes']}</td>";
            echo "<td $rowColor>{$percentage_row['percentage']}%</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No percentage attendance data found.";
    }
} else {
    echo "Student ID not provided.";
}

mysqli_close($conn);
