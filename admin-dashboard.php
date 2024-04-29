<?php
session_start();
require 'connect-db.php';

// Check if the user is logged in, if not then redirect to login page
if (!isset($_SESSION["user_logged_in"]) || $_SESSION["user_logged_in"] !== true) {
    header("location: login.php");
    exit;
}
// Check if the user is an admin, if not then redirect to home page
if ($_SESSION["admin"] !== true) {
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
  <title>Admin Dashboard</title>

</head>
<body class="admin-dashboard">
  <div class="container">
    <h1>Welcome Admin<?php echo htmlspecialchars($_SESSION['user_email']); ?>!</h1>
    <p>This is your admin dashboard. Here you can manage user accounts, view site analytics, and configure settings.</p>
    <h2>Access restricted to administrators only.</h2>
  </div>
  
  <div class="container mt-4">
    <div class="row">
      <div class="col-md-6">
        <h2>Checked out Books:</h2>
        <?php if (empty($checkouts)): ?>
          <p>No books are currently checked out.</p>
        <?php else: ?>
          <div class="book-grid">
            <?php foreach ($checkouts as $book): ?>
              <div class="book-item">
                <img src="<?php echo htmlspecialchars($book['coverImagePath']); ?>" alt="<?php echo htmlspecialchars($book['bookName']); ?>" class="book-cover img-fluid">
              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>

      <div class="col-md-6">
        <h2>Users:</h2>
        <table class="table">
          <thead>
            <tr>
              <th>First Name</th>
              <th>Last Name</th>
              <th>Email</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($users as $user): ?>
              <tr>
                <td><?php echo htmlspecialchars($user['firstName']); ?></td>
                <td><?php echo htmlspecialchars($user['lastName']); ?></td>
                <td><?php echo htmlspecialchars($user['email']); ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <?php include('footer.php'); ?>
</body>
</html>