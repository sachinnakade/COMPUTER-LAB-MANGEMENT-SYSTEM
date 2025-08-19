<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "lab_management";

// Connect to DB
$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle delete request
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['delete_id'])) {
    $deleteId = intval($_POST['delete_id']);
    $deleteQuery = "DELETE FROM student_entries WHERE id = $deleteId";
    $conn->query($deleteQuery);
}

// Fetch data after potential deletion
$sql = "SELECT * FROM student_entries ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>View Entries</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #f0f2f5;
      padding: 30px;
    }

    h2 {
      text-align: center;
      margin-bottom: 20px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background: white;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
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
      border-bottom: 1px solid #ccc;
    }

    tr:nth-child(even) {
      background-color: #f9f9f9;
    }

    form {
      margin: 0;
    }

    .delete-button {
      background-color: #e74c3c;
      color: white;
      border: none;
      padding: 6px 12px;
      cursor: pointer;
      border-radius: 4px;
    }

    .delete-button:hover {
      background-color: #c0392b;
    }
  </style>
</head>
<body>

<h2>Student Entry Records</h2>

<table>
  <tr>
    <th>ID</th>
    <th>Name</th>
    <th>Roll No</th>
    <th>Department</th>
    <th>Computer No</th>
    <th>In Time</th>
    <th>Out Time</th>
    <th>Action</th>
  </tr>
  <?php if ($result->num_rows > 0): ?>
    <?php while($row = $result->fetch_assoc()): ?>
      <tr>
        <td><?= $row['id'] ?></td>
        <td><?= htmlspecialchars($row['name']) ?></td>
        <td><?= htmlspecialchars($row['roll']) ?></td>
        <td><?= htmlspecialchars($row['department']) ?></td>
        <td><?= htmlspecialchars($row['computer_no']) ?></td>
        <td><?= htmlspecialchars($row['intime']) ?></td>
        <td><?= htmlspecialchars($row['outtime']) ?></td>
        <td>
          <form method="POST" onsubmit="return confirm('Are you sure you want to delete this entry?');">
            <input type="hidden" name="delete_id" value="<?= $row['id'] ?>">
            <button type="submit" class="delete-button">Delete</button>
          </form>
        </td>
      </tr>
    <?php endwhile; ?>
  <?php else: ?>
    <tr><td colspan="8">No records found.</td></tr>
  <?php endif; ?>
</table>

</body>
</html>
