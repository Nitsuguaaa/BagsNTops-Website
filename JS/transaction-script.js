document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('popup-form');

    document.querySelectorAll('.open-modal-form').forEach(button => {
        button.addEventListener('click', () => {
            // Get accountID and transactionID from button attributes
            const accountID = button.getAttribute('data-account-id');
            const transactionID = button.getAttribute('data-transaction-id');

            // Send data to PHP via POST
            fetch('/PHP/admin_receipt_functions.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ accountID, transactionID }) // Send both IDs
            })
                .then(response => response.json())  // Parse the JSON response
                .then(data => {
                    //console.log(data);  // Log the response for debugging

                    if (data.result) {
                        // Update the modal with the response data

                        const nameElement = modal.querySelector('.popup-name');
                        const addressElement = modal.querySelector('.popup-address');
                        const contactElement = modal.querySelector('.popup-contact');
                        const productTable = modal.querySelector('.popup-table-result');

                        if (nameElement && addressElement && contactElement) {
                            nameElement.innerHTML = `<b>Name: </b>${data.result.name}`;
                            addressElement.innerHTML = `<b>Address: </b>${data.result.address}`;
                            contactElement.innerHTML = `<b>Contact: </b>${data.result.contact}`;
                        }

                        data.result.products.forEach(element => {
                            //console.log(element);
                            productTable.innerHTML += `<tr><td>${element['productName']}</td><td>${element['productId']}</td><td>${element['productQuantity']}</td></tr>`;               
                        });

                        // Show the modal
                        modal.style.display = 'block';
                    } else {
                        console.error('Error: No result found in response');
                    }
                })
                .catch(error => {
                    console.error("Error fetching data:", error);
                });
        });
    });

    // Close modal when clicking outside of it
    window.addEventListener('click', (event) => {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });
});