<?php
include_once('db_functions.php');
include_once('id_functions.php');

$actionType = $_POST['action-type'];

$insertData = new insert('productstb');
//$selectData = new select('productstb');
$updateData = new update('productstb');
$generateId = new IDGenerator();

$productPrice = filter_var($_POST['product-price'], FILTER_VALIDATE_FLOAT);
$productQuantity = filter_var($_POST['product-stock'], FILTER_VALIDATE_INT);

switch($actionType) {
    case 'new-product':
        $newProductID = $generateId->generateProductID();

        $message = $insertData->insertData(['productId', 'productName', 'productPrice', 'productStock'], [$newProductID, $_POST['product-name'], $productPrice, $productQuantity]);

        mkdir('../PRODUCTS/' . $newProductID);
        $description = ['description' => $_POST['product-description']];
        $jsonEncodedData = json_encode($description);
        file_put_contents('../PRODUCTS/' . $newProductID . '/description.json' , $jsonEncodedData);

        uploadImage($newProductID);
        finalCommand(true, 'product has been added');
    exit;

    case 'edit-product':
        $productID = $_POST['product-id-store'];

        $updateData->updateData('productName', $_POST['product-name'], 'productId', $productID);
        $updateData->updateData('productPrice', $productPrice, 'productId', $productID);
        $updateData->updateData('productStock', $productQuantity, 'productId', $productID);
        
        $jsonData = file_get_contents('./PRODUCTS/' . $productID . '/description.json');
        $description = json_decode($jsonData, true);

        $description['description'] = $_POST['product-description'];

        $jsonEncodedData = json_encode($description);
        file_put_contents('../PRODUCTS/' . $productID . '/description.json' , $jsonEncodedData);

        uploadImage($productID); 
        finalCommand(true, 'product has been updated');
    exit;
}

exit;

// Image upload function
function uploadImage(?string $productID = null, $maxSize = 5 * 1024 * 1024, $allowedExtensions = ['png']) {
    if (isset($_FILES['product-image']) && $_FILES['product-image']['error'] == 0) {
        $file = $_FILES['product-image'];
        $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (in_array($fileExtension, $allowedExtensions) && $file['size'] <= $maxSize) {
            //$newFileName = '/product_img.' . $fileExtension;
            $uploadPath = '../PRODUCTS/'. $productID . '/product_img.' . $fileExtension;
            
            if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
                return true;  // Return true if successful
            } else {
                return false;  // Error while uploading
            }
        }
        return false;  // Invalid file type or size
    }
    return false;  // No file uploaded or error occurred
}

function isItNull() {

}

function finalCommand(bool $successData,string $messageData) {
    ob_clean();
    header('Content-Type: application/json');

    echo json_encode(['success' => $successData, 'message' => $messageData]);
    exit;
}
?>