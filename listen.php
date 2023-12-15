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

<section id="listen-form" class="centered-content">
    <p class="listenTitle">This is some descriptive text about the audio:</p>
    <p class="listenSubText">This is another line of text below the title.</p>
    <audio preload="none" id="myAudio" controls=""></audio>
    <button id="playButton">Download</button>
</section>

<!-- Trigger the retrieveFile function when the page loads -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        retrieveFile('<?php echo $fileName; ?>'); // Pass $fileName as an argument
    });
</script>