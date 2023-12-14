// listen.js

function retrieveFile(fileName) {
    fetch('includes/retrieveFile.inc.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            submit: '1',
            filename: fileName + ".mp3", // Concatenate ".mp3" here
        }),
    })
    .then(response => {
        console.log("Response",response);
        //return response.json()
    })
    .then(fileInformation => {
        // Assign the retrieved information to fileInformation
        // Use the file information as needed (e.g., display it on the page)
        console.log(fileInformation);
        console.log('File ID:', fileInformation.fileID);
        console.log('Original File Name:', fileInformation.originalFileName);
        console.log('Stored File Name:', fileInformation.storedFileName);
        console.log('Upload Date:', fileInformation.uploadDate);
        console.log('Username:', fileInformation.username);
        // Set the source of the audio element dynamically
        const audioSource = document.getElementById('audioSource');
        audioSource.src = 'upload/' + fileInformation.storedFileName;
    })
    .catch(error => {
        console.log(response)
        console.error('Error:', error);
    });
}
