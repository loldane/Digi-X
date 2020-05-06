<?php 
session_start();
$strJsonFileContents = file_get_contents("productList.json");
// Convert to array 
$array = json_decode($strJsonFileContents, true);
//var_dump($array[0]); // print array
?>
<html>
<head>
    <title>Digi-X Shopping Cart</title>
</head>

<body>
<form action="itemScan.php" method="POST">
<table border=1>
<tr>
    <td>Item to scan</td><td><input type="text" placeholder="atv, ipd, mbp, vga" name="SKU" id="SKU" value="atv"> </td>
</tr>

</table>
<button id="addCart">Add to Cart</button>
</form>

<?php 

if(isset($_SESSION['allCartItem'])){
   // print_r($_SESSION['allCartItem']);
}
//$_SESSION['allCartItem'] = array()
$bil = 1;
?>

<?php if(isset($_SESSION['allCartItem'])){ ?>
<a href="clear.php">Clear Cart</a>
<table border=1>
<tr>
    <td>No</td>
    <td>SKU</td>
    <td>Product</td>
    <td>Price</td>
    <td>Quantity</td>
    <td>Action</td>
</tr>
<?php foreach ($_SESSION['allCartItem'] as $key => $value) { ?>
<?php 
        $num = $bil++;
?>
<tr>
    <td><?php echo $num; ?></td>
    <td><?php echo $value['productSKU']; ?></td>
    <td><?php echo $value['productName']; ?></td>
    <td class="price"><?php echo "$ ".number_format($value['productPrice'], 2, '.',''); ?><input type="hidden" id="price" name="price"></td>
    <td><?php echo $value['quantity']; ?></td>
    <td><button class="addCart" id="<?php echo $value['productSKU']; ?>">Remove</button></td>
<tr>
<?php }?>
<tr>
    <td></td>
    <td></td>
    <td>Total :</td>
    <td><?php echo "$ ".number_format($_SESSION['subTotal'], 2, '.',''); ?></td>
    <td></td>
    <td></td>
</tr>
<?php }?>
</table>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
   $("#addCart").click(function(){

    var SKU = $("#SKU").val();
    //alert(SKU);
   });
});
</script>
</body>
</html>