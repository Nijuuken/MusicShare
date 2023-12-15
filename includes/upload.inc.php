<?php
session_start();
if (isset($_POST["submit"]) && isset($_SESSION["userid"])) {
    require_once 'db.inc.php';
    require_once 'functions.inc.php';

    // Get the name of the uploaded file
    $fileName = $_FILES['file']['name'];
    $fileTitle = isset($_POST['title']) ? $_POST['title'] : '';
    sendFiletoDB($conn,$fileName,$fileTitle);

} else {
    header("location: ../index.php");
    exit();
}
