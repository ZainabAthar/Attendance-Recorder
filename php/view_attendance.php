<?php
include('db_server.php');

if (isset($_GET['cid'])) {
    $cid = $_GET['cid'];
    $tid = $_GET['tid'];

    // Fetch unique dates from attendance table corresponding to the teacher and course
    $attendance_dates_sql = "SELECT DISTINCT ca.aid as aid, ca.startTime as startTime
                             FROM classAttendance ca
                             WHERE ca.tid = $tid AND ca.cid = $cid";

    $attendance_dates_result = mysqli_query($conn, $attendance_dates_sql);
} else {
    echo "Course ID not provided.";
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
    <title>View Attendance</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="attendance-container">
        <h1>View Attendance</h1>
        <h2>Previous Sessions</h2>

        <?php if ($attendance_dates_result && mysqli_num_rows($attendance_dates_result) > 0): ?>
            <ul class="attendance-list">
                <?php while ($attendance_dates_row = mysqli_fetch_assoc($attendance_dates_result)): ?>
                    <li class="attendance-item">
                        <a href="view_attendance_indi.php?cid=<?php echo $cid; ?>&tid=<?php echo $tid; ?>&startTime=<?php echo $attendance_dates_row['startTime']; ?>&aid=<?php echo $attendance_dates_row['aid']; ?>">
                            <?php echo htmlspecialchars($attendance_dates_row['startTime']); ?>
                        </a>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p class="no-data">No previous attendance sessions found for this course.</p>
        <?php endif; ?>
    </div>
</body>
</html>
