let a = 1;
let currentProductId;

const plus = document.querySelector(".plus");
minus = document.querySelector(".minus");
num = document.querySelector(".num");

plus.addEventListener("click", () => {
    a++;
    a = (a < 10) ? "0" + a : a;
    num.innerText = a;
});

minus.addEventListener("click", () => {
    if (a > 1) {
        a--;
        a = (a < 10) ? "0" + a : a;
        num.innerText = a;
    }
});

/*document.getElementById('add-crt-btn').addEventListener('click', function(event) {
    alert('yes you clicked me');
})*/

document.addEventListener('DOMContentLoaded', () => {
    const productButtons = document.querySelectorAll('#product-card');
    const prodOverview = document.getElementById('prod-overview');
    const productsGrid = document.getElementById('products-grid');
    const addToCartButtons = document.querySelectorAll('.add-crt-btn');

    productButtons.forEach(button => {
        button.addEventListener('click', () => {
            // Get the product ID from the clicked button
            const productId = button.getAttribute('product-id');
            currentProductId = productId;
            let productStock = button.getAttribute('product-stock')
            const productName = button.querySelector('h2').innerText;
            let productPrice = button.querySelector('p').innerText;


            fetch(`PRODUCTS/${productId}/description.json`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Description not found');
                    }
                    return response.json(); // Parse the JSON file
                })
                .then(descriptionData => {
                    // Assuming the JSON structure has a "description" field
                    const productDescription = descriptionData.description;

                    // Update prod-overview content dynamically
                    document.getElementById('productImage').src = "../PRODUCTS/" + productId + "/product_img.png";
                    document.querySelector('#productName').innerText = productName;
                    document.querySelector('#productPrice').innerText = productPrice.replace('Price: ', '').trim();
                    document.querySelector('#productStock').innerText = "In Stock: " + productStock;
                    document.querySelector('#productDescription').innerText = productDescription || `No description available for product ${productId}`;

                })
                .catch(error => {
                    console.error('Error fetching description:', error);
                    // Handle the error (e.g., display a default message)
                    document.querySelector('#prod-overview p').innerText = `Description not available for product ${productId}`;
                });

            productsGrid.style.display = 'none';
            prodOverview.classList.add('active'); // Show #prod-overview
            productsGrid.style.opacity = 0.5; // Dim the grid for focus

        });
    });

    // Optional: Add a close button or click outside to close
    prodOverview.addEventListener('click', (e) => {
        if (e.target === prodOverview) { // Close only when clicking outside
            a = 1;
            num.innerText = "0" + a;
            productsGrid.style.display = 'grid';
            prodOverview.classList.remove('active'); // Hide #prod-overview
            productsGrid.style.opacity = 1; // Restore grid opacity
            currentProductId = '';
        }
    });

    addToCartButtons.forEach(button => {
        button.addEventListener('click', () => {
            let listData = {
                productID: currentProductId,
                productQuantity: parseInt(a)
            };

            fetch('/PHP/add_to_cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    product: listData
                })
            })
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        alert(result.message);
                        location.reload();
                    } else {
                        alert(result.message);
                    }
                })
        });
    });

    window.addEventListener('click', function (e) {
        const showCart = document.getElementById('show-cart');
        const cartButton = document.getElementById('cart-button');
        const cartBox = document.querySelector('.cart-box');


        if (showCart.contains(e.target) && !cartBox.contains(e.target)) {
            showCart.style.display = "none";
        } else if (cartButton.contains(e.target)) {
            fetch('/PHP/current_account_checker.php', {
                method: 'GET', // GET since we're just checking the session
            })
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        showCart.style.display = "block";
                        //alert("WHAT THE FU-");
                    } else {
                        alert("you need to login first!");
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                });
        }
    });

    document.getElementById('check-out-form').addEventListener('submit', function (e) {
        e.preventDefault(); // Prevent the default form submission behavior
    
        const formData = new FormData(this); // Get form data
        
        fetch('/PHP/check_out_functions.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            const contentType = response.headers.get("Content-Type");
            if (contentType && contentType.includes("application/json")) {
                return response.json();
            } else {
                throw new Error("Invalid JSON response from server");
            }
        })
        .then(data => {
            if (data.success) {
                alert(data.message);  
                location.reload();
            } else {
                alert(data.message || "Checkout failed. Please try again.");
            }
        })
        .catch(error => {
            console.error("Error:", error);
        });
    });

    /*document.getElementById('check-out-form').addEventListener('submit', function(e) {
        fetch('/PHP/check_out_functions.php', {
            method: 'POST',
            body: dataForm
        })
        .then(response => {
            const contentType = response.headers.get("Content-Type");
            if (contentType) {
                return response.json();
            } else {
                throw new Error("Invalid JSON response from server");
            }
        })
        .then(data => {
            console.log("Response data:", data);
            if (data.success) {
                alert(data.message);  
            } else {
                console.log("Login failed:", data.message);
            }
        })
        .catch(error => {
            console.error("Error:", error);
        });
    })*/
});
