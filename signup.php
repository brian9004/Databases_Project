<?php
require("connect-db.php");
require("header.php");
?>

<!DOCTYPE html>
<html lang="en" class="body-signup">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign Up Page</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="styles/db-project.css">
</head>

<body>

<div class = error-message-signup>
<?php
// Display an error message if signup fails
if (isset($_GET['error'])) {
    $errorMessage = "An error occurred during sign up. Please try again.";
    echo "<p style='color:red;'>$errorMessage</p>";
}
?>
</div>

<div class="form-container-signup">
  <form action="register.php" method="post" class="form-signup">
    <h2>Sign Up</h2>
    <div class="field-container-signup">
      <label for="email">Email:</label>
      <input type="email" name="email" id="email" required>
    </div>
    <div class="field-container-signup">
      <label for="password">Password:</label>
      <input type="password" name="password" id="password" required>
    </div>
    <div class="field-container-signup">
      <label for="firstName">First Name:</label>
      <input type="text" name="firstName" id="firstName" required>
    </div>
    <div class="field-container-signup">
      <label for="lastName">Last Name:</label>
      <input type="text" name="lastName" id="lastName" required>
    </div>
    <div class="button-submit-signup">
      <input type="submit" value="Sign Up">
    </div>
  </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>