<?php
include('db_server.php');


if (isset($_GET['cid']) && isset($_GET['tid']) && isset($_POST['attendance'])) {
    $cid = $_GET['cid'];
    $tid = $_GET['tid'];
    $students_attended = $_POST['attendance'];
    $current_time = date("Y-m-d H:i:s");
    $end_time = date("Y-m-d H:i:s", strtotime('+1 hour'));

    // Get all students enrolled in the course
    $enrolled_students_query = "SELECT sid FROM enrollments WHERE cid = $cid";
    $enrolled_students_result = mysqli_query($conn, $enrolled_students_query);

    $enrolled_students = [];
    while ($row = mysqli_fetch_assoc($enrolled_students_result)) {
        $enrolled_students[] = $row['sid'];
    }

    foreach ($enrolled_students as $student_id) {
        // If a student is not in the submitted attendance list, mark as absent
        if (!in_array($student_id, $students_attended)) {
            $insert_query = "INSERT INTO classAttendance (sid, tid, cid, startTime, endTime, attendance_status) 
                             VALUES ($student_id, $tid, $cid, '$current_time', '$end_time', 'absent')";

            if (mysqli_query($conn, $insert_query)) {
                // Record inserted successfully as 'absent'
            } else {
                echo "Error: " . $insert_query . "<br>" . mysqli_error($conn);
            }
        }
    }

    // Mark attended students
    foreach ($students_attended as $student_id) {
        $insert_query = "INSERT INTO classAttendance (sid, tid, cid, startTime, endTime, attendance_status) 
                         VALUES ($student_id, $tid, $cid, '$current_time', '$end_time', 'present')";

        if (mysqli_query($conn, $insert_query)) {
            // Record inserted successfully as 'present'
        } else {
            echo "Error: " . $insert_query . "<br>" . mysqli_error($conn);
        }
    }

    // Redirect to teacher dashboard after taking attendance
    header("Location: teacher_dashboard.php?tid=$tid");
    exit();
} else {
    echo "Course ID, Teacher ID, or Attendance data not provided.";
}


mysqli_close($conn);
