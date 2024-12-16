document.addEventListener('DOMContentLoaded', () => {
    // Select all delete buttons by a generic class (you can adjust it for any button you need)
    const deleteButtons = document.querySelectorAll('.delete-button');
    const confirmationScreen = document.querySelector('#confirmation-screen');
    const confirmationBox = document.querySelector('#confirmation-box');
    const yesButton = document.getElementById('yes-btn');
    const noButton = document.getElementById('no-btn');

    let currentValue = ''; // Store the value (e.g., ID) of the item to be deleted
    let currentActionType = ''; // Store the action type (e.g., "delete-user")

    // Event delegation for delete buttons
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.stopPropagation();  // Stop event propagation to prevent closing the modal unintentionally

            currentValue = button.getAttribute('value'); // Get the product ID (or any relevant data)
            currentActionType = button.getAttribute('actionType');
            console.log("Preparing to delete:", currentValue);  // Log for debugging

            // Show the confirmation modal
            confirmationScreen.style.display = "block";  
        });
    });

    // Close the confirmation screen if clicked outside the confirmation box
    window.addEventListener('click', function(e) {
        if (confirmationScreen.contains(e.target) && !confirmationBox.contains(e.target)) {
            confirmationScreen.style.display = "none";  // Close the modal if clicked outside
        }
    });

    // Event listener for the "Yes" button (to confirm deletion)
    yesButton.addEventListener('click', function() {
        // Call the function to delete the item
        deleteData(currentValue, currentActionType);
        confirmationScreen.style.display = "none";  // Close the confirmation modal after confirming
    });

    // Event listener for the "No" button (to cancel deletion)
    noButton.addEventListener('click', function() {
        confirmationScreen.style.display = "none";  // Simply close the modal without deleting
    });

    // Function to delete data
    function deleteData(value, actionType) {
        // Create a FormData object to send the data
        const formData = new FormData();
        formData.append('value', value);
        formData.append('actionType', actionType);

        // Send the data to the appropriate PHP script using fetch
        fetch('/PHP/delete_function.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())  // Assuming the server responds with JSON
        .then(data => {
            console.log(data);
            if (data.success) {
                alert('Successfully deleted');
                location.reload();
                // Optionally, update the UI or remove the element from the page
            } else {
                alert('Failed to delete');
            }
        })
        .catch(error => {
            console.error('Error during fetch:', error);
        });
    }
});