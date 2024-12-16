<?php
//include_once('db_functions.php');

function load_products()
{
    $selectData = new select('productstb');
    $resultArray = $selectData->selectData();

    if (count($resultArray) > 0) {
        foreach ($resultArray as $result) {
            echo "<div id='product-card' product-id='{$result['productId']}' product-stock='{$result['productStock']}'>";
            echo "<img src='PRODUCTS/" . $result['productId'] . "/product_img.png' alt='" . $result['productName'] . "' class='product-image'>";
            echo "<h2>" . $result['productName'] . "</h2>";
            echo "<p>Price: ₱" . $result['productPrice'] . "</p>";
            echo "</div>";
        }
    } else {
        echo "fetch error";
    }
}

?>