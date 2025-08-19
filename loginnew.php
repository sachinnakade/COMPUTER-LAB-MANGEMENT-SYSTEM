<?php
ob_start(); 
session_start();

$loginMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli("localhost", "root", "", "lab_management");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $uname = trim($_POST['username'] ?? "");
    $pass  = trim($_POST['password'] ?? "");

    if ($uname === "" || $pass === "") {
        $loginMessage = "Username and password are required.";
    } else {
        // Check if user exists
        $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
        $stmt->bind_param("s", $uname);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows === 1) {
            $row = $result->fetch_assoc();

            // Verify password (supports hashed storage)
            if (password_verify($pass, $row['password'])) {
                $_SESSION['username'] = $row['username'];
                header("Location: dashboard.php");
                exit();
            } else {
                $loginMessage = "Incorrect password.";
            }
        } else {
            // Auto-register new user
            $hash = password_hash($pass, PASSWORD_DEFAULT);
            $insert = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $insert->bind_param("ss", $uname, $hash);

            if ($insert->execute()) {
                $_SESSION['username'] = $uname;
                header("Location: dashboard.php");
                exit();
            } else {
                $loginMessage = "Error creating user: " . $conn->error;
            }
            $insert->close();
        }

        $stmt->close();
    }
    $conn->close();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login | Lab System</title>
    <style>
        body {
            font-family: Arial;
            background: url('Lap-Pic2.jpg') no-repeat center center fixed;
            background-size: cover;
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; margin: 0;
        }
        .box {
            background: rgba(255,255,255,0.9); /* semi-transparent for readability */
            color: #333; width: 320px;
            padding: 30px; border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.3);
        }
        .box h2 { text-align: center; margin-bottom: 20px; color: #2c5364; }
        input[type="text"], input[type="password"] {
            width: 100%; padding: 10px; margin-bottom: 15px;
            border-radius: 6px; border: 1px solid #ccc; outline: none;
        }
        button {
            background: #2c5364; color: #fff; border: none;
            padding: 10px; width: 100%; border-radius: 6px; cursor: pointer; font-weight: bold;
        }
        button:hover { background: #1c3944; }
        .message { margin-top: 15px; text-align: center; color: red; font-size: 14px; }
    </style>
</head>
<body>
<div class="box">
    <h2>Login or Auto Register</h2>
    <form method="POST" autocomplete="off">
        <input type="text" name="username" placeholder="Enter Username" required>
        <input type="password" name="password" placeholder="Enter Password" required>
        <button type="submit">Login</button>
    </form>
    <?php if (!empty($loginMessage)): ?>
        <p class="message"><?php echo htmlspecialchars($loginMessage); ?></p>
    <?php endif; ?>
</div>
</body>
</html>
<?php ob_end_flush(); ?>
