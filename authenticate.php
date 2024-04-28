<?php
session_start();
require 'connect-db.php'; 

$email = $_POST['email'];
$password = $_POST['password'];

$query = "SELECT * FROM users WHERE email = :email";
$statement = $db->prepare($query);
$statement->bindValue(':email', $email);
$statement->execute();
$user = $statement->fetch(PDO::FETCH_ASSOC);
$statement->closeCursor();

if ($user && password_verify($password, $user['userPassword'])) {
    $_SESSION['user_logged_in'] = true;
    $_SESSION['user_id'] = $user['userId'];

   
    $adminQuery = "SELECT EXISTS (SELECT 1 FROM librarian WHERE userId = :userId)";
    $adminStmt = $db->prepare($adminQuery);
    $adminStmt->bindValue(':userId', $user['userId']);
    $adminStmt->execute();
    $isAdmin = $adminStmt->fetchColumn();  

    $adminStmt->closeCursor();

    if ($isAdmin) { //gives admin status session variable for the session
        $_SESSION['admin'] = true;
        header("Location: admin-dashboard.php");
    } else {
       
        header("Location: dashboard.php");
    }
    exit;
} else {

    header("Location: login.php?error=invalid");
    exit;
}
?>
