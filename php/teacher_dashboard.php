<?php
include('db_server.php');

// Check if the teacher ID is provided
if (isset($_GET['tid'])) {
    $tid = $_GET['tid'];

    // Fetch teacher's subjects
    $subjects_sql = "SELECT cid, name as course_name FROM course WHERE tid = $tid";
    $subjects_result = mysqli_query($conn, $subjects_sql);

    // Close the database connection
    mysqli_close($conn);
} else {
    echo "Teacher ID not provided.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="dashboard-container">
        <h1>Welcome, Teacher</h1>
        <h2>Your Subjects</h2>

        <?php if (mysqli_num_rows($subjects_result) > 0): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Course Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($subject_row = mysqli_fetch_assoc($subjects_result)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($subject_row['course_name']); ?></td>
                            <td>
                                <a href="take_attendance.php?cid=<?php echo $subject_row['cid']; ?>&tid=<?php echo $tid; ?>" class="button">Take Attendance</a>
                                <a href="view_attendance.php?cid=<?php echo $subject_row['cid']; ?>&tid=<?php echo $tid; ?>" class="button">View Attendance</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="no-data">You are not teaching any subjects currently.</p>
        <?php endif; ?>
    </div>
</body>
</html>
