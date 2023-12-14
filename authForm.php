<?php
$sectionToShow = isset($_GET['section']) ? $_GET['section'] : 'signin';
$error = isset($_GET['error']) ? $_GET['error'] : '';
?>

<?php
include_once 'header.php';
if (isset($_SESSION["userid"])) {
    // User is already logged in
    header("HTTP/1.1 403 Forbidden");
    echo "Document Expired: You are already logged in.";
    exit();
}
?>

<div section class="form-container" id="signin-form" <?php echo ($sectionToShow === 'signin') ? '' : 'style="display: none;"'; ?>>
    <h2><strong>Sign In</strong></h2>

    <?php
    switch ($error) {
        case 'wronglogin':
            echo "<p class='error-message'>Login Failed. Incorrect Email or Username</p>";
            break;
        case 'wrongpwd':
            echo "<p class='error-message'>Login Failed. Incorrect Password.</p>";
            break;
        default:
            echo "<p class='error-message'>&nbsp;</p>"; // Default case
            break;
        }
    ?>
    
    <form action="includes/signin.inc.php" method="post">
        <input type="text" id="text" name="text" placeholder="Enter your username or email" required>
        <input type="password" id="password" name="password" placeholder="Enter your password" required>
        <button type="submit" name = "submit"><strong>Sign In</strong></button>
    </form>
    <a href="authForm.php?section=signup"><strong>Sign Up</strong></a>
</div>

<div section class="form-container" id="signup-form" <?php echo ($sectionToShow === 'signup') ? '' : 'style="display: none;"'; ?>>
    <h2><strong>Sign Up</strong></h2>
    <?php
    switch ($error) {
        case 'signup_failed':
            echo "<p class='error-message'>Failed to sign up. Please try again.</p>";
            break;
        case 'email_exists':
            echo "<p class='error-message'>The email address is already in use. Please choose a different one.</p>";
            break;
        case 'invalidEmail':
            echo "<p class='error-message'>Invalid email address format. Please enter a valid email.</p>";
            break;
        case 'pwdMismatch':
            echo "<p class='error-message'>Passwords do not match. Please ensure both passwords match.</p>";
            break;
        case 'takenUsername':
            echo "<p class='error-message'>Username is already taken. Please choose a different one.</p>";
            break;
        case 'takenEmail':
            echo "<p class='error-message'>Email address is already taken. Please choose a different one.</p>";
            break;
        case 'pwdLen':
            echo "<p class='error-message'>Password must be at least 6 characters long.</p>";
            break;
        case 'stmtfailedusr':
            echo "<p class='error-message'>An error occurred. Please try again later.</p>";
            break;
        case 'stmtfailedcreateusr':
            echo "<p class='error-message'>An error occurred while creating the user. Please try again later.</p>";
            break;
        default:
            echo "<p class='error-message'>&nbsp;</p>"; // Default case
            break;
        }
    ?>
    
    <form action="includes/signup.inc.php" method="post">
        <input type="text" id="username" name="username" placeholder="Username" required>
        <input type="email" id="signupEmail" name="signupEmail" placeholder="Enter your email" required>
        <input type="password" id="signupPassword" name="signupPassword" placeholder="Enter your password" required>  
        <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm your password" required>
        <button type="submit" name = "submit"><strong>Sign Up</strong></button>
    </form>
</div>
<!-- Possible Error Messages: error=invalidEmail error=pwdMismatch error=takenUsername 
takenEmail error=pwdLen -->

</div>
</body>
</html>
<script src="signin.js"></script>