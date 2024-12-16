<?php
//include_once('./db_functions.php');

class passwordGeneration {
    function encodePassword($plain_password) {
        return password_hash($plain_password, PASSWORD_BCRYPT);
    }

    function decodePassword($plain_password, $accountId) {
        $selectData = new select('accountstb');
        $encoded_password = $selectData->selectData('accountPassword', "WHERE accountId = '{$accountId}'");
        $verification = password_verify($plain_password, $encoded_password[0]['accountPassword']);
        if($verification) {
            return true;
        } else {
            return false;
        }
    }
}
?>