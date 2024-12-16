document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('popup-form');

    const customerNameInput = document.getElementById('customer-name');
    const customerPassInput = document.getElementById('customer-pass');
    let selectedAccountId = null; // Variable to store the selected account ID

    document.querySelectorAll('.open-modal-form').forEach(button => {
        button.addEventListener('click', (event) => {
            modal.style.display = 'block';
    
            // Get the accountId from the clicked button's data-id attribute
            selectedAccountId = event.target.closest('button').dataset.id;
    
            console.log(`Selected Account ID: ${selectedAccountId}`); // Debugging line
        });
    });

    window.addEventListener('click', (event) => {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });

    const customerEditForm = document.getElementById('customer-form');
    customerEditForm.addEventListener('submit', function (e) {
        e.preventDefault(); // Prevent normal form submission
    
        const formData = new FormData(customerEditForm); // Create FormData object from the form
    
        // Append the selected account ID to the form data
        formData.append('accountId', selectedAccountId);
    
        // Send the form data using fetch (AJAX request)
        fetch('/PHP/customer_edit.php', {
            method: 'POST',
            body: formData
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Network response was not ok: ${response.statusText}`);
                }
                const contentType = response.headers.get("Content-Type");
                if (contentType) {
                    return response.json();
                } else {
                    throw new Error("Invalid JSON response from server");
                }
            })
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    location.reload();
                }
            })
            .catch(error => {
                console.log('Error while accessing the script', error);
            });
    });
});