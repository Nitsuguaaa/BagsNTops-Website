<?php
session_start();



if($_SESSION['loggedIn'] == 'yes') {
    $_SESSION['loggedIn'] = 'no';
    unset($_SESSION["currentAccount"]); 
}

$result = array(
    'loggedIn' => $_SESSION['loggedIn']
);

header('Content-Type: application/json');

echo json_encode($result);
?>