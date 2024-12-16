<?php
session_start();

include_once('db_functions.php');
include_once('id_functions.php');

$generateID = new IDGenerator();
$newTranId = $generateID->generateTransactionID();
$accountId = $_SESSION['currentAccount'];
$accountAddress = $_POST['check-out-address'];
$accountPNum = $_POST['check-out-contact'];

$userCart = "../RSC/carts/".$accountId.".json";
$json = file_get_contents($userCart);

$products = json_decode($json, true);

if(!isset($products)) {
    finalCommand(true, 'result is empty');
}

$insertData = new insert('transactionstb');

foreach($products as $result) {
    foreach($result as $r) {
        $insertData->insertData(['transactionId', 'accountId', 'productId', 'orderQuantity', 'accountAddress', 'accountPNum'],[$newTranId, $accountId, $r['productID'], $r['productQuantity'], $accountAddress, $accountPNum]);
    }
}

unlink("../RSC/carts/".$accountId.".json");

finalCommand(true, 'check out success!');

//finalCommand(true, $list);

function finalCommand(bool $successData, $messageData) {
    ob_clean();
    header('Content-Type: application/json');

    echo json_encode(['success' => $successData, 'message' => $messageData]);
    exit;
}

exit;
?>