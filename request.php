<?php
require("connect-db.php");
require("header.php");

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
    $html .= "<p><strong>Rating:</strong> " . htmlspecialchars(getRating($book['bookId'])) . "</p>";
    $html .= "</div>";
    $html .= "</div>"; // end modal-body
    $html .= "<div class='modal-footer'>";
    if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true) {
        $html .= "<form method='POST' action=''>";
        $html .= "<input type='hidden' name='checkoutBookId' value='{$book['bookId']}'>";    
        $html .= "<button type='submit' class='btn btn-success'>Checkout Book</button>";
        $html .= "</form>";
    }
    if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true && !isFavorited($book['bookId'], $_SESSION['user_id'])) {
        $html .= "<form method='POST' action=''>"; 
        $html .= "<input type='hidden' name='favoriteBook' value='{$book['bookId']}'>";    
        $html .= "<button type='submit' class='btn btn-info'>Favorite Book</button>";
        $html .= "</form>";
    }
    if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true && isFavorited($book['bookId'], $_SESSION['user_id'])) {
        $html .= "<form method='POST' action=''>";
        $html .= "<input type='hidden' name='unfavoriteBook' value='{$book['bookId']}'>";    
        $html .= "<button type='submit' class='btn btn-warning'>Un-Favorite Book</button>";
        $html .= "</form>";
    }
    if (isset($_SESSION['admin']) && $_SESSION['admin'] === true) {
        $html .= "<form method='POST' action=''>";
        $html .= "<input type='hidden' name='deleteBookId' value='{$book['bookId']}'>";    
        $html .= "<button type='submit' class='btn btn-danger'>Delete Book</button>";
        $html .= "</form>";
    }
    if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true && doesRatingExist($book['bookId'], clean($_SESSION['user_id'])) === false) {
        $html .= "<form method='POST' action=''>";
        $html .= "<input type='hidden' name='bookId' value='{$book['bookId']}'>";
        $html .= "<input type='text' class='me-2' name='rating' placeholder='Enter rating (integer 1-10)'>";
        $html .= "<button type='submit' class='btn btn-primary'>Submit</button>";
        $html .= "</form>";
    }
    $html .= "<button type='button' onclick='closeModal(\"modal{$book['bookId']}\")' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>";
    $html .= "</div>"; // end modal-footer
    $html .= "</div>"; // end modal-content
    $html .= "</div>"; // end modal-dialog
    $html .= "</div>"; // end modal
    return $html;
}

?>

<body>
<div class="container mt-4">
    <?php if ($bookDeleted): ?>
        <?php $bookDeleted = false; ?>
        <script>
            alert('The book has been successfully deleted.');
        </script>
    <?php endif; ?>

    <?php if ($checkoutMessage): ?>
        <?php if ($checkoutMessage == 1): ?>
            <script>
                alert('There are no copies of this book left to checkout. Please select another option.');
            </script>
        <?php elseif ($checkoutMessage == 2): ?>
            <script>
                alert('An error occurred, have you already checked this book out? Are you logged in?');
            </script>
        <?php elseif ($checkoutMessage == 3): ?>
            <script>
                alert('The book has been checked out successfully. Thank you.');
            </script>
        <?php endif; ?>
    <?php endif; ?>

    <?php if ($rateMessage): ?>
        <?php if ($rateMessage == 2): ?>
            <script>
                alert('Your rating was not an integer between 1 and 10. Try again.');
            </script>
        <?php elseif ($rateMessage == 1): ?>
            <script>
                alert('You successfully rated this book.');
            </script>
            <?php endif; ?>
    <?php endif; ?>

    <?php if ($favorited): ?>
        <?php $favorited = false; ?>
        <script>
            alert('The book has been favorited!');
        </script>
    <?php endif; ?>

    <?php if ($unfavorited): ?>
        <?php $unfavorited = false; ?>
        <script>
            alert('The book has been unfavorited!');
        </script>
    <?php endif; ?>

    <div class="row">
        <div class="col">
            <h2>Children's Library Catalog</h2>
            <div class="book-grid">
                <?php foreach ($books as $book): ?>
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
        </div>
    </div>
</div>

<script>
    function closeModal(modalId) {
        document.getElementById(modalId).style.display = 'none';
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

<?php include('footer.html') ?> 