<?php
require("connect-db.php");
require("header.php");
// Fetch all books
$books = getAllBooks();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="styles/db-project.css">
</head>

<body>

<?php
// Display an error message if wrong creds
if (isset($_GET['error'])) {
    $errorMessage = $_GET['error'] === "invalid" ? "Invalid email or password." : "An error occurred.";
    echo "<p style='color:red;'>$errorMessage</p>";
}
?>

<form action="authenticate.php" method="post">
    <h2>Sign Up For An Account</h2>
    <div class="signup-container">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>
    </div>
    <div class="signup-container">
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>
    </div>
    <div class="signup-button">
        <input type="submit" value="Sign Up">
    </div>
</form>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>