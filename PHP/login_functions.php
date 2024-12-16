<?php
session_start();

include_once('db_functions.php');
include_once('pw_functions.php');

//check if fields are complete
if (!isset($_POST['loginEmail'], $_POST['loginPassword'])) {
    finalCommand(false, "Missing Fields");
}

$userEmail = filter_var($_POST['loginEmail'], FILTER_SANITIZE_EMAIL);
$userPassword = $_POST['loginPassword'];

$selectData = new select('accountstb');
$passwordChecker = new passwordGeneration();
//finalCommand(false, "hey I caught you ;)");
//array
$result = $selectData->selectData('accountPassword, accountId', "WHERE accountEmail = '{$userEmail}'");

//bool
$correctPassword = $passwordChecker->decodePassword($userPassword, $result[0]['accountId']);

//check if user exists
if (!$result || count($result) === 0) {
    finalCommand(false, "User not found");
}

//check if password is correct
if ($correctPassword) {
    if($result[0]['accountId'] == "AD-0000") {
        finalCommand(true, "admin.login");
    } else {
        $_SESSION["loggedIn"] = "yes";
        $_SESSION["currentAccount"] = $result[0]['accountId'];
        finalCommand(true, "Login Successful");
    }

} else {
    finalCommand(false, "invalid password");
}

function finalCommand(bool $successData,string $messageData) {
    ob_clean();
    header('Content-Type: application/json');

    echo json_encode(['success' => $successData, 'message' => $messageData]);
    exit;
}

exit;