<?php
session_start();
require 'connect-db.php';

function showBookDetails($book) {
  $html = "<div class='modal fade' id='modal{$book['bookId']}' tabindex='-1' aria-hidden='true'>";
  $html .= "<div class='modal-dialog modal-dialog-centered'>";
  $html .= "<div class='modal-content'>";
  $html .= "<div class='modal-header'>";
  $html .= "<h5 class='modal-title'>" . htmlspecialchars($book['bookName']) . "</h5>";
  $html .= "<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>";
  $html .= "</div>"; // end modal-header
  $html .= "<div class='modal-body'>";
  $html .= "<div class='text-center'>"; // Container for centered content
  $html .= "<img src='" . htmlspecialchars($book['coverImagePath']) . "' class='img-fluid mb-3'>";
  $html .= "</div>"; // end centering container
  $html .= "<div class='ms-5'>";
  $html .= "<p><strong>Author:</strong> " . htmlspecialchars($book['author']) . "</p>";
  $html .= "<p><strong>Category:</strong> " . htmlspecialchars($book['category']) . "</p>";
  $html .= "</div>";
  $html .= "</div>"; // end modal-body
  $html .= "<div class='modal-footer'>";
  if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true) {
      $html .= "<form method='POST' action=''>";
      $html .= "<input type='hidden' name='checkoutBookId' value='{$book['bookId']}'>";    
      $html .= "<button type='submit' class='btn btn-success'>Checkout Book</button>";
      $html .= "</form>";
  }
  if (isset($_SESSION['admin']) && $_SESSION['admin'] === true) {
      $html .= "<form method='POST' action=''>";
      $html .= "<input type='hidden' name='deleteBookId' value='{$book['bookId']}'>";    
      $html .= "<button type='submit' class='btn btn-danger'>Delete Book</button>";
      $html .= "</form>";
  }
  $html .= "<button type='button' onclick='closeModal(\"modal{$book['bookId']}\")' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>";
  $html .= "</div>"; // end modal-footer
  $html .= "</div>"; // end modal-content
  $html .= "</div>"; // end modal-dialog
  $html .= "</div>"; // end modal
  return $html;
}

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
              <div id="<?php echo htmlspecialchars($book['bookId']); ?>" class="book-item">
                <img src="<?php echo htmlspecialchars($book['coverImagePath']); ?>"
                  class="book-cover img-fluid"
                  data-bs-toggle="modal"
                  data-bs-target="#modal<?php echo $book['bookId']; ?>"
                  style="cursor:pointer;">
              </div>
              <?php echo showBookDetails($book); // Generate and display the modal for each book ?>
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

  <?php include('footer.html'); ?>
</body>
<script>
    function closeModal(modalId) {
        document.getElementById(modalId).style.display = 'none';
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</html>