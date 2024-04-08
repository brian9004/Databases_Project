<?php
session_start();
require 'connect-db.php'; // Make sure this path is correct

$email = $_POST['email'];
$password = $_POST['password'];

// Query to find the user by email
$query = "SELECT * FROM users WHERE email = :email";
$statement = $db->prepare($query);
$statement->bindValue(':email', $email);
$statement->execute();
$user = $statement->fetch(PDO::FETCH_ASSOC);
$statement->closeCursor();


if ($email && $password == $user['userPassword']) {
    
    $_SESSION['user_logged_in'] = true;
    $_SESSION['user_id'] = $user['userId'];
    header("Location: dashboard.php"); //change this to logged in user view
    exit;
} else {

    header("Location: login.php?error=invalid");

    exit;
}
?>
