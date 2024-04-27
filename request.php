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
    $html .= "</div>";
    $html .= "</div>"; // end modal-body
    $html .= "<div class='modal-footer'>";
    $html .= "<button type='button' class='btn btn-danger' data-bs-dismiss='modal'>Delete Book</button>";
    $html .= "<button type='button' onclick='closeModal(\"modal{$book['bookId']}\")' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>";
    $html .= "</div>"; // end modal-footer
    $html .= "</div>"; // end modal-content
    $html .= "</div>"; // end modal-dialog
    $html .= "</div>"; // end modal
    return $html;
}
?>
<!--     
    $html = "<div class='modal' id='modal{$book['bookId']}' style='display:none; position: fixed; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 100;'>";
    $html .= "<div style='background-color: white; margin: 10% auto; padding: 20px; width: 50%;'>";
    $html .= "<h2>" . htmlspecialchars($book['bookName']) . "</h2>";
    $html .= "<p>Author: " . htmlspecialchars($book['author']) . "</p>";
    $html .= "<p>Category: " . htmlspecialchars($book['category']) . "</p>";
    $html .= "<button onclick='closeModal(\"modal{$book['bookId']}\")'>Close</button>";
    $html .= "</div></div>";
    return $html;
 -->

<body>
<div class="container mt-4">
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

    function deleteButton(modalId) {
        
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

<?php include('footer.html') ?> 