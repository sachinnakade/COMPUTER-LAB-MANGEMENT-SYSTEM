CREATE DATABASE student_entry_db;
USE student_entry_db;

CREATE TABLE students (
    student_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    roll_no VARCHAR(20),
    department VARCHAR(50),
    mobile VARCHAR(15),
    email VARCHAR(100),
    blood_group VARCHAR(5),
    photo VARCHAR(255)
);

CREATE TABLE entry_logs (
    log_id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT,
    entry_time DATETIME,
    exit_time DATETIME,
    purpose VARCHAR(255),
    FOREIGN KEY (student_id) REFERENCES students(student_id)
);

CREATE TABLE departments (
    dept_id INT AUTO_INCREMENT PRIMARY KEY,
    dept_name VARCHAR(100)
);
