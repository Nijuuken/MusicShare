<?php
// function emptyInputSignup($username, $email, $pwd, $pwdConfirm){
//     $result;
//     if (empty($username) || empty($email) || empty($pwd) || empty($pwdConfirm)){
//         $result = true;
//     } else {
//         $result = false;
//     }
//     return $result;
// }

function invalidUsername($username){
    $result;
    if (!preg_match("/^[a-zA-Z0-9]*$/", $username)){
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function invalidEmail($email){
    $result;
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}


function pwdMatch($pwd, $pwdConfirm){
    $result;
    if ($pwd !== $pwdConfirm){
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function existsUsername($conn, $username){
    $sql = "SELECT * FROM userdb WHERE username = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt,$sql)){
        header("location: ../authForm.php?section=signup?error=stmtfailedusr");
        exit(); 
    }
    mysqli_stmt_bind_param($stmt,"s", $username);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if($row = mysqli_fetch_assoc($resultData)){
        return $row;
    } else {
        $result = false;
        return $result;
    }
    mysqli_stmt_close($stmt);
}

function existsEmail($conn, $email){
    $sql = "SELECT * FROM userdb WHERE userEmail = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt,$sql)){
        header("location: ../authForm.php?section=signup?error=stmtfailedusr");
        exit(); 
    }
    mysqli_stmt_bind_param($stmt,"s", $email);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if($row = mysqli_fetch_assoc($resultData)){
        return $row;
    } else {
        $result = false;
        return $result;
    }
    mysqli_stmt_close($stmt);
}

function pwdLongEnough($pwd){
    if (strlen($pwd) < 6) {
        return true;
    } else {
        return false;
    }
}

function createUser($conn, $username, $email, $pwd){
    $sql = "INSERT INTO userdb (username, userEmail, userPassword) VALUES (?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt,$sql)){
        header("location: ../authForm.php?section=signup?error=stmtfailedcreateusr");
        exit(); 
    }
    $pwdHashed = password_hash($pwd,PASSWORD_DEFAULT);
    mysqli_stmt_bind_param($stmt,"sss", $username, $email, $pwdHashed);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../authForm.php?section=signin&error=none");

}

function loginUser($conn,$username, $pwd) {
    if(!existsEmail($conn,$username) && !existsUsername($conn,$username)){
        header("location: ../authForm.php?section=signin&error=wronglogin");
        exit();
    } else {
        // Assuming existsEmail and existsUsername return an associative array on success
        if ($existsEmailResult = existsEmail($conn, $username)) {
            $userExists = $existsEmailResult;
        } elseif ($existsUsernameResult = existsUsername($conn, $username)) {
            $userExists = $existsUsernameResult;
        }

        $pwdHashed = $userExists["userPassword"];
        $checkPwd = password_verify($pwd,$pwdHashed);

        if (!$checkPwd){
            header("location: ../authForm.php?section=signin&error=wrongpwd");
            exit();
        }
        else if ($checkPwd === true){
            session_start();
            $_SESSION["userid"] = $userExists["userID"];
            $_SESSION["username"] = $userExists["username"];
            $_SESSION["userEmail"] = $userExists["userEmail"];
            header("location: ../index.php");
            exit();
        }
    }
}

function sendFileToDB($conn,$filename){
    function generateRandomString($length = 10) {
        return bin2hex(random_bytes(($length + 1) / 2));
    }

    // Example: Generate a random string of length 8
    $randomString = generateRandomString(12);

    // Extract the file extension
    $fileExtension = pathinfo($filename, PATHINFO_EXTENSION);

    // Generate a new filename with the random string and original file extension
    $newFilename = $randomString . '.' . $fileExtension;
    
    // Specify the destination path with the new filename
    $location = "../upload/" . $newFilename;

    // Save the uploaded file to the local filesystem
    if (move_uploaded_file($_FILES['file']['tmp_name'], $location)) {
        echo '<p>File uploaded successfully</p>';
        
        $sql = "INSERT INTO user_files (userID, originalFileName, storedFileName) VALUES (?, ?, ?);";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt,$sql)){
            header("location: ../authForm.php?section=signup?error=stmtfailedcreateusr");
            exit(); 
        }
        mysqli_stmt_bind_param($stmt,"iss", $_SESSION["userid"], $filename, $newFilename);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);


    } else {
        echo '<p>File upload failed!</p>';
        if ($_FILES['file']['error'] > 0) {
            echo '<p>File upload failed with error code ' . $_FILES['file']['error'] . '</p>';
        }
    }
}

// functions.inc.php

function retrieveFile($conn, $fileName) {
    $result = array();

    // Prepare and execute the query to retrieve file information
    $stmt = mysqli_prepare($conn, 
    "SELECT user_files.fileID, user_files.originalFileName, user_files.storedFileName, user_files.uploadDate, userdb.username 
    FROM user_files 
    INNER JOIN userdb ON user_files.userID = userdb.userID 
    WHERE user_files.storedFileName = ?");
    mysqli_stmt_bind_param($stmt, "s", $fileName);
    mysqli_stmt_execute($stmt);
    $queryResult = mysqli_stmt_get_result($stmt);

    // Fetch the result into an associative array
    $row = mysqli_fetch_assoc($queryResult);

    if(empty($row)){
        error_log("Error Log in inc------------------------------");
        error_log("row in functions.inc.php is empty! ");

        error_log("File name: " . $fileName);
        error_log("Error Log in inc------------------------------");
    }
    

    // Echo the originalFileName for debugging
    echo "Original FileName: " . $row['originalFileName'];

    // Store the result in the $result array
    if ($row) {
        $result['fileID'] = $row['fileID'];
        $result['originalFileName'] = $row['originalFileName'];
        $result['storedFileName'] = $row['storedFileName'];
        $result['uploadDate'] = $row['uploadDate'];
        $result['username'] = $row['username'];
    }

    // Close the statement
    mysqli_stmt_close($stmt);
    header('Content-Type: application/json');
    return $result;
}
