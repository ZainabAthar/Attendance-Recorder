<?php
include('db_server.php');

if (isset($_GET['cid']) && isset($_GET['tid'])) {
    $cid = $_GET['cid'];
    $tid = $_GET['tid'];

    $students_sql = "SELECT s.sid, s.name as student_name
                     FROM student s
                     INNER JOIN enrollments e ON s.sid = e.sid
                     WHERE e.cid = $cid";
    $students_result = mysqli_query($conn, $students_sql);

    echo "<h2>Take Attendance</h2>";
    echo "<form action='take_attendance_backend.php?cid=$cid&tid=$tid' method='POST'>";
    echo "<h3>Course ID: $cid</h3>";

    if ($students_result && mysqli_num_rows($students_result) > 0) {
        while ($student_row = mysqli_fetch_assoc($students_result)) {
            echo "<label for='attendance{$student_row['sid']}'>
                    <input type='checkbox' id='attendance{$student_row['sid']}' 
                           name='attendance[]' value='{$student_row['sid']}' />
                    {$student_row['student_name']}
                  </label><br />";
        }
    } else {
        echo "No students enrolled in this course.";
    }

    echo "<br /><input type='submit' value='Submit Attendance' />";
    echo "</form>";
} else {
    echo "Course ID or Teacher ID not provided.";
}

mysqli_close($conn);
