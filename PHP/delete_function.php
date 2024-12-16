<?php
session_start();

include_once('db_functions.php');

$deleteAccount = new delete('accountstb');
$deleteProduct = new delete('productstb');
$deleteTransaction = new delete('transactionstb');

// Retrieve the passed data
$value = $_POST['value'];
$actionType = $_POST['actionType'];

// Perform actions based on the actionType
switch($actionType) {
    case 'delete-product':
        $deleteProduct->deleteData('productId', $value);
        if(file_exists("../PRODUCTS/{$value}/description.json")) {
            unlink("../PRODUCTS/{$value}/description.json");
        }
        if(file_exists("../PRODUCTS/{$value}/product_img.png")) {
            unlink("../PRODUCTS/{$value}/product_img.png");
        }
        rmdir("../PRODUCTS/{$value}");
        finalCommand(true, 'deleted product PHP');
        break;
    case 'delete-user':
        $deleteAccount->deleteData('accountId', $value);
        $_SESSION['loggedIn'] = "no";
        unset($_SESSION['currentAccount']);
        finalCommand(true, 'deleted user PHP');
        break;
    case 'delete-transaction':
        $deleteTransaction->deleteData('transactionId', $value);
        finalCommand(true, 'deleted transaction PHP');
        break;
    case 'remove-cart-item':
        
        $cartFilePath = '../RSC/carts/' . $_SESSION['currentAccount'] . '.json'; // Adjust the path as needed
        
        
            $cartData = json_decode(file_get_contents($cartFilePath), true);

            $cartData['items'] = array_filter($cartData['items'], function ($item) use ($value) {
                return $item['productID'] !== $value; // Keep items that do not match the productID
            });

            // Re-index the array to prevent issues with non-contiguous keys
            $cartData['items'] = array_values($cartData['items']);

            // Write the updated cart data back to the JSON file
            file_put_contents($cartFilePath, json_encode($cartData, JSON_PRETTY_PRINT));
            finalCommand(true, 'removed item from cart PHP');
        break;
}

function finalCommand(bool $successData, $messageData) {
    ob_clean();
    header('Content-Type: application/json');

    echo json_encode(['success' => $successData, 'message' => $messageData]);
    exit;
}
?>