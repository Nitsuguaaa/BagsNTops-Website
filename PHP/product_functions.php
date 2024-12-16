<?php
session_start();

// Read JSON data from POST body
$inputData = file_get_contents('php://input');
$data = json_decode($inputData, true);  // Decode the JSON data into a PHP array

$isItLogged;
// Do something with the data, for example, print it
$isLogged = $_SESSION['loggedIn'];
if($isLogged == "no" || !isset($_SESSION['loggedIn'])) {
    $isItLogged = false;
} else {
    $isItLogged = true;
    //remember to add after cart added
}

$response = [
    'isItLogged' => $isItLogged,
];

// Send a JSON response back to JavaScript
header('Content-Type: application/json');
echo json_encode($response);

?>