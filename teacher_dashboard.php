<?php
include('db_server.php');

if (isset($_GET['tid'])) {
    $tid = $_GET['tid'];

    // Fetch teacher's subjects
    $subjects_sql = "SELECT cid, name as course_name FROM course WHERE tid = $tid";
    $subjects_result = mysqli_query($conn, $subjects_sql);

    // Display teacher's subjects
    echo "<h2>Subjects You're Teaching</h2>";

    if (mysqli_num_rows($subjects_result) > 0) {
        echo "<ul>";
        while ($subject_row = mysqli_fetch_assoc($subjects_result)) {
            echo "<li>{$subject_row['course_name']} 
                    - <a href='take_attendance.php?cid={$subject_row['cid']}&tid={$tid}'>Take Attendance</a> 
                    - <a href='view_attendance.php?cid={$subject_row['cid']}&tid={$tid}'>View Attendance</a>
                  </li>";
        }
        echo "</ul>";
    } else {
        echo "You are not teaching any subjects currently.";
    }
} else {
    echo "Teacher ID not provided.";
}

mysqli_close($conn);
