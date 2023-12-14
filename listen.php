<?php
$fileName = isset($_GET['v']) ? $_GET['v'] : '';
$error = isset($_GET['error']) ? $_GET['error'] : '';

// Redirect to index.php if $fileName is empty
if (empty($fileName)) {
    header("Location: index.php");
    exit();
}
?>

<?php
include_once 'header.php';
?>

<script src="js/listen.js"></script>

<audio preload="none" controls>
    <source id="audioSource" type="audio/mp3">
</audio>

<!-- Trigger the retrieveFile function when the page loads -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        retrieveFile('<?php echo $fileName; ?>'); // Pass $fileName as an argument
    });
</script>