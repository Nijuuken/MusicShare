<?php 
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign In - Task Management</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/authForm.css">
    <link rel="stylesheet" href="css/logout.css">
    <link rel="stylesheet" href="css/header.css">
</head>
<body>
    <header class="white-header">
        <h1 id="white-header-title">MusicShare | Share your music</h1>
        <div class="header-links">
        <?php
            if(isset($_SESSION["userid"])){
                echo '<a href="profile.php">' . $_SESSION["username"] . '</a>';
                echo '<a href="logout.php">Log Out</a>';
            } else {
                echo '<a href="authForm.php?section=signin">Login</a>';
                echo '<a href="authForm.php?section=signup">Sign up</a>';
            }
        ?>             
        </div>
    </header>
    <div class="wrapper">
