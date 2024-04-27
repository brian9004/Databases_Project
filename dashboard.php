<?php
session_start();
require 'connect-db.php';

// Check if the user is logged in, if not then redirect to login page
if (!isset($_SESSION["user_logged_in"]) || $_SESSION["user_logged_in"] !== true) {
    header("location: login.php");
    exit;
}

require 'header.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f0f2f5;
      margin: 0;
      padding: 0;
      color: #333;
      line-height: 1.6;
    }
    .container {
      width: 80%;
      margin: 40px auto;
      background-color: #fff;
      padding: 20px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      border-radius: 8px;
      transition: box-shadow 0.3s ease-in-out;
    }
    .container:hover {
      box-shadow: 0 8px 16px rgba(0,0,0,0.2);
    }
    h1 {
      color: #0056b3;
      margin-bottom: 10px;
    }
    p {
      font-size: 16px;
    }
    h2 {
      background-color: #e9f5db;
      color: #276749;
      padding: 15px;
      border-left: 5px solid #276749;
      border-radius: 4px;
      margin-top: 20px;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Welcome <?php echo htmlspecialchars($_SESSION['user_email']); ?>!</h1>

    <p>This is your dashboard. You can manage your profile, check your activities, or start using the services.</p>
    
    <h2>If you have reached this page you have successfully logged in or signed up</h2>
  </div>
  <?php include('footer.php'); ?>
</body>
</html>
