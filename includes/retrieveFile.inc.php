<?php

    $fileName = $_POST['filename'];
    require_once 'db.inc.php';
    require_once 'functions.inc.php';

    // Call the retrieveFile function and get the result
    $retrievedFile = retrieveFile($conn, $fileName);
    $assocArraytoJson = json_encode($retrievedFile);
    error_log("Error Log in inc dawfrawtfawwtratfaw");
    error_log(print_r($retrievedFile,true));
    // Output the information as JSON
    echo $assocArraytoJson;
