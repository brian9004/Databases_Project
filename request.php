<?php
require("connect-db.php");
require("header.php");
?>

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

<?php include('footer.html') ?> 