<?php
session_start();
require 'connect-db.php';

// Validate and sanitize inputs (basic examples, adapt as needed)
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$password = $_POST['password']; // Should be hashed before storing
$firstName = filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_STRING);
$lastName = filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_STRING);

// Hash the password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Insert query
$query = "INSERT INTO users (email, userPassword, firstName, lastName) VALUES (:email, :userPassword, :firstName, :lastName)";
$statement = $db->prepare($query);
$statement->bindValue(':email', $email);
$statement->bindValue(':userPassword', $hashedPassword);
$statement->bindValue(':firstName', $firstName);
$statement->bindValue(':lastName', $lastName);

try {
    $statement->execute();
    $statement->closeCursor();
    // echo "User registered successfully.<br>";
  
    header("Location: login.php");
} catch (PDOException $e) {
    // echo "Error: " . $e->getMessage() . "<br>";
    
    header("Location: signup.php?error=signupfailed");
    exit;
}
?>
