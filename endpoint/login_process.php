<?php
session_start();
include 'conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare and execute the SQL query using PDO
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    // Check if user exists
    if ($stmt->rowCount() == 1) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verify password
        // if (password_verify($password, $user['password'])) {
        //     // Store session data
        //     $_SESSION['username'] = $user['username'];
        //     header("Location: index.php"); // Redirect to a dashboard or home page
        //     exit();
        // } else {
        //     echo "Incorrect password.";
        // }
        if ($password === $user['password']) {
            // Store session data
            $_SESSION['username'] = $user['username'];
            header("Location: ../index.php"); // Redirect to a dashboard or home page
            exit();
        } else {
            echo "Incorrect password.";
        }
    } else {
        echo "User not found.";
    }
}
