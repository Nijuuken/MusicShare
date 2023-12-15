<?php

    $fileName = $_GET['filename'];
    require_once 'db.inc.php';
    require_once 'functions.inc.php';
    // Call the retrieveFile function and get the result
    $retrievedFile = retrieveFile($conn, $fileName);
    $assocArraytoJson = json_encode($retrievedFile);
    // error_log(print_r($retrievedFile,true));
    // error_log($assocArraytoJson);
    // Output the information as JSON
    echo $assocArraytoJson;
