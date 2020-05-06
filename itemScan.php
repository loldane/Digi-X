<?php 
session_start();

$allProducstList = file_get_contents("productList.json");
$arrayAllProducstList = json_decode($allProducstList, true); // Convert to array 

$postItem = $_POST['SKU'];
$oneTime = false;  
if(!isset($_SESSION['allCartItem'])){
    $_SESSION['allCartItem'] = array();
}

    foreach ($arrayAllProducstList as $key => $value) {
        if ($value['productSKU'] == $postItem) {
           
            $selected_item = array(
                'productSKU'   => $value['productSKU'],
                'productName'   => $value['productName'],
                'productPrice'  => $value['productPrice'],
                'quantity'  => 1
            );  //create new record
            
            $resultKey = findKeyBySKU($postItem); //find key by SKU

            array_push($_SESSION['allCartItem'], $selected_item); // insert record into array


            if($value['productSKU'] == "ipd"){ //condition or business logic for ipd

               echo $newTotal = getQuantityBySKU($postItem);

                if($newTotal == 5){

                    $deductAmount = ($newTotal - 1) * 50;
                    $_SESSION['subTotal'] = $_SESSION['subTotal'] - $deductAmount;
                    
                }

                if($newTotal > 4){
                    $specialPrice = 499.99;
                    $_SESSION['subTotal'] =  $_SESSION['subTotal'] + $specialPrice;
                    changePriceTag($postItem);
                   
                }

                if($newTotal <= 4){

                    $_SESSION['subTotal'] =  $_SESSION['subTotal'] + $value['productPrice'];
                }
            }
            
            if($value['productSKU'] == "mbp"){//condition or business logic for mbp
                $selected_item = array(
                    'productSKU'   => 'vga',
                    'productName'   => 'VGA adapter (Bundle with MacBook)',
                    'productPrice'  => 0.00,
                    'totalPrice'    => $_SESSION['allCartItem'][$resultKey]['totalPrice'],
                    'quantity'  => 1
                );
                array_push($_SESSION['allCartItem'], $selected_item);
                $_SESSION['subTotal'] =  $_SESSION['subTotal'] + $value['productPrice'];
            }

            if($value['productSKU'] == "atv"){ //condition or business logic for atv 

                $_SESSION['subTotal'] = $_SESSION['subTotal'] + $value['productPrice'];

                $newTotal = getQuantityBySKU($postItem);

                if($newTotal %3 == 0){ //take every 3 records
                    $_SESSION['subTotal'] = $_SESSION['subTotal'] - $value['productPrice'];
                    $_SESSION['allCartItem'][$key]['productPrice'] = 0.00;
                }
               
            }

            if($value['productSKU'] == "vga"){ //condition or business logic for vga

                $_SESSION['subTotal'] = $_SESSION['subTotal'] + $value['productPrice'];
            }

 
        }
    }
function changePriceTag($postItem){
    foreach ($_SESSION['allCartItem'] as $key => $value) {
        if ($value['productSKU'] == $postItem) {
           echo  $_SESSION['allCartItem'][$key]['productPrice'] = 499.99;
        }
    }

}

function sumSubTotalPrice(){
    return array_column($_SESSION['allCartItem'], 'totalPrice');
}

function findKeyBySKU($postItem){
    foreach ($_SESSION['allCartItem'] as $key => $value) {
        if ($value['productSKU'] == $postItem) {
            return $key;
        }
    }
}

function getQuantityBySKU($postItem){
    $resultQuantity = 0;
    foreach ($_SESSION['allCartItem'] as $key => $value) {
        if ($value['productSKU'] == $postItem) {
            
            $resultQuantity++;
        }
    }
    return $resultQuantity;
}

function getSubTotalBySKU($postItem){
    foreach ($_SESSION['allCartItem'] as $key => $value) {
        if ($value['productSKU'] == $postItem) {
            return $subTotal = $subTotal + $value['productPrice'];
        }
    }
}

header("Location: item.php");

?>


