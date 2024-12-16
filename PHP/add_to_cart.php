<?php
session_start();

$input = file_get_contents('php://input');
$data = json_decode($input, true);

if(is_null($_SESSION['currentAccount'])) {
    finalCommand(false, 'you need to login first!');
}

$accountId = $_SESSION['currentAccount'];
$filePath = '../RSC/carts/'.$accountId.'.json';

// Fetch existing cart or create a new one
$cart = [];
if (file_exists($filePath)) {
    $cart = json_decode(file_get_contents($filePath), true);
}

$productFound = false;
foreach ($cart['items'] as &$item) {
    if ($item['productID'] === $data['product']['productID']) {
        // Product found, update the quantity
        $item['productQuantity'] += $data['product']['productQuantity'];
        $productFound = true;
        break;
    }
}

// If the product wasn't found, add it as a new product
if (!$productFound) {
    $cart['items'][] = $data['product'];
}

if (file_put_contents($filePath, json_encode($cart, JSON_PRETTY_PRINT))) {
    finalCommand(true, "Products have been added!");
} else {
    $error = error_get_last();
    finalCommand(false, "Failed to add the products: ".$error['message']);
}

function finalCommand(bool $successData,string $messageData) {
    ob_clean();
    header('Content-Type: application/json');

    echo json_encode(['success' => $successData, 'message' => $messageData]);
    exit;
}
?>