<?php
session_start(); // Start the session

// Include necessary files
@include_once(__DIR__ . '/../src/Helpers/Auth.php');
@include_once(__DIR__ . '/../src/Helpers/cart_stats.php');
@include_once(__DIR__ . '/src/Helpers/LoginAndOutHandler.php');

// Call the logout function if the request method is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    logout();
} else {
    // If the request method is not POST, redirect the user to the home page
    header('Location: index.php');
    exit();
}
?>
