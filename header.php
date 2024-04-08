<?php 
session_start(); 
require("request-db.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Library Catalog</title>
  <link rel="stylesheet" href="db-project.css">
</head>
<body>

<div class="header">
  <div class="logo">
    <button class="button-with-image" onclick="window.location.href='request.php'"> <img src="images/logo-db.jpg" alt="Library Logo"></button>
  </div>
  <span>CATALOG</span>
  <div class="search-container">
    <input type="text" placeholder="Search...">
    <button style=filter:invert(100%) type="submit"><img src="images/magnifying_glass.png" alt="Search"></button>
    <button onclick="getBookById()"><img src="images/filter.png" alt="Search"></button> 
  </div>
  <div class="menu">
    <button onclick="window.location.href='request.php'">Home</button>
    <button onclick="window.location.href='signup.php'">Sign Up</button>
    <div class="login">
      <button onclick="window.location.href='login.php'">Login</button>
    </div>
  </div>
</div>

<!-- Add your JavaScript here for toggleFilterView and other interactions -->

<script>
function toggleFilterView() {
  // Implement the logic to toggle the filter view on the page
  //ivan test initialize
}
</script>

</body>
</html>    