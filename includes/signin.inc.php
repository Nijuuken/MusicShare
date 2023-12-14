<?php

if(isset($_POST["submit"])){

    $username = $_POST["text"];
    $pwd = $_POST["password"];

    require_once 'db.inc.php';
    require_once 'functions.inc.php';

    loginUser($conn, $username, $pwd);
} else {
    header("location: ../authForm.php?section=signin&error=yaboi");
    exit();
}