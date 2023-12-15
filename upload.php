<?php
$sectionToShow = isset($_GET['section']) ? $_GET['section'] : 'signin';
$error = isset($_GET['error']) ? $_GET['error'] : '';

include_once 'header.php';
// Check if the user is logged in
if (!isset($_SESSION["userid"])) {
    header("location: index.php");
    exit();
}
?>
       <!-- HTML form for file upload -->
       <section class="upload-form">
        <h2>File Upload</h2>

        <!-- Display error messages, if any -->
        <?php if (!empty($error)) : ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>

        <!-- Form for file upload -->
        <form action="includes/upload.inc.php" method="post" enctype="multipart/form-data">
            <!-- Move label for file input above the button -->
            <label for="file">Choose a file to upload:</label>
            <input type="file" name="file" id="file" required>
            <label for="title">Title:</label>
            <input type="text" name="title" id="title" placeholder="Title" required>

            <button type="submit" name="submit">Upload</button>
        </form>
    </section>
</body>
</html>

