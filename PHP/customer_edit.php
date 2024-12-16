<?php
include_once('db_functions.php');
include_once('pw_functions.php');

$editData = new update('accountstb');
$changePw = new passwordGeneration();

if (!isset($_POST['accountId'])) {
    finalCommand(false, 'Account ID is missing');
}

$accountId = $_POST['accountId'];

// Only update AccountName if it's not empty
if (isset($_POST['customer-name']) && !empty($_POST['customer-name'])) {
    $editData->updateData('AccountName', $_POST['customer-name'], 'AccountId', $accountId); 
}

// Only update AccountPassword if it's not empty
if (isset($_POST['customer-pass']) && !empty($_POST['customer-pass'])) {
    $newPw = $changePw->encodePassword($_POST['customer-pass']);
    $editData->updateData('AccountPassword', $newPw, 'AccountId', $accountId); 
}


finalCommand(true, 'Account successfully updated');

finalCommand(true, 'account successfully updated');

function finalCommand(bool $successData,string $messageData) {
    ob_clean();
    header('Content-Type: application/json');

    echo json_encode(['success' => $successData, 'message' => $messageData]);
    exit;
}
?>