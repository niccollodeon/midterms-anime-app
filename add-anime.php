<?php
session_start();
include('connection.php');

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: landing.php");
    exit();
}

// Get the logged-in user's username (or user_id if available)
$username = $_SESSION['username'];

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the anime name and category from the form
    $animeName = $_POST['animeName'];
    $category = $_POST['watchlist-s'];

    // Validate input
    if (empty($animeName)) {
        $_SESSION['error'] = "Anime name cannot be empty.";
        header("Location: index.php");
        exit();
    }

    // Prepare an SQL query to insert the data, including the user_id
    $sql = "INSERT INTO anime (title, categories, user_id) VALUES (?, ?, ?)";
    $stmt = $con->prepare($sql);

    // Get user_id based on the username (optional if you have user_id directly)
    $userQuery = "SELECT user_id FROM users WHERE username = ?";
    $userStmt = $con->prepare($userQuery);
    $userStmt->bind_param("s", $username);
    $userStmt->execute();
    $userResult = $userStmt->get_result();

    if ($userResult->num_rows > 0) {
        $user = $userResult->fetch_assoc();
        $userId = $user['user_id'];
    } else {
        $_SESSION['error'] = "User not found.";
        $userStmt->close();  // Close before header
        $stmt->close();      // Close before header
        $con->close();       // Close before header
        header("Location: index.php");
        exit();
    }

    // Bind parameters and execute the query
    $stmt->bind_param("sss", $animeName, $category, $userId);

    if ($stmt->execute()) {
        $_SESSION['add_success'] = "Anime added successfully!";
    } else {
        $_SESSION['error'] = "Failed to add anime. Please try again.";
    }

    // Close the statement and connection before redirect
    $stmt->close();
    $userStmt->close();
    $con->close();

    header("Location: index.php");
    exit();
}
?>