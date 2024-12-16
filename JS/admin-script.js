document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('popup-form');

    const productNameInput = document.getElementById('product-name');
    const productStockInput = document.getElementById('product-stock');
    const productPriceInput = document.getElementById('product-price');
    const productDescriptionInput = document.getElementById('product-description');
    const actionTypeInput = document.getElementById('action-type');  // Hidden input for action type
    const productIdInput = document.getElementById('product-id-store');


    document.querySelectorAll('.open-modal-form').forEach(button => {
        button.addEventListener('click', () => {
            const actionType = button.getAttribute('action-type');
            actionTypeInput.value = actionType;

            if (actionType === 'new-product') {
                document.getElementById('product-id-holder').style.display = "none";
                productNameInput.value = '';
                productStockInput.value = '';
                productPriceInput.value = '';
                productDescriptionInput.value = '';
            } else if (actionType === 'edit-product') {

                let descriptions = {}; // Variable to store the JSON data

                // Fetch the JSON file
                fetch("../PRODUCTS/" + button.getAttribute('product-id') + "/description.json")
                    .then(response => response.json())
                    .then(data => {
                        descriptions = data; // Store the data in the variable
                        const productDescription = descriptions['description'] || 'No description available'; // Fetch description
                        productDescriptionInput.value = productDescription;
                    })
                    .catch(error => console.error('Error loading descriptions:', error));


                document.getElementById('product-id-holder').style.display = "grid";
                document.getElementById('product-id-holder').innerHTML = "&emsp;&emsp;&emsp;&emsp;#" + button.getAttribute('product-id');
                const productName = button.getAttribute('product-name');
                const productStock = button.getAttribute('product-stock');
                const productPrice = button.getAttribute('product-price');
                const productId = button.getAttribute('product-id');

                productNameInput.value = productName;
                productStockInput.value = productStock;
                productPriceInput.value = productPrice;
                productIdInput.value = productId;
            }

            modal.style.display = 'block';
        });
    });

    window.addEventListener('click', (event) => {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });

    // Listen for form submission
    const productForm = document.getElementById('prod-input-group');
    productForm.addEventListener('submit', function (event) {
        event.preventDefault();  // Prevent normal form submission

        const formData = new FormData(productForm); // Create FormData object from the form

        // Send the form data using fetch (AJAX request)
        fetch('/PHP/admin_product_upload.php', {
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
                if(data.success) {
                    alert(data.message);
                    location.reload();
                }
            })
            .catch(error => {
                console.log('error while accessing the script');
            });
    });


});