<?php
$username = isset($_GET['user']) ? $_GET['user'] : 'username';
include_once 'header.php';
?>

<script>
    var username = <?php echo json_encode($username); ?>;
    var sessionUsername = '<?php echo $_SESSION["username"]; ?>';
</script>

<section class="upload-box">
    <h1 id="userName"><?php echo htmlspecialchars($username); ?></h2>
    <?php if ($username == $_SESSION["username"]) : ?>
            <a href="upload.php"><button type="button">Upload</button></a>
        <?php endif; ?>
    <h2>Uploads:</h2>

    <ul>
        <li id="uploadsList">
            <!-- Magic Happens Here-->
        </li>
    </ul>
    <script src="js/profile.js"></script>
    <!-- Trigger the retrieveFile function when the page loads -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        getFiles('<?php echo $username; ?>', ); // Pass $fileName as an argument
    });
</script>
</section>

</body>
</html>
