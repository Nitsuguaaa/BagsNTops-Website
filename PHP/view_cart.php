<?php
//session_start();
include_once('./PHP/db_functions.php');

function load_my_cart()
{
    if(isset($_SESSION['cartTotalPrice'])) {
        unset($_SESSION['cartTotalPrice']);
    }
    if(!file_exists('./RSC/carts/'.$_SESSION['currentAccount'].'.json')) {
        echo '<div id="no-products">No products added to cart yet.</div>';
        return;
    }
    $jsonContent = file_get_contents('./RSC/carts/'.$_SESSION['currentAccount'].'.json');
    $resultArray = json_decode($jsonContent, true);
    $selectData = new select('productstb');
    $cartTotalPrice = 0;

    //print_r($resultArray);

    if (count($resultArray) > 0) {
        foreach ($resultArray as $result) {
            //print_r($result);
            foreach ($result as $r) {
                $result = $selectData->selectData("*", "WHERE productId = '{$r['productID']}'");
                $productTotalPrice = $result[0]['productPrice']*$r['productQuantity'];
                //print_r($result);
                echo "<tr><td>{$result[0]['productName']}</td>";
                echo "<td>{$r['productQuantity']}</td>";
                echo "<td>₱{$productTotalPrice}</td>";
                echo "<td><button id='action-btns' class='delete-button' actionType='remove-cart-item' value='{$r['productID']}'><img src='/RSC/admin-page-icons/delete-btn.png'></button></td></tr>";
                $cartTotalPrice += $productTotalPrice;
            }
            
            $_SESSION['cartTotalPrice'] = $cartTotalPrice;
        }
        
    } else {
        echo "fetch error";
    }
}

function get_my_name() {
    $selectData = new select('accountstb');
    $result = $selectData->selectData('accountName', "WHERE accountId = '{$_SESSION['currentAccount']}'");
    echo $result[0]['accountName'];
}

function get_my_total_cart_price() {
    if(isset($_SESSION['cartTotalPrice'])) {
        echo "Total Price: ₱".$_SESSION['cartTotalPrice'];
    }
}
?>