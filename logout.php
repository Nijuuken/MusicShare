<?php
include_once 'header.php';
$logoutMessage = "Logged Out | You have been successfully logged out. Please click <a href='authForm.php?section=signin' style='color: orange;'>here</a> to login.";
$_SESSION = array();
session_destroy();
?>

    <div class="logout-message"><?php echo $logoutMessage; ?></div>
</body>
</html>
