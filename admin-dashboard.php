<!-- this page is for admin only dashboard, functionality has been implemented to check properly and only show to admins -->

<?php
session_start();
require 'connect-db.php';

// Check if the user is logged in, if not then redirect to login page
if (!isset($_SESSION["user_logged_in"]) || $_SESSION["user_logged_in"] !== true) {
    header("location: login.php");
    exit;
}
if($_SESSION["admin"] !== true){ //checks if user is an admin, if not then sends them to home page.
    header("location: request.php");
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
</head>
<body>
  <div class="container">
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['user_email']); ?>!</h1>

    <p>ADMIN DASHBOARD</p>
    
    


  </div>
  <?php include('footer.php'); ?>
</body>
</html>

<!-- this page is for admin only dashboard, functionality has been implemented to check properly and only show to admins -->

<?php
session_start();
require 'connect-db.php';

// Check if the user is logged in, if not then redirect to login page
if (!isset($_SESSION["user_logged_in"]) || $_SESSION["user_logged_in"] !== true) {
    header("location: login.php");
    exit;
}
if($_SESSION["admin"] !== true){ //checks if user is an admin, if not then sends them to home page.
    header("location: request.php");
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
</head>
<body>
  <div class="container">
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['user_email']); ?>!</h1>

    <p>ADMIN DASHBOARD</p>
    
    


  </div>
  <?php include('footer.php'); ?>
</body>
</html>
