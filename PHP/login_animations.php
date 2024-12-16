<?php
session_start();



if($_SESSION['loggedIn'] == 'yes') {
    $isLogged = true;
} else if($_SESSION['loggedIn'] == 'no') {
    $isLogged = false;
}

$result = array(
    'isLogged' => $isLogged,
    'currentSession' => $_SESSION['loggedIn']
);

header('Content-Type: application/json');

echo json_encode($result);
?>