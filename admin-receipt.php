<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Log | Admin</title>
    <link rel="stylesheet" href="/CSS/admin.css">
</head>

<body>
    <div id="wrapper">
        <div id="sidebar">
            <h2>Admin.</h2>
            <ul>
                <li><a href="admin-receipt.php"><img src="/RSC/admin-page-icons/receipt.png">Transaction Log</a></li>
                <li><a href="admin-inventory.php"><img src="/RSC/admin-page-icons/inventory.png"></i>Inventory</a></li>
                <li><a href="admin-customers.php"><img src="/RSC/admin-page-icons/customers.png">User Management</a></li>
            </ul>
        </div>

        <div id="main">
            <header>
                <div id="pagetitle">Transaction Log</div>
            </header>
            <hr>
            <div id="main-content"></div>
            <table id="content-table" border="1">
                <thead>
                    <tr>
                        <th>Transaction ID</th>
                        <th>Customer Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include_once('./PHP/db_functions.php');
                    $selectTransaction = new select('transactionstb');
                    $selectAccount = new select('accountstb');
                    $result_array = $selectTransaction->selectData($column = 'DISTINCT transactionId, accountId, accountAddress, accountPNum');

                    for ($x = 0; $x < count($result_array); $x++) {
                        $result_array2 = $selectAccount->selectData('accountName', "WHERE accountId = '{$result_array[$x]['accountId']}'");
                        //print_r($result_array2);

                        echo "<tr>";
                        echo "<td style='text-align: center;'>" . $result_array[$x]["transactionId"] . "</td>";
                        echo "<td style='text-align: center;'>" . $result_array2[0]['accountName'] . "</td>";
                        echo "<td><button class='open-modal-form' id='action-btns' 
                            data-account-id='" . $result_array[$x]['accountId'] . "' 
                            data-transaction-id='" . $result_array[$x]['transactionId'] . "'>
                            <img src='/RSC/admin-page-icons/details-btn.png'></button>";
                        echo "<button class='delete-button' id='action-btns' actionType='delete-transaction' value='{$result_array[$x]["transactionId"]}'><img src='/RSC/admin-page-icons/delete-btn.png'></button></td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>


    <div id="popup-form" class="modal-bg">
        <div class="details-box animate">
            <div class="top-head">
                <header>Customer Details</header>
                <span class="popup-name">Name:</span>
                <br><span class="popup-address">Address:</span>
                <br><span class="popup-contact">Contact:</span>
            </div>

            <table border="1" id="details-table">
                <thead>
                    <th>Product Name</th>
                    <th>Product ID</th>
                    <th>Quantity</th>
                </thead>
                <tbody class="popup-table-result">
                    <!-- NASA JS FILE ANG TR AT TD -->
                </tbody>
            </table>

        </div>
    </div>
    <div><?php include_once('./PHP/confirmation_modal.php') ?></div>
    <script src="./JS/confirmation-script.js"></script>
    <script src="./JS/transaction-script.js"></script>

</body>

</html>