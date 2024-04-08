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
