<?php
session_start();
require 'connect-db.php';

// Validate and sanitize inputs (basic examples, adapt as needed)
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$password = $_POST['password']; // Should be hashed before storing
$firstName = filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_STRING);
$lastName = filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_STRING);

echo "Email: $email <br>";
echo "Password: $password <br>"; // Remember, this is just for debugging!
echo "First Name: $firstName <br>";
echo "Last Name: $lastName <br>";

// Hash the password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
echo "Hashed Password: $hashedPassword <br>";

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
    echo "User registered successfully.<br>";
    // Debug: Comment the redirect to see the debug output
    // header("Location: user_authenticated.php");
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "<br>";
    // Debug: Comment the redirect to see the debug output
    // header("Location: signup.php?error=signupfailed");
    // exit;
}
?>
