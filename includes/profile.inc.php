<?php
    $username = $_GET['username'];
    require_once 'db.inc.php';
    require_once 'functions.inc.php';
    // Call the retrieveFile function and get the result
    $retrievedFiles = retrieveFiles($conn, $username);
    $assocArraytoJson = json_encode($retrievedFiles);
    // error_log(print_r($retrievedFiles,true));
    // error_log($assocArraytoJson);
    // Output the information as JSON
    echo $assocArraytoJson;