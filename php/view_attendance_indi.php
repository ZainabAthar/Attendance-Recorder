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
} else {
    echo "<div style='color: red; text-align: center;'>Course ID, Teacher ID, or Start Time not provided.</div>";
    exit();
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Attendance</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background: #f9f9f9; color: #333; display: flex; justify-content: center; align-items: center; min-height: 100vh;">
    <div style="width: 90%; max-width: 800px; background: white; padding: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
        <h2 style="margin-bottom: 20px; text-align: center; color: #444;">Attendance for Course ID: <?php echo $cid; ?>, Teacher ID: <?php echo $tid; ?>, Start Time: <?php echo htmlspecialchars($startTime); ?></h2>

        <?php if ($attendance_result && mysqli_num_rows($attendance_result) > 0): ?>
            <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
                <thead>
                    <tr style="background: #333; color: white;">
                        <th style="padding: 10px; border: 1px solid #ddd;">Student Name</th>
                        <th style="padding: 10px; border: 1px solid #ddd;">Attendance Status</th>
                        <th style="padding: 10px; border: 1px solid #ddd;">Update</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($attendance_result)): ?>
                        <?php
                            $aid = $row['aid'];
                            $studentName = $row['student_name'];
                            $attendanceStatus = $row['attendance_status'];
                        ?>
                        <tr style="text-align: center;">
                            <td style="padding: 10px; border: 1px solid #ddd;"><?php echo htmlspecialchars($studentName); ?></td>
                            <td style="padding: 10px; border: 1px solid #ddd;"><?php echo htmlspecialchars($attendanceStatus); ?></td>
                            <td style="padding: 10px; border: 1px solid #ddd;">
                                <a href="individual_update_form.php?cid=<?php echo $cid; ?>&tid=<?php echo $tid; ?>&aid=<?php echo $aid; ?>" style="text-decoration: none; padding: 8px 12px; background: #007bff; color: white; border-radius: 5px; font-size: 14px; transition: background 0.3s ease;">Update</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p style="text-align: center; color: #888;">No attendance records found for this course, teacher, and start time.</p>
        <?php endif; ?>
    </div>
</body>
</html>
