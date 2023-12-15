//profile.js

function getFiles(userProfile){
    console.log("User: " , userProfile);
    username = userProfile;
    fetch('includes/profile.inc.php?username=' + username, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
        }
    })
    .then(response => {
        console.log(response);
        return response.json();
    })
    .then(data => {
        console.log(data);
         displayFiles(data);
    });
}

function displayFiles(data) {
    const uploadsList = document.getElementById('uploadsList');

    for (let i = 0; i < data.length; i++) {
        const currentItem = data[i];
    
        // Create a new container div for each entry
        const container = document.createElement('div');
        container.classList.add('upload-item'); // Add the new class
    
        // Create a new link element for each entry
        const link = document.createElement('a');
    
        // Set the href attribute of the link
        link.href = "listen.php?v=" + currentItem.storedFileName.replace(/\.mp3$/, '');
    
        // Set the text content of the link
        link.textContent = currentItem.title;
    
        // Append the link to the container
        container.appendChild(link);
    
        // Check if the current user is the owner before adding the delete button
        if (username === sessionUsername) {
            // Create a new button element for each entry
            const deleteButton = document.createElement('button');
    
            // Set the type attribute of the button
            deleteButton.type = 'button';
    
            // Set the text content of the button
            deleteButton.textContent = 'Delete';
    
            // Add a class to the delete button
            deleteButton.classList.add('delete-button');
    
            // Create a new link element for the delete button
            const deleteLink = document.createElement('a');
    
            // Set the href attribute of the delete link
            deleteLink.href = '#';  // You can set this to a valid URL if needed
    
            // Append the delete button to the delete link
            deleteLink.appendChild(deleteButton);

            deleteButton.addEventListener('click', function() {
                // Display a confirmation popup
                const isConfirmed = confirm('Are you sure you want to delete this?');

                // If the user confirms, proceed with the deletion
                if (isConfirmed) {
                    deleteFile(data[i].storedFileName);
                    console.log('Item deleted');
                }
            });

            // Append the delete link to the container
            container.appendChild(deleteLink);
        }
    
        // Append the container to the uploadsList
        uploadsList.appendChild(container);
    
        // Add a line break between containers
        uploadsList.appendChild(document.createElement('br'));
    }  
}

function deleteFile(storedFileName) {
    fetch('includes/retrieveFile.inc.php?filename=' + storedFileName), {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
        }
    }.then(response => {
        return response.text();
})
}