<?php
require("connect-db.php");
require("header.php");
// Fetch all books
$books = getAllBooks();
?>

<!DOCTYPE html>
<html lang="en" class="body-login">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="styles/db-project.css">

<body>

<div class = error-message-login>
<?php
// Display an error message if wrong creds
if (isset($_GET['error'])) {
    $errorMessage = $_GET['error'] === "invalid" ? "Invalid email or password." : "An error occurred.";
    echo "<p style='color:red;'>$errorMessage</p>";
}
?>
</div>


<div class="form-container-login">
  <form action="authenticate.php" method="post" class="form-login">
    <h2>Login</h2>
    <div class="field-container-login">
      <label for="email">Email:</label>
      <input type="email" name="email" id="email" required>
    </div>
    <div class="field-container-login">
      <label for="password">Password:</label>
      <input type="password" name="password" id="password" required>
    </div>
    <div class="button-submit-login">
      <input type="submit" value="Login">
    </div>
  </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>