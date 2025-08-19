<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "lab_management";

// Connect to MySQL database
$conn = new mysqli($host, $user, $password, $database);

// Check for connection error
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $names = $_POST['name'];
    $rolls = $_POST['roll'];
    $departments = $_POST['department'];
    $computers = $_POST['computer_no'];
    $intimes = $_POST['intime'];
    $outtimes = $_POST['outtime'];

    $inserted = false;

    // Loop through each row and insert if not empty
    for ($i = 0; $i < count($names); $i++) {
        if (
            !empty($names[$i]) &&
            !empty($rolls[$i]) &&
            !empty($departments[$i]) &&
            !empty($computers[$i]) &&
            !empty($intimes[$i]) &&
            !empty($outtimes[$i])
        ) {
            $stmt = $conn->prepare("INSERT INTO student_entries (name, roll, department, computer_no, intime, outtime) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $names[$i], $rolls[$i], $departments[$i], $computers[$i], $intimes[$i], $outtimes[$i]);
            $stmt->execute();
            $stmt->close();
            $inserted = true;
        }
    }

    if ($inserted) {
        echo "<script>alert('Entries submitted successfully!'); window.location.href='entry.php';</script>";
    } else {
        echo "<script>alert('No complete entries to submit.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Computer Lab - Student Entry Dashboard</title>
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background: #f0f2f5;
    }

    .header {
      background: #2c3e50;
      color: white;
      padding: 20px;
      text-align: center;
      font-size: 26px;
      font-weight: 600;
      box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    }

    .container {
      max-width: 1200px;
      margin: 30px auto;
      background: white;
      padding: 25px;
      border-radius: 12px;
      box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
    }

    th {
      background: #3498db;
      color: white;
      padding: 12px;
      font-size: 16px;
    }

    td {
      padding: 10px;
      text-align: center;
    }

    input[type="text"], input[type="time"] {
      width: 100%;
      padding: 8px 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
      font-size: 14px;
    }

    .submit-btn {
      margin-top: 20px;
      padding: 12px 25px;
      background-color: #2ecc71;
      color: white;
      border: none;
      border-radius: 6px;
      font-size: 16px;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    .submit-btn:hover {
      background-color: #27ae60;
    }

    @media screen and (max-width: 768px) {
      th, td {
        font-size: 13px;
      }

      .submit-btn {
        width: 100%;
      }
    }
  </style>
</head>
<body>

  <div class="header">Computer Lab Entry Dashboard</div>

  <div class="container">
    <form action="" method="POST">
      <table>
        <thead>
          <tr>
            <th>Full Name</th>
            <th>Roll No</th>
            <th>Department</th>
            <th>Computer No</th>
            <th>In Time</th>
            <th>Out Time</th>
          </tr>
        </thead>
        <tbody>
          <?php for ($i = 0; $i < 8; $i++): ?>
          <tr>
            <td><input type="text" name="name[]"></td>
            <td><input type="text" name="roll[]"></td>
            <td><input type="text" name="department[]"></td>
            <td><input type="text" name="computer_no[]"></td>
            <td><input type="time" name="intime[]"></td>
            <td><input type="time" name="outtime[]"></td>
          </tr>
          <?php endfor; ?>
        </tbody>
      </table>

      <div style="text-align: center;">
        <button type="submit" class="submit-btn">Submit All Entries</button>
      </div>
    </form>
  </div>

</body>
</html>
