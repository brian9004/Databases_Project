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
        $books = getBookById(11);
    }
}
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
    <img src="images/logo-db.jpg" alt="Library Logo">
  </div>
  <span>CATALOG</span>
  <div class="search-container">
    <input type="text" placeholder="Search...">
    <button style=filter:invert(100%) type="submit"><img src="images/magnifying_glass.png" alt="Search"></button>
    <button id="filter"><img src="images/filter.png" alt="Search"></button>
  </div>
  <div class="menu">
    <button onclick="window.location.href='home.php'">Home</button>
    <button onclick="window.location.href='books.php'">Books</button>
    <button onclick="window.location.href='login.php'">Login</button>
    <div class="signup">
      <button onclick="window.location.href='signup.php'">Sign Up</button>
    </div>
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
      <input type="checkbox" id="issued" name="issued"> <label for="issued">Issued</label><br>
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

  // Optional: Function to handle form submission
  document.getElementById("searchForm").onsubmit = function(event) {
    event.preventDefault(); // Prevent page reload on form submit
    var formData = {
      bookName: document.getElementById("bookName").value,
      author: document.getElementById("author").value,
      totalQuantity: document.getElementById("totalQuantity").value,
      rating: document.getElementById("rating").value,
      category: document.getElementById("category").value,
      issued: document.getElementById("issued").checked,
    };
    // You can now use `formData` to filter your book data
    console.log(formData);
  };
</script>

</body>
</html>    