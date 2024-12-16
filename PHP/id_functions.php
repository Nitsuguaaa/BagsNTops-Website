<?php
//require('./db_functions.php');

class IDGenerator {
    function duplicateChecker($uniqueID, $table, $IDType) {
        $selectData = new select($table);
        $result = $selectData->selectData($IDType, "WHERE {$IDType} = '{$uniqueID}'");
        if(empty($result) === true) { 
            //echo 'UNIQUE';
            return true; 
        } else { 
            //echo 'DUPLICATE';
            return false; 
        }
    }

    function generateAccountID() {
        $uniqueID = 'UI-'.rand(1000,9999);
        $isDup = $this->duplicateChecker($uniqueID, 'accountstb', 'accountId');
        if($isDup === true) { 
            return $uniqueID; 
        } else { 
            $this->generateAccountID();
        }
    }

    function generateProductID() {
        $uniqueID = 'PD-'.rand(1000,9999);
        $isDup = $this->duplicateChecker($uniqueID, 'productstb', 'productId');
        if($isDup === true) { 
            return $uniqueID; 
        } else { 
            $this->generateProductID();
        }
    }

    function generateTransactionID() {
        $uniqueID = 'TR-'.rand(1000,9999);
        $isDup = $this->duplicateChecker($uniqueID, 'transactionstb', 'transactionId');
        if($isDup === true) { 
            return $uniqueID; 
        } else { 
            $this->generateTransactionID();
        }
    }
}
?>