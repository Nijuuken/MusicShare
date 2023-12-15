// listen.js

function retrieveFile(fileName) {
    fetch('includes/retrieveFile.inc.php?filename=' + encodeURIComponent(fileName + ".mp3"), {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
        }
    })
    .then(response => {
            return response.json();
    })
    .then(fileInformation => {
        //  console.log(fileInformation);
        //  console.log('File ID:', fileInformation.fileID);
        //  console.log('Original File Name:', fileInformation.originalFileName);
        //  console.log('Stored File Name:', fileInformation.storedFileName);
        //  console.log('Upload Date:', fileInformation.uploadDate);
        //  console.log('Username:', fileInformation.username);
        
        const listenTitleElement = document.querySelector('.listenTitle');
        listenTitleElement.textContent = fileInformation.title;
        const listenSubText = document.querySelector('.listenSubText');
        listenSubText.textContent = 'Uploaded by: ' + fileInformation.username;
        console.log(fileInformation.title)
        const audioElement = document.getElementById('myAudio');
        audioElement.src = 'upload/' + fileInformation.storedFileName;
        audioElement.type = 'audio/mp3';

        playButton.addEventListener('click', function() {
            // Create a hidden anchor element
            const downloadLink = document.createElement('a');
            downloadLink.href = 'upload/' + fileInformation.storedFileName;
            downloadLink.download = fileInformation.originalFileName; // Set the filename for download

            // Append the anchor element to the document
            document.body.appendChild(downloadLink);

            // Trigger a click event on the anchor element
            downloadLink.click();

            // Remove the anchor element from the document
            document.body.removeChild(downloadLink);
        });
    })
    .then(id3Tags => {
        
    })
    .catch(error => {
        console.error('Error:', error);
    });
}
