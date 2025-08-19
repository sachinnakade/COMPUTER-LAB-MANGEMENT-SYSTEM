<?php
session_start();

if (isset($_SESSION['username'])) {
    $conn = new mysqli("localhost", "root", "", "lab_management");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $username = $_SESSION['username'];

    // Delete the user from the database
    $stmt = $conn->prepare("DELETE FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();

    $stmt->close();
    $conn->close();

    // Destroy session
    session_unset();
    session_destroy();
}

// Redirect to login page (update to correct file name)
header("Location: loginnew.php"); // ✅ use correct filename here
exit();
?>
