<?php 
session_start(); 
require("request-db.php");
?>

<?php // form handling

function clean($data) {  
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

$books = getAllBooks(); // Fetch all books
// $checkouts = getCheckedOutBooks();
$users = getAllUsers();

$checkouts = getCheckedOutBooksByUser();
$userBooks = [];
foreach ($checkouts as $item) {
    $userId = $item['userId'];
    if (!isset($userBooks[$userId])) {
        $userBooks[$userId] = [
            'name' => $item['firstName'] . ' ' . $item['lastName'],
            'books' => []
        ];
    }
    $userBooks[$userId]['books'][] = [
        'bookName' => $item['bookName'],
        'coverImagePath' => $item['coverImagePath']
    ];
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') // GET
{
    if (!empty($_POST['searchBtn']))
    {
      $books = getBookByFields(clean($_POST['bookName']), clean($_POST['author']), clean($_POST['totalQuantity']), clean($_POST['rating']), clean($_POST['category']));
    }

    if (!empty($_POST['deleteBookId']))
    {
      $bookId = intval(clean($_POST['deleteBookId']));
      $userId = clean($_SESSION['user_id']);
      deleteBook($userId, $bookId);
      deleteUpdateLog($userId, $bookId);
      $bookDeleted = true;
      header("Refresh: 0"); // Refresh page immediately to update the list and show the alert
    }

    if (!empty($_POST['rating']))
    {
      $rating = intval(clean($_POST['rating']));
      if ($rating >= 1 && $rating <= 10) {
        createRating(intval(clean($_POST['bookId'])), clean($_SESSION['user_id']), $rating);
        $rateMessage = 1;
      } 
      else {
        $rateMessage = 2;
      }
      
      header("Refresh: 0"); // Refresh page immediately to update the list and show the alert
    }

    if (!empty($_POST['favoriteBook']))
    {
      $userId = intval(clean($_SESSION["user_id"]));
      $bookId = intval(clean($_POST['favoriteBook']));
      createFavorite($bookId, $userId);
      $favorited = true;
      header("Refresh: 0"); // Refresh page immediately to update the list and show the alert
    }

    if (!empty($_POST['unfavoriteBook']))
    {
      $userId = intval(clean($_SESSION["user_id"]));
      $bookId = intval(clean($_POST['unfavoriteBook']));
      removeFavorite($bookId, $userId);
      $unfavorited = true;
      header("Refresh: 0"); // Refresh page immediately to update the list and show the alert
    }

    if (!empty($_POST['checkInBook']))
    {
      $userId = intval(clean($_POST['checkInBook']));
      $bookId = intval(clean($_POST['bookId2']));

      $results = validateAmountCheckedOut(intval($bookId));
      $numCheckedOut = $results[0][1];
      $decrementCheckout = $numCheckedOut - 1;

      $result = checkInBook($bookId, $userId, $decrementCheckout);

      if ($result == 1) {
        $checkInMessage = 1;
      }
      else {
        $checkInMessage = 2;
      }

      
      header("Refresh: 0"); // Refresh page immediately to update the list and show the alert
    }

    if (!empty($_POST['checkoutBookId']))
    {
      $bookId = clean($_POST['checkoutBookId']);
      $results = validateAmountCheckedOut(intval($bookId));
      $totalQuantity = $results[0][0];
      $numCheckedOut = $results[0][1];

      if ($numCheckedOut < $totalQuantity)
      {
        $userId = clean($_SESSION['user_id']);
        $incrementCheckout = $numCheckedOut + 1;

        $cResult = checkoutBook($bookId, $userId, $incrementCheckout);
        
        if ($cResult == 1) {
          $checkoutMessage = 3;
        }
        else {
          $checkoutMessage = 2;
        }
      }
      else
      {
        // all the books are checked out
        $checkoutMessage = 1;
      }
      header("Refresh: 0"); // Refresh page immediately to update the list and show the alert
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Library Catalog</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="styles/db-project.css">
</head>
<body>

<div class="header">
  <div class="logo">
    <button class="button-with-image" onclick="window.location.href='request.php'"> <img src="images/logo-db.jpg" alt="Library Logo"></button>
  </div>
  <span>CATALOG</span>
  <div class="search-container">
    <button id="filter"><img src="images/magnifying_glass.png" alt="Search">Search</button>
  </div>
  <div class="menu">
    <button onclick="window.location.href='request.php'">Home</button>
    <?php if(isset($_SESSION["user_logged_in"]) && $_SESSION["user_logged_in"]): ?>
    <?php
    if(isset($_SESSION["admin"]) && $_SESSION["admin"]): ?>
        <button onclick="window.location.href='admin-dashboard.php'">Dashboard</button>
    <?php else: ?>
        <button onclick="window.location.href='dashboard.php'">Dashboard</button>
    <?php endif; ?>
    <button onclick="window.location.href='logout.php'">Logout</button>
<?php else: ?>
    <button onclick="window.location.href='signup.php'">Sign Up</button>
    <div class="login">
        <button onclick="window.location.href='login.php'">Login</button>
    </div>
<?php endif; ?>

  </div>
</div>

<div id="searchPopup" class="search-popup">
  <!-- Popup content -->
  <div class="popup-content">
    <span class="search-close-btn">&times;</span>
    <h2>Search Books</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" onsubmit="return clean()" id="searchForm">
      <table style="width:80%">
        <tr>
          <td width="50%">
            <div class='mb-3'>
              <input type="text" id="bookName" name="bookName" placeholder="Book Name" value=""><br>
            </div>
          </td>
          <td width="50%">
            <div class='mb-3'>
            <input type="text" id="author" name="author" placeholder="Author" value=""><br>
            </div>
          </td>
        </tr>
        <tr>
          <td width="50%">
            <div class='mb-3'>
              <input type="number" id="totalQuantity" name="totalQuantity" placeholder="Total Quantity" value=""><br>
            </div>
          </td>
          <td width="50%">
            <div class='mb-3'>
              <input type="text" id="rating" name="rating" placeholder="Rating" value=""><br>
            </div>
          </td>
        </tr>
        <tr>
          <td width="50%">
            <div class='mb-3'>
              <input type="text" id="category" name="category" placeholder="Category" value=""><br>
            </div>
          </td>
          <td width="50%">
            <div class='mb-3'>
            <input type="submit" value="Submit" id="searchBtn" name="searchBtn" />
            </div>
          </td>
        </tr>
      </table>
    </form>
  </div>
</div>

<script>
  // Get the modal
  var searchPopup = document.getElementById("searchPopup");
  var searchBtn = document.getElementById("filter");
  var searchSpan = document.getElementsByClassName("search-close-btn")[0];

  // open the modal 
  searchBtn.onclick = function() {
    searchPopup.style.display = "block";
  }
  // close the modal
  searchSpan.onclick = function() {
    searchPopup.style.display = "none";
  }
  // when the user clicks anywhere outside of the modal, close it
  window.onclick = function(event) {
    if (event.target == searchPopup) {
      searchPopup.style.display = "none";
    }
  }
</script>

</body>
</html>    