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
  <title>Library Catalog</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="styles/db-project.css">
</head>

<body>
<div class="container mt-4">
    <div class="row">
        <div class="col">
            <h2>Children's Library Catalog</h2>
            <div class="book-grid">
                <?php foreach ($books as $book): ?>
                    <div class="book-item">
                        <img src="<?php echo htmlspecialchars($book['coverImagePath']); ?>" class="book-cover img-fluid">
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>