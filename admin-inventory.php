<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory | Admin</title>
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
                <div id="pagetitle">Inventory</div>
            </header>   
            <hr>
            <div id="main-content"></div>
            <div id="btn">
                <button type="button" class="open-modal-form" id="add-btn" action-type="new-product">+ Product</button>
            </div>
                <table id="content-table" border="1">
                    <thead>
                        <tr>
                            <th>Product ID</th>
                            <th>Name</th>
                            <th>Stock</th>
                            <th>Price</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!--This part will get deleted-->
                            <?php
                            require('./PHP/db_functions.php');
                            $accSel = new select('productstb');
                            $result_array = $accSel->selectData($column='productId, productName, productPrice, productStock');

                            foreach($result_array as $product) {
                                echo "<tr>";
                                echo "<td>".$product["productId"]."</td>";
                                echo "<td>".$product["productName"]."</td>";
                                echo "<td>".$product["productStock"]."</td>";
                                echo "<td>".$product["productPrice"]."</td>";
                                echo "<td><button class='open-modal-form' id='action-btns' action-type='edit-product' product-id='{$product['productId']}' product-name='{$product['productName']}' product-price='{$product['productPrice']}' product-stock='{$product['productStock']}'><img src='/RSC/admin-page-icons/edit-btn.png'></button>";
                                echo "<button id='action-btns' class='delete-button' actionType='delete-product' value='{$product['productId']}'><img src='/RSC/admin-page-icons/delete-btn.png'></button></td>";
                                echo "</tr>";
                            }
                            ?>
                        <!--This part will get deleted-->
                    </tbody>
                </table>
        </div>
    </div>

    <div id="popup-form" class="modal-bg">
        <div class="product-details-box animate">
            <form class="prod-input-group" id="prod-input-group" enctype="multipart/form-data">
                <input type="hidden" id="action-type" name="action-type" value="">
                <input type="hidden" id="product-id-store" name="product-id-store" value="">

                <label id="product-id-holder">test</label>
                <label id="label-holder">Product Name:</label>
                <input type="text" id="product-name" name="product-name" class="cs-input-field" >
                <br>
                <label id="label-holder">Price:</label>
                <input type="number" id="product-price" name="product-price" class="cs-input-field" >
                <br>
                <label id="label-holder">Description:</label>
                <textarea form="prod-input-group" id="product-description" name="product-description" class="cs-input-field"></textarea>
                <br>
                <label id="label-holder" style="margin-top: 13px;">Quantity:</label>
                <input type="number" id="product-stock" name="product-stock" class="cs-input-field" >
                <br>
                <label id="label-holder">Image:</label>
                <input type="file" class="form-image" name="product-image" accept="image/*">
                <button type="submit" class="submit-btn">Done</button>
            </form>
        </div>
    </div>

    <div><?php include_once('./PHP/confirmation_modal.php') ?></div>
    <script src="./JS/confirmation-script.js"></script>
    <script src="./JS/admin-script.js"></script>
</body>
</html>