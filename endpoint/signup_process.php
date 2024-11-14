<?php
include 'conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the username already exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo "Username already exists. Please choose a different one.";
    } else {
        // Insert the new user with the plain-text password
        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);

        if ($stmt->execute()) {
            echo "Signup successful! You can now log in.";
            // Optionally redirect to the login page
            header("Location: ../index.php");
            exit();
        } else {
            echo "Error: Could not sign up. Please try again.";
        }
    }
}
?>