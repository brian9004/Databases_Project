<?php
function addBooks($bookName, $author, $totalQuantity, $numCheckedOut, $coverImagePath, $rating, $category, $issued)
{
    global $db;
    // $reqDate = date('Y-m-d');   // ensure proper data type before inserting it into a db
    // $query = "INSERT INTO requests (reqDate, roomNumber, reqBy, repairDesc, reqPriority) VALUES ('2024-03-18', 'CCC', 'Someone', 'fix light', 'medium')";
    // $query = "INSERT INTO requests (reqDate, roomNumber, reqBy, repairDesc, reqPriority) VALUES ('" . $reqDate . "', '" . $roomNumber . "', '" . $reqBy . "', '" . $repairDesc . "', '" . $reqPriority . "')";  
    $query = "INSERT INTO books (bookName, author, totalQuantity, numCheckedOut, coverImagePath, rating, category, issued) VALUES (:bookName, :author, :totalQuantity, :numCheckedOut, :coverImagePath, :rating, :category, :issued)";

    try {
        // #statement = $db->query($query); // compile & exe

        // prepared statement
        // pre-compile
        $statement = $db->prepare($query);

        // fill in the value
        $statement->bindValue(':bookName', $bookName);
        $statement->bindValue(':author', $author);
        $statement->bindValue(':totalQuantity', $totalQuantity);
        $statement->bindValue(':numCheckedOut', $numCheckedOut);
        $statement->bindValue(':coverImagePath', $coverImagePath);
        $statement->bindValue(':rating', $rating);
        $statement->bindValue(':category', $category);
        $statement->bindValue(':issued', $issued);
        // exe
        $statement->execute();
        $statement->closeCursor();

    } catch (PDOException $e) {
        $e->getMessage();
    } catch (Exception $e) {
        $e->getMessage();   // consider a generic message
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
    $result = $statement->fetch();
    $statement->closeCursor();

    return $result;
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

function deleteBook($bookId)
{
    global $db;
    $query = "delete from books where bookId=:bookId";
    $statement = $db->prepare($query);
    $statement->bindValue(':bookId', $bookId);
    $statement->execute();
    $statement->closeCursor();
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
