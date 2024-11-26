<?php
include('db_server.php');

if (isset($_GET['aid'])) {
    $aid = $_GET['aid'];
    $cid = $_GET['cid'];
    $tid = $_GET['tid'];

    // Fetch the specific attendance record based on the aid
    $attendance_sql = "SELECT * FROM classAttendance WHERE aid = $aid";
    $attendance_result = mysqli_query($conn, $attendance_sql);

    if ($attendance_result && mysqli_num_rows($attendance_result) > 0) {
        $row = mysqli_fetch_assoc($attendance_result);
        $studentId = $row['sid'];
    } else {
        echo "<p style='color: red; text-align: center;'>Attendance record not found for this ID.</p>";
        exit();
    }
} else {
    echo "<p style='color: red; text-align: center;'>Attendance ID not provided.</p>";
    exit();
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Attendance</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background: #f9f9f9; color: #333; display: flex; justify-content: center; align-items: center; height: 100vh;">
    <div style="text-align: center; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); width: 400px; max-width: 90%;">
        <h2 style="color: #444; margin-bottom: 20px;">Update Attendance</h2>
        <form action="update_attendance.php?cid=<?php echo $cid; ?>&tid=<?php echo $tid; ?>" method="POST" style="display: flex; flex-direction: column; gap: 15px;">
            <input type="hidden" name="aid" value="<?php echo $aid; ?>" style="padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
            <label for="new_attendance_status" style="text-align: left; font-size: 14px;">New Attendance Status:</label>
            <select name="new_attendance_status" id="new_attendance_status" style="padding: 10px; border: 1px solid #ddd; border-radius: 5px; font-size: 14px;">
                <option value="present">Present</option>
                <option value="absent">Absent</option>
            </select>
            <button type="submit" style="padding: 12px; background: #007bff; color: white; border: none; border-radius: 5px; font-size: 16px; cursor: pointer; transition: background 0.3s ease;">Update</button>
        </form>
    </div>
</body>
</html>
