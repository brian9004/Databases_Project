<?php
session_start();
require 'connect-db.php';

$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$password = $_POST['password']; 
$firstName = filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_STRING);
$lastName = filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_STRING);


$hashedPassword = password_hash($password, PASSWORD_DEFAULT);


$query = "INSERT INTO users (email, userPassword, firstName, lastName) VALUES (:email, :userPassword, :firstName, :lastName)";
$statement = $db->prepare($query);
$statement->bindValue(':email', $email);
$statement->bindValue(':userPassword', $hashedPassword);
$statement->bindValue(':firstName', $firstName);
$statement->bindValue(':lastName', $lastName);

try {
    $db->beginTransaction(); // Start transaction

    $statement->execute();
    $userId = $db->lastInsertId(); // Retrieves the last inserted ID, which is the userId

    // Insert userId, email, firstName, and lastName into the 'student' table
    $queryStudent = "INSERT INTO student (userId, email, firstName, lastName) VALUES (:userId, :email, :firstName, :lastName)";
    $statementStudent = $db->prepare($queryStudent);
    $statementStudent->bindValue(':userId', $userId);
    $statementStudent->bindValue(':email', $email);
    $statementStudent->bindValue(':firstName', $firstName);
    $statementStudent->bindValue(':lastName', $lastName);
    $statementStudent->execute();

    $db->commit(); // Commit the transaction

    $statement->closeCursor();
    $statementStudent->closeCursor();
    header("Location: login.php");
} catch (PDOException $e) {

    header("Location: signup.php?error=signupfailed");
    exit;
}
?>
