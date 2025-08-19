<?php
session_start();
if (!isset($_SESSION['username'])) {
  header("Location: login.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Computer Lab - Student Entry Dashboard</title>
  <style>
    * {
      box-sizing: border-box;
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      padding: 0;
    }

    body {
      background: linear-gradient(to right, #1c1c2b, #3e4c59);
      color: #fff;
      height: 100vh;
      display: flex;
      flex-direction: column;
    }

    header {
      background-color: #222;
      padding: 20px 40px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    header h1 {
      font-size: 24px;
    }

    .logout-btn {
      background-color: #ff4c4c;
      border: none;
      padding: 10px 20px;
      color: white;
      border-radius: 5px;
      cursor: pointer;
    }

    .main {
      flex: 1;
      padding: 40px;
    }

    .card-container {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
      gap: 20px;
    }

    .card {
      background-color: #ffffff12;
      padding: 20px;
      border-radius: 12px;
      text-align: center;
      transition: 0.3s;
      border: 1px solid #ffffff30;
    }

    .card:hover {
      background-color: #ffffff1f;
    }

    .card h3 {
      font-size: 20px;
      margin-bottom: 10px;
    }

    .card p {
      font-size: 14px;
      opacity: 0.8;
    }

    footer {
      text-align: center;
      padding: 20px;
      font-size: 14px;
      background-color: #111;
      color: #888;
    }

    a {
      text-decoration: none;
      color: #fff;
    }

    a.view-btn {
      display: inline-block;
      margin-top: 15px;
      background-color: #29a329;
      padding: 8px 15px;
      border-radius: 6px;
      color: #fff;
    }

    .tabs {
      margin-bottom: 30px;
    }

    .tabs a {
      background-color: #444;
      padding: 10px 20px;
      margin-right: 10px;
      border-radius: 6px;
      text-decoration: none;
      color: #fff;
      transition: background 0.2s;
      cursor: pointer;
    }

    .tabs a:hover {
      background-color: #29a329;
    }
  </style>
  <script>
    function loadPage(page) {
      document.getElementById('content-frame').src = page;
    }
  </script>
</head>
<body>

<header>
  <h1>Lab Dashboard</h1>
  <form method="POST" action="logout.php">
    <button class="logout-btn" type="submit">Logout</button>
  </form>
</header>

<div class="main">
  <div class="tabs">
    <a onclick="loadPage('entry.php')">Enter Entries</a>
    <a onclick="loadPage('view.php')">View Entries</a>
  </div>

  <iframe id="content-frame" src="entry.php" style="width:100%; height:80vh; border:none;"></iframe>
</div>

<footer>
  &copy; <?php echo date('Y'); ?> Computer Lab Management System
</footer>

</body>
</html>
