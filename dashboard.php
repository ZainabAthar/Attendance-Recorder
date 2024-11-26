<?php
include('db_server.php');

if (isset($_GET['sid'])) {
    $sid = $_GET['sid'];

    // Fetch student details
    $student_sql = "SELECT name, email FROM student WHERE sid = $sid";
    $student_result = mysqli_query($conn, $student_sql);
    $student_row = mysqli_fetch_assoc($student_result);

    // Fetch attendance details
    $attendance_sql = "SELECT c.name as course_name, ca.startTime, ca.endTime, ca.attendance_status 
                      FROM classAttendance ca
                      INNER JOIN course c ON c.cid = ca.cid
                      WHERE ca.sid = $sid";
    $attendance_result = mysqli_query($conn, $attendance_sql);

    // Fetch percentage attendance
    $percentage_sql = "SELECT c.name as course_name, 
                        COUNT(*) as total_classes, 
                        SUM(CASE WHEN ca.attendance_status = 'present' THEN 1 ELSE 0 END) as attended_classes,
                        (SUM(CASE WHEN ca.attendance_status = 'present' THEN 1 ELSE 0 END) / COUNT(*)) * 100 as percentage
                      FROM classAttendance ca
                      INNER JOIN course c ON c.cid = ca.cid
                      WHERE ca.sid = $sid
                      GROUP BY c.name";
    $percentage_result = mysqli_query($conn, $percentage_sql);
} else {
    echo "<p style='text-align: center; color: red;'>Student ID not provided.</p>";
    exit();
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Attendance</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
            padding: 20px;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            width: 100%;
        }
        h2, h3 {
            margin-bottom: 20px;
            color: #444;
        }
        p {
            margin-bottom: 20px;
            font-size: 14px;
            color: #555;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th, table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        table th {
            background: #333;
            color: white;
        }
        .no-data {
            text-align: center;
            color: #888;
            font-size: 16px;
        }
        .highlight-green {
            background-color: lightgreen;
        }
        .highlight-yellow {
            background-color: yellow;
        }
        .highlight-red {
            background-color: red;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if (isset($student_row)): ?>
            <h2>Welcome, <?php echo htmlspecialchars($student_row['name']); ?></h2>
            <p>Email: <?php echo htmlspecialchars($student_row['email']); ?></p>
        <?php endif; ?>

        <?php if ($attendance_result && mysqli_num_rows($attendance_result) > 0): ?>
            <h3>Attendance Details</h3>
            <table>
                <thead>
                    <tr>
                        <th>Course</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($attendance_row = mysqli_fetch_assoc($attendance_result)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($attendance_row['course_name']); ?></td>
                            <td><?php echo htmlspecialchars($attendance_row['startTime']); ?></td>
                            <td><?php echo htmlspecialchars($attendance_row['endTime']); ?></td>
                            <td><?php echo htmlspecialchars($attendance_row['attendance_status']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="no-data">No attendance records found.</p>
        <?php endif; ?>

        <?php if ($percentage_result && mysqli_num_rows($percentage_result) > 0): ?>
            <h3>Percentage Attendance in Each Subject</h3>
            <table>
                <thead>
                    <tr>
                        <th>Course</th>
                        <th>Total Classes</th>
                        <th>Attended Classes</th>
                        <th>Percentage</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($percentage_row = mysqli_fetch_assoc($percentage_result)): ?>
                        <?php
                            $rowClass = '';
                            if ($percentage_row['percentage'] > 75) {
                                $rowClass = 'highlight-green';
                            } elseif ($percentage_row['percentage'] < 60) {
                                $rowClass = 'highlight-red';
                            } else {
                                $rowClass = 'highlight-yellow';
                            }
                        ?>
                        <tr class="<?php echo $rowClass; ?>">
                            <td><?php echo htmlspecialchars($percentage_row['course_name']); ?></td>
                            <td><?php echo htmlspecialchars($percentage_row['total_classes']); ?></td>
                            <td><?php echo htmlspecialchars($percentage_row['attended_classes']); ?></td>
                            <td><?php echo htmlspecialchars(number_format($percentage_row['percentage'], 2)); ?>%</td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="no-data">No percentage attendance data found.</p>
        <?php endif; ?>
    </div>
</body>
</html>
