<?php
include('db_server.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    if ($role == 'teacher') {
        $sql = "SELECT * FROM teacher WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            if ($password == $row['password']) {
                // Redirect to teacher dashboard or homepage
                header("Location: teacher_dashboard.php?tid=" . $row['tid']);
                exit(); // Ensure that code execution stops after redirection
            } else {
                echo "Incorrect password for teacher";
            }
        } else {
            echo "User not found";
        }
    } elseif ($role == 'student') {
        $sql = "SELECT * FROM student WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            if ($password == $row['password']) {
                // Redirect to student dashboard with student ID as parameter
                header("Location: dashboard.php?sid=" . $row['sid']);
                exit(); // Ensure that code execution stops after redirection
            } else {
                echo "Incorrect password for student";
            }
        }
    }
}

mysqli_close($conn);
