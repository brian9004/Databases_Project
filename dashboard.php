<?php
session_start();
require 'connect-db.php';

// Check if the user is logged in, if not then redirect to login page
// if (!isset($_SESSION["user_logged_in"]) || $_SESSION["user_logged_in"] !== true) {
//     header("location: login.php");
//     exit;
// }

// Fetch user details if needed from the database
// $userDetails = getUserDetails($_SESSION['user_id']); 

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

    <p>This is your dashboard. You can manage your profile, check your activities, or start using the services.</p>
    
    <h2>If you have reached this page you have successfully logged in or signed up </h2>


  </div>
  <?php include('footer.php'); ?>
</body>
</html>
