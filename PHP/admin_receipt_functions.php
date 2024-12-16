<?php
session_start();
include_once('./db_functions.php');

// Get the raw POST data and decode it
$input = json_decode(file_get_contents('php://input'), true);

if (isset($input['accountID']) && isset($input['transactionID'])) {
    $accountID = $input['accountID'];
    $transactionID = $input['transactionID'];

    $selectAccount = new select('accountstb');
    $selectTransaction = new select('transactionstb');
    $selectProduct = new select('productstb');

    // Fetch account details
    $accountArray = $selectAccount->selectData("accountName", "WHERE accountId = '{$accountID}'");

    //finalCommand($accountArray);

    // Fetch transaction details (if needed)
    $transactionArray = $selectTransaction->selectData("*", "WHERE transactionId = '{$transactionID}'");

    $productList = [];
    
    foreach($transactionArray as $transaction) {
        $information = [];
        $productResult = $selectProduct->selectData("productName", "WHERE productId = '{$transaction['productId']}'");
        $productName = $productResult[0]['productName'];
        $productId = $transaction['productId'];
        $productQuantity = $transaction['orderQuantity'];

        $information['productName'] = $productName; 
        $information['productId'] = $productId;
        $information['productQuantity'] = $productQuantity;

        $productList[] = $information;
    }

    // Check if the account was found
    if (!empty($accountArray)) {
        $data = [
            'name' => $accountArray[0]['accountName'] ?? 'N/A',
            'address' => $transactionArray[0]['accountAddress'] ?? 'N/A',
            'contact' => $transactionArray[0]['accountPNum'] ?? 'N/A',
            'products' => $productList
        ];

        // Send back the data as JSON
        finalCommand($data);
    } else {
        // Account not found
        finalCommand(['error' => "Account not found."]);
    }
} else {
    // Missing accountID or transactionID
    finalCommand(['error' => 'Missing accountID or transactionID.']);
}

// Send JSON response
function finalCommand($messageData) {
    ob_clean();
    header('Content-Type: application/json');
    echo json_encode(['result' => $messageData]);
    exit;
}
?>