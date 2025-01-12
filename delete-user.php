<?php
include 'connection.php'; // Include the database connection file

// Check if the request method is POST and the user_id is provided
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
    $user_id = intval($_POST['user_id']); // Sanitize user_id input

    // Prepare the DELETE query
    $sql = "DELETE FROM users WHERE user_id = ?";
    $stmt = $con->prepare($sql);

    // Check if the statement preparation was successful
    if ($stmt) {
        $stmt->bind_param("i", $user_id); // Bind the user_id parameter

        if ($stmt->execute()) {
            // Set session variable for success
            session_start();
            $_SESSION['delete_success'] = true;
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close(); // Close the prepared statement
    } else {
        $message = "Failed to prepare statement";
    }
} else {
    $message = "Invalid request";
}


// Close the database connection
$con->close();

// Redirect back to the admin page with the message
header("Location: admin.php?message=" . urlencode($message));
exit(); // Ensure script execution stops here
?>