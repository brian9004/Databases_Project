<?php
require("connect-db.php");
require("header.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign Up Page</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="styles/db-project.css">
</head>

<body>

<?php
// Display an error message if signup fails
if (isset($_GET['error'])) {
    $errorMessage = "An error occurred during sign up. Please try again.";
    echo "<p style='color:red;'>$errorMessage</p>";
}
?>

<form action="register.php" method="post">
    <h2>Sign Up</h2>
    <div class="login-container">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>
    </div>
    <div class="login-container">
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>
    </div>
    <div class="login-container">
        <label for="firstName">First Name:</label>
        <input type="text" name="firstName" id="firstName" required>
    </div>
    <div class="login-container">
        <label for="lastName">Last Name:</label>
        <input type="text" name="lastName" id="lastName" required>
    </div>
    <div class="login-button">
        <input type="submit" value="Sign Up">
    </div>
</form>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>