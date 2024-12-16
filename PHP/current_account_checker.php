<?php
session_start();

if (isset($_SESSION['currentAccount'])) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}
?>