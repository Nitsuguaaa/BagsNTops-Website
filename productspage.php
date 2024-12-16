<?php 
session_start();

echo "<script>console.log('current session in index: ". $_SESSION['loggedIn'] ."');</script>";
//echo "<script>console.log('current account in index: ". $_SESSION['currentAccount'] ."');</script>";

include_once('./PHP/db_functions.php');
include_once('./PHP/id_functions.php');
include_once('./PHP/pw_functions.php');
include_once('./PHP/product_db.php');
include_once('./PHP/view_cart.php')
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/CSS/productspage.css">
    <title>Shop | Bags N' Tops</title>
</head>
<body>
    <div id="logout-screen">
        <div id="logout-box">
            <button id="logoutBtn">→ Log Out</button>
        </div>    
    </div>
    <div id="top-bar">
        <div id="top-bar-1">
            <section id="tb-1-title">Bags N' Tops</section>
        </div>
        <div class="top-bar-2">
            <ul class="nav-bar">
                <li><a href="index.php">Home</a></li>
                <li><a href="productspage.php">Shop</a></li>
                <li><a href="index.php#three">About Us</a></li>
            </ul>
        </div>
        <div class="top-bar-3">
            <ul class="nav-bar-2">
                <li><button id="loginBtn"><img src="./RSC/nav-bar-icons/person-icon-pink.png" alt="" width="25px" height="25px" style="margin:0px;padding-top:11px;padding-left:5px;"></button></li>
                <li><button id="cart-button"><img src="RSC/nav-bar-icons/bag-icon-pink.png" width="25px" height="25px" style="margin:0px;padding-top:11px;padding-left:5px;"></button></li>
            </ul>
        </div>
    </div>

    <div id="login-form" class="modal-bg">
        <div class="form-box animate">
            <div class="button-box">
                <div id="btn"></div>
                <button type="button" class="toggle-btn" onclick="loginAnimate()">Log In</button>
                <button type="button" class="toggle-btn" onclick="signupAnimate()">Sign Up</button>
            </div>
            <form id="loginForm" class="input-group" method="POST">
                <label>Email</label>
                <input type="email" class="input-field" name="loginEmail" id="loginEmail" autocomplete="email" required>
                <label>Password</label>
                <input type="password" class="input-field" name="loginPassword" id="loginPassword" autocomplete="current-password" required>
                <button type="submit" class="submit-btn">LOGIN</button>
            </form>
            <form id="signupForm" class="input-group">
                <label>Name</label>
                <input type="text" class="input-field"  id="signupName" name="signupName"  required>
                <label>Email</label>
                <input type="email" class="input-field" id="signupEmail" name="signupEmail" autocomplete="email"  required>
                <label>Password</label>
                <input type="password" class="input-field" id="signupPassword" name="signupPassword" autocomplete="new-password" required>
                <label>Confirm Password</label>
                <input type="password" class="input-field" id="signupConfirmPassword" name="signupConfirmPassword" autocomplete="new-password" required>
                <button type="submit" class="submit-btn">Create</button>
            </form>
        </div>
    </div>

    <script src="./JS/login-animations.js"></script>
    <script src="./JS/login-script.js"></script>
    <script src="./JS/signup-script.js"></script>

    <div id="main-content">
        <div id="mc-left">
            <hr id="top-hr">
            <div id="prod-container">
                <div id="products-grid">
                    <?php load_products()?>
                </div>
                <div id="prod-overview">
                    <div id="prod-overview-text">
                        <div id="image-left">
                            <img src="./RSC/products-img/image1.png" alt="" id="productImage">
                        </div>
                        <div class="content-right">
                            <span id="productName">Name of the Item</span><br>
                            <span id="productPrice">Price</span><br>
                            <span id="productStock">Stock</span><br><br><br>
                            <span id="productDescription">Lorem ipsum dolor sit amet consectetur.</span>
                        </div>
                    </div>
                    <div id="prod-add-cart-btns">
                        <button class="add-crt-btn" product-id="">Add to Cart</button>
                        <div id="item-ctr">
                            <span class="minus">-</span>
                            <span class="num">01</span>
                            <span class="plus">+</span>
                        </div>
                    </div>
                </div>
            </div>
            <hr id="top-hr">
        </div>
        <div id="mc-right">
            <img src="RSC/home-page/front-2-img.png" alt="" width="790px" height="820px">
        </div>
    </div>

    <div id="show-cart" class="temp-modal-bg">
        <div class="cart-box">
            <div class="top-head">
                <header>
                    Your Cart <br>
                    <span>Customer Details</span>
                </header>
                <form id="check-out-form" name="check-out-form">
                    <div class='form-row'><label>Name: <b><?php get_my_name() ?></b></label></div>
                    <div class='form-row'><label id="check-out-label">Address: </label>
                    <textarea id="check-out-textarea" name="check-out-address" form="check-out-form" style="resize: none;" required></textarea></div>
                    <div class='form-row'><label id="check-out-label">Contact: </label>
                    <input id="check-out-input" name="check-out-contact" type="tel" placeholder="e.g.(09345762664)" required/></div>
                </form>
            </div>
            
            <div id='table-container'>
            <table border="1" id="details-table">
                <thead>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th></th>
                </thead>
                <tbody>
                    <?php load_my_cart() ?>
                </tbody>
            </table></div>
            <div id='bottom-area'>
            <div id="total-price"><b><?php get_my_total_cart_price() ?></b></div>
            <button id="check-out-btn" type="submit" form="check-out-form">Check out</button></div>
            
            
        </div>
    </div>

    <div><?php include_once('./PHP/confirmation_modal.php') ?></div>
    <script src="./JS/confirmation-script.js"></script>
    <script src="./JS/product-overview.js"></script>

    



</body>
</html>