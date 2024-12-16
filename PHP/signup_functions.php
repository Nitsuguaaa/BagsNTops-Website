<?php
session_start();

include_once('db_functions.php');
include_once('pw_functions.php');
include_once('id_functions.php');

// Ensure the user input is validated before querying the database
if (!isset($_POST['signupName'], $_POST['signupEmail'], $_POST['signupPassword'], $_POST['signupConfirmPassword'])) {
    finalCommand(false, "Missing fields");
}

$userName = $_POST['signupName'];
$userEmail = filter_var($_POST['signupEmail'], FILTER_SANITIZE_EMAIL);
$userPassword = $_POST['signupPassowrd'];


// Initiate classes
$selectData = new select('accountstb');
$insertData = new insert('accountstb');


$passwordChecker = new passwordGeneration();
$generateId = new IDGenerator(); 
//finalCommand(false, "hey I caught you ;)");



// Get query of accountEmail
$result = $selectData->selectData('accountEmail, accountId', "WHERE accountEmail = '{$userEmail}'");


// If account exists return false
if ($result || count($result) > 0) {
    finalCommand(false, "Email already exists");
}

//Password and confirm password don't match
if ($_POST['signupPassword'] !== $_POST['signupConfirmPassword']) {
    finalCommand(false, "Password and confirm password don't match");
}

//generate new ID and encrypt password
$newUserId = $generateId->generateAccountID();
$encryptedPassword = $passwordChecker->encodePassword($_POST['signupPassword']);

//insert new account data
$insertData->insertData(['accountId', 'accountName', 'accountEmail', 'accountPassword'],[$newUserId, $userName, $userEmail, $encryptedPassword]);

//account created and auto login new user
$_SESSION["loggedIn"] = "yes";
$_SESSION["currentAccount"] = $result[0]['accountId'];
finalCommand(true, 'Account successfully created!');

function finalCommand($successData, $messageData) {
    ob_clean();
    header('Content-Type: application/json');

    echo json_encode(['success' => $successData, 'message' => $messageData]);
    exit;
}

exit;