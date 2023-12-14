<?php
session_start();
if (isset($_POST["submit"]) && isset($_SESSION["userid"])) {
    require_once 'db.inc.php';
    require_once 'functions.inc.php';

    // Get the name of the uploaded file
    $fileName = $_FILES['file']['name'];
    
    sendFiletoDB($conn,$fileName);
  

} else {
    //header("location: ../authForm.php?section=signin&error=yaboi");
    //exit();
}
