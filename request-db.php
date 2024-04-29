<?php
function addBooks($bookName, $author, $totalQuantity, $numCheckedOut, $coverImagePath, $rating, $category, $issued)
{
    global $db;
    $query = "INSERT INTO books (bookName, author, totalQuantity, numCheckedOut, coverImagePath, rating, category, issued) VALUES (:bookName, :author, :totalQuantity, :numCheckedOut, :coverImagePath, :rating, :category, :issued)";

    try {
        $statement = $db->prepare($query);

        $statement->bindValue(':bookName', $bookName);
        $statement->bindValue(':author', $author);
        $statement->bindValue(':totalQuantity', $totalQuantity);
        $statement->bindValue(':numCheckedOut', $numCheckedOut);
        $statement->bindValue(':coverImagePath', $coverImagePath);
        $statement->bindValue(':rating', $rating);
        $statement->bindValue(':category', $category);
        $statement->bindValue(':issued', $issued);

        $statement->execute();
        $statement->closeCursor();

    } catch (PDOException $e) {
        $e->getMessage();
    } catch (Exception $e) {
        $e->getMessage();   
    }
}

function getAllBooks()
{
    global $db;
    $query = "select * from books";
    $statement = $db->prepare($query);  // compile
    $statement->execute();
    $result = $statement->fetchAll();    // fetch()
    $statement->closeCursor();

    return $result;
}

function getBookById($id)  
{
    global $db;
    $query = "select * from books where bookId=:bookId";
    $statement = $db->prepare($query);
    $statement->bindValue(':bookId', $id);
    $statement->execute();
    $result = $statement->fetchAll();
    $statement->closeCursor();

    return $result;
}

function getBookByFields($bookName, $author, $totalQuantity, $rating, $category)  
{
    global $db;
    $query = "select * from books where 1=1"; // Basic query with always-true condition for easier appending
    $author_name1 = "";
    $author_name2 = "";

    // Directly append conditions and parameters for non-empty fields
    if (!empty($bookName)) {
        $query .= " and bookName like :bookName";
    }
    if (!empty($author)) {
        if ($author == trim($author) && strpos($author, ' ') !== false) {
            $author_arr = explode(" ", $author);
            $author_name1 = $author_arr[0];
            $author_name2 = $author_arr[1];
            $query .= " and author like :authorname1 and author like :authorname2";
        } else {
            $query .= " and author like :author";
        }
    }
    if (!empty($totalQuantity)) {
        $query .= " and totalQuantity = :totalQuantity";
    }
    if (!empty($rating)) {
        $query .= " and rating = :rating";
    }
    if (!empty($category)) {
        $query .= " and category like :category";
    }

    $statement = $db->prepare($query);

    // Conditionally bind parameters
    if (!empty($bookName)) {
        $statement->bindValue(':bookName', "%$bookName%");
    }
    if ($author == trim($author) && strpos($author, ' ') !== false) {
        if (!empty($author_name1)) {
            $statement->bindValue(':authorname1', "%$author_name1%");
        }
        if (!empty($author_name2)) {
            $statement->bindValue(':authorname2', "%$author_name2%");
        }
    } else {
        if (!empty($author)) {
            $statement->bindValue(':author', "%$author%");
        }
    }
    if (!empty($totalQuantity)) {
        $statement->bindValue(':totalQuantity', $totalQuantity, PDO::PARAM_INT);
    }
    if (!empty($rating)) {
        $statement->bindValue(':rating', $rating);
    }
    if (!empty($category)) {
        $statement->bindValue(':category', "%$category%");
    }

    try {
        $statement->execute();
        $results = $statement->fetchAll();
        $statement->closeCursor();
        return $results;
    } catch (PDOException $e) {
        die($e->getMessage());
    }
}

function updateBook($bookName, $author, $totalQuantity, $numCheckedOut, $coverImagePath, $rating, $category, $issued)
{
    global $db;
    $query = "update books set bookName=:bookName, author=:author, totalQuantity=:totalQuantity, numCheckedOut=:numCheckedOut, coverImagePath=:coverImagePath, rating=:rating, category=:category, issued=:issued where bookId=:bookId";
    $statement = $db->prepare($query);
    $statement->bindValue(':bookId', $bookId);
    $statement->bindValue(':bookName', $bookName);
    $statement->bindValue(':author', $author);
    $statement->bindValue(':totalQuantity', $totalQuantity);
    $statement->bindValue(':numCheckedOut', $numCheckedOut);
    $statement->bindValue(':coverImagePath', $coverImagePath);
    $statement->bindValue(':rating', $rating);
    $statement->bindValue(':category', $category);
    $statement->bindValue(':issued', $issued);

    $statement->execute();
    $statement->closeCursor();
}

function deleteBook($userId, $bookId)
{
    global $db;
    $deleteQuery = "DELETE FROM books WHERE bookId=:bookId;";
    $deleteStatement = $db->prepare($deleteQuery);
    $deleteStatement->bindValue(':bookId', $bookId);
    $deleteStatement->execute();
    $deleteStatement->closeCursor();
}

function deleteUpdateLog($userId, $bookId)  
{
    global $db;
    $query = "INSERT INTO deleteupdatelogs (userId, bookId, modifyDate) VALUES (:userId, :bookId, CURDATE());";
    $statement = $db->prepare($query);
    $statement->bindValue(':userId', $userId);
    $statement->bindValue(':bookId', $bookId);
    $statement->execute();
    $statement->closeCursor();
}

function validateAmountCheckedOut($bookId) // check to see if user can checkout book
{
    global $db;
    $query = "select totalQuantity, numCheckedOut from books where bookId=:bookId";
    $statement = $db->prepare($query);
    $statement->bindValue(':bookId', $bookId);

    try {
        $statement->execute();
        $results = $statement->fetchAll();
        $statement->closeCursor();
        return $results;
    } catch (PDOException $e) {
        die($e->getMessage());
    }
}

function checkoutBook($bookId, $userId, $newCheckoutNum)
{
    global $db;
    
    // open transaction
    $db->beginTransaction();
    
    try {
        // Update the numCheckedOut value
        $updateQuery = "update books set numCheckedOut=:numCheckout where bookId=:bookId";
        $updateStatement = $db->prepare($updateQuery);
        $updateStatement->bindValue(':numCheckout', $newCheckoutNum);
        $updateStatement->bindValue(':bookId', $bookId);
        $updateStatement->execute();
        
        // create checkout entry
        $insertQuery = "insert into checkouts (userId, bookId, checkoutDate) values (:userId, :bookId, CURDATE())";
        $insertStatement = $db->prepare($insertQuery);
        $insertStatement->bindValue(':bookId', $bookId);
        $insertStatement->bindValue(':userId', $userId);
        $insertStatement->execute();
        
        // commit transaction
        $db->commit();
        $updateStatement->closeCursor();
        $insertStatement->closeCursor();
        return 1;
    } catch (PDOException $e) {
        $db->rollBack();
        return 0;
    }
}
?>

<script>
function clearForm() {
    document.getElementById('requestedDate').value = '';
    document.getElementById('roomNo').value = '';
    document.getElementById('requestedBy').value = '';
    document.getElementById('requestDesc').value = '';
    document.getElementById('priority_option').selectedIndex = 0;
}
</script>
