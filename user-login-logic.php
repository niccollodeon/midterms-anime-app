<?php 
session_start(); // Start session to manage user session data
include "connection.php"; // Include file for database connection

// Check if username and password are submitted via POST
if (isset($_POST['username']) && isset($_POST['password'])) {
    
    // Function to sanitize and validate input data
    function validate($data) {
        $data = trim($data); // Remove whitespace from beginning and end
        $data = stripslashes($data); // Remove backslashes
        $data = htmlspecialchars($data); // Convert special characters to HTML entities
        return $data; // Return sanitized data
    }

    // Sanitize and validate username and password inputs
    $user = validate($_POST['username']);
    $pass = validate($_POST['password']);

    // Check if username is empty
    if (empty($user)) {
        header("Location: login.php?error=username is required");
        exit();
    } else if (empty($pass)) {
        header("Location: login.php?error=password is required");
        exit();
    }

    // SQL query to select user with matching username
    $sql = "SELECT * FROM users WHERE username = '$user'"; // Only check username first to avoid potential errors

    // Execute SQL query
    $result = mysqli_query($con, $sql);

    // Check if exactly one row is returned (indicating user exists)
    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result); // Fetch associative array of the user data

        // Use password_verify() to check if the entered password matches the stored hash
        if (password_verify($pass, $row['user_pass'])) {
            // Set session variables to store user data
            $_SESSION['username'] = $row['username'];
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['login_success'] = true; // Set login success flag

            // Redirect based on user account type
            if ($row['account_type'] === 'admin') {
                header("Location: admin.php"); // Redirect admin to admin page
            } else {
                header("Location: index.php"); // Redirect normal users to index page
            }
            exit(); // Stop further script execution
        } else {
            header("Location: login.php?error=Incorrect username or password");
            exit(); // Stop further script execution
        }
    } else {
        header("Location: login.php?error=Incorrect username or password");
        exit(); // Stop further script execution
    }
} else {
    header("Location: login.php?error=Both fields are required");
    exit(); // Stop further script execution
}
?>