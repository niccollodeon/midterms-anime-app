<?php
session_start();
include('connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $anime_id = $_POST['anime_id'];
    $new_category = $_POST['watchlist-s'];

    if ($anime_id && $new_category) {
        $stmt = $con->prepare("UPDATE anime SET categories = ? WHERE anime_id = ?");
        $stmt->bind_param("si", $new_category, $anime_id);

        if ($stmt->execute()) {
            $_SESSION['update_success'] = "Anime category updated successfully!";
        } else {
            $_SESSION['update_error'] = "Failed to update anime category.";
        }

        $stmt->close();
    }
}

header("Location: index.php");
exit();
?>