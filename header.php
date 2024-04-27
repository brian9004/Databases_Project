<?php 
session_start(); 
require("request-db.php");
?>

<?php // form handling
$books = getAllBooks(); // Fetch all books

if ($_SERVER['REQUEST_METHOD'] == 'POST') // GET
{
    if (!empty($_POST['searchBtn']))
    {
      $books = getBookByFields($_POST['bookName'], $_POST['author'], $_POST['totalQuantity'], $_POST['rating'], $_POST['category'], $_POST['issued']);
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
    <span class="close-btn">&times;</span>
    <h2>Search Books</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" onsubmit="return validateInput()" id="searchForm">
      <input type="text" id="bookName" name="bookName" placeholder="Book Name" value=""><br>
      <input type="text" id="author" name="author" placeholder="Author" value=""><br>
      <input type="number" id="totalQuantity" name="totalQuantity" placeholder="Total Quantity" value=""><br>
      <input type="text" id="rating" name="rating" placeholder="Rating" value=""><br>
      <input type="text" id="category" name="category" placeholder="Category" value=""><br>
      <input type="submit" value="Submit" id="searchBtn" name="searchBtn" />
    </form>
  </div>
</div>

<script>
  // Get the modal
  var popup = document.getElementById("searchPopup");

  // Get the button that opens the modal
  var btn = document.getElementById("filter");

  // Get the <span> element that closes the modal
  var span = document.getElementsByClassName("close-btn")[0];

  // When the user clicks the button, open the modal 
  btn.onclick = function() {
    popup.style.display = "block";
  }

  // When the user clicks on <span> (x), close the modal
  span.onclick = function() {
    popup.style.display = "none";
  }

  // When the user clicks anywhere outside of the modal, close it
  window.onclick = function(event) {
    if (event.target == popup) {
      popup.style.display = "none";
    }
  }
</script>

</body>
</html>    