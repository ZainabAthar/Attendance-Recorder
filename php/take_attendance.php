<?php
include('db_server.php');

if (isset($_GET['cid']) && isset($_GET['tid'])) {
    $cid = $_GET['cid'];
    $tid = $_GET['tid'];

    // Fetch students enrolled in the course
    $students_sql = "SELECT s.sid, s.name as student_name
                     FROM student s
                     INNER JOIN enrollments e ON s.sid = e.sid
                     WHERE e.cid = $cid";
    $students_result = mysqli_query($conn, $students_sql);
} else {
    echo "Course ID or Teacher ID not provided.";
    exit();
}

// Close connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Take Attendance</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="attendance-container">
        <h1>Take Attendance</h1>
        <h2>Course ID: <?php echo htmlspecialchars($cid); ?></h2>
        
        <?php if ($students_result && mysqli_num_rows($students_result) > 0): ?>
            <div class="student-list">
                <?php while ($student_row = mysqli_fetch_assoc($students_result)): ?>
                    <div class="student-item">
                        <span><?php echo htmlspecialchars($student_row['student_name']); ?></span>
                        <button 
                            class="attendance-button present"
                            data-student-id="<?php echo $student_row['sid']; ?>"
                            data-course-id="<?php echo $cid; ?>"
                            data-status="1">P</button>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p class="no-data">No students enrolled in this course.</p>
        <?php endif; ?>
    </div>

    <script>
        $(document).ready(function() {
            $(".attendance-button").click(function() {
                const button = $(this);
                const studentId = button.data("student-id");
                const courseId = button.data("course-id");
                let status = button.data("status");

                // Toggle status and update button appearance
                status = status === 1 ? 0 : 1;
                button.data("status", status);
                button.text(status === 1 ? "P" : "A");
                button.toggleClass("present absent");

                // Send AJAX request to update the database
                $.ajax({
                    url: "take_attendance_backend.php",
                    method: "POST",
                    data: {
                        sid: studentId,
                        cid: courseId,
                        status: status
                    },
                    success: function(response) {
                        console.log(response); // Log success
                    },
                    error: function(xhr, status, error) {
                        console.error("Error:", error); // Log error
                    }
                });
            });
        });
    </script>
</body>
</html>
