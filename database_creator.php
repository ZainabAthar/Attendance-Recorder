<?php
include('db_server.php');

// SQL queries to create database structure
$sql_queries = "
    CREATE TABLE student (
        sid INT PRIMARY KEY AUTO_INCREMENT,
        name VARCHAR(100),
        email VARCHAR(100) UNIQUE,
        password VARCHAR(100),
        rollNo VARCHAR(20)
    );

    CREATE TABLE teacher (
        tid INT PRIMARY KEY AUTO_INCREMENT,
        name VARCHAR(100),
        email VARCHAR(100) UNIQUE,
        password VARCHAR(100)
    );

    CREATE TABLE course (
        cid INT PRIMARY KEY AUTO_INCREMENT,
        name VARCHAR(100),
        tid INT,
        FOREIGN KEY (tid) REFERENCES teacher(tid)
    );

    CREATE TABLE enrollments (
        eid INT PRIMARY KEY AUTO_INCREMENT,
        sid INT,
        cid INT,
        FOREIGN KEY (sid) REFERENCES student(sid),
        FOREIGN KEY (cid) REFERENCES course(cid)
    );

    CREATE TABLE classAttendance (
        aid INT PRIMARY KEY AUTO_INCREMENT,
        sid INT,
        tid INT,
        cid INT,
        startTime DATETIME,
        endTime DATETIME,
        attendance_status ENUM('present', 'absent'),
        FOREIGN KEY (sid) REFERENCES student(sid),
        FOREIGN KEY (tid) REFERENCES teacher(tid),
        FOREIGN KEY (cid) REFERENCES course(cid)
    );

    -- Inserting data into the 'student' table
    INSERT INTO student (name, email, password, rollNo) VALUES
    ('John Doe', 'john@example.com', 'password123', 'A001'),
    ('Alice Smith', 'alice@example.com', 'pass456', 'B002'),
    ('Emma Johnson', 'emma@example.com', 'secure789', 'C003'),
    ('Michael Brown', 'michael@example.com', 'pass123', 'D004'),
    ('Sophia Wilson', 'sophia@example.com', 'strongpass', 'E005');

    -- Inserting data into the 'teacher' table
    INSERT INTO teacher (name, email, password) VALUES
    ('Professor Smith', 'prof.smith@example.com', 'teacherpass'),
    ('Dr. Johnson', 'dr.johnson@example.com', 'secureteacher'),
    ('Ms. Davis', 'davis@example.com', 'teacher123'),
    ('Mr. Lee', 'lee@example.com', 'passforteacher'),
    ('Mrs. Adams', 'adams@example.com', 'teacherpass123');

    -- Inserting data into the 'course' table
    INSERT INTO course (name, tid) VALUES
    ('Mathematics', 1),
    ('Physics', 2),
    ('Literature', 3),
    ('History', 4),
    ('Biology', 5);

    -- Inserting data into the 'enrollments' table
    INSERT INTO enrollments (sid, cid) VALUES
    (1, 1),
    (2, 2),
    (3, 3),
    (4, 4),
    (5, 5),
    (1, 2),
    (2, 3),
    (3, 4),
    (4, 5),
    (5, 1),
    (1, 3),
    (2, 4),
    (3, 5),
    (4, 1),
    (5, 2);

    -- Inserting data into the 'classAttendance' table
    INSERT INTO classAttendance (sid, tid, cid, startTime, endTime, attendance_status) VALUES
    (1, 1, 1, '2023-11-30 09:00:00', '2023-11-30 11:00:00', 'present'),
    (2, 2, 2, '2023-11-30 10:00:00', '2023-11-30 12:00:00', 'present'),
    (3, 3, 3, '2023-11-30 11:00:00', '2023-11-30 13:00:00', 'absent'),
    (4, 4, 4, '2023-11-30 12:00:00', '2023-11-30 14:00:00', 'present'),
    (5, 5, 5, '2023-11-30 13:00:00', '2023-11-30 15:00:00', 'absent'),
    (1, 1, 2, '2023-11-30 09:00:00', '2023-11-30 11:00:00', 'present'),
    (2, 2, 3, '2023-11-30 10:00:00', '2023-11-30 12:00:00', 'absent'),
    (3, 3, 4, '2023-11-30 11:00:00', '2023-11-30 13:00:00', 'present'),
    (4, 4, 5, '2023-11-30 12:00:00', '2023-11-30 14:00:00', 'present'),
    (5, 5, 1, '2023-11-30 13:00:00', '2023-11-30 15:00:00', 'absent'),
    (1, 2, 3, '2023-11-30 14:00:00', '2023-11-30 16:00:00', 'present'),
    (2, 3, 4, '2023-11-30 15:00:00', '2023-11-30 17:00:00', 'present'),
    (3, 4, 5, '2023-11-30 16:00:00', '2023-11-30 18:00:00', 'absent'),
    (4, 5, 1, '2023-11-30 17:00:00', '2023-11-30 19:00:00', 'present'),
    (5, 1, 2, '2023-11-30 18:00:00', '2023-11-30 20:00:00', 'present');
    ";


// Close connection
mysqli_close($conn);
