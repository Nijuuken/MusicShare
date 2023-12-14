<?php

if (isset($_POST["submit"])) {
    
    $username = $_POST["username"];
    $email = $_POST["signupEmail"];
    $pwd = $_POST["signupPassword"];
    $pwdConfirm = $_POST["confirmPassword"];

    require_once 'db.inc.php';
    require_once 'functions.inc.php';

    // Should already be impossible to get to this point with empty fields
    // if (emptyInputSignup($username, $email, $pwd, $pwdConfirm) !== false){
    //     header("location: ../authForm.php?section=signup&error=emptyinput");
    //     exit();  
    // }
    if(invalidUsername($username) !== false){
        header("location: ../authForm.php?section=signup&error=invalidUsername");
        exit();  
    }
    // Should already be impossible to get to this point with an invalid Email field
    // if(invalidEmail($email) !== false){
    //     header("location: ../authForm.php?section=signup&error=invalidEmail");
    //     exit();  
    // }
    if(pwdMatch($pwd, $pwdConfirm) !== false){
        header("location: ../authForm.php?section=signup&error=pwdMismatch");
        exit();  
    }
    if(existsUsername($conn,$username) !== false){
        header("location: ../authForm.php?section=signup&error=takenUsername");
        exit();  
    }
    if(existsEmail($conn,$email) !== false){
        header("location: ../authForm.php?section=signup&error=takenEmail");
        exit();  
    }
    if(pwdLongEnough($pwd) !== false){
        header("location: ../authForm.php?section=signup&error=pwdLen");
        exit();  
    }

    createUser($conn, $username, $email, $pwd);

} else {
    header("location: ../authForm.php?section=signup");
    exit();
}