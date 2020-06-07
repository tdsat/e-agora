
<?php 
if(isset($_POST['productIdbuy'])){
	$productId=$_POST['productIdbuy'];
	$result=NULL;
	//Check if you are logged in
	if(isset($_SESSION['idUsers'])){
		//Check if buy quantity was given
		if(isset($_POST['quantity'])){
			//Check if the product exists
			$product=  read_product($productId);

			if($product){
				$buyer=$_SESSION['idUsers'];
				//Check the quantity
				if(filter_var($_POST['quantity'],FILTER_VALIDATE_INT) and $_POST['quantity'] > 0){
					//Check if the quantity given is too high
					if($_POST['quantity'] <= $product->quantity){
						//Set the final quantity of the product
						$finalQ=$product->quantity - $_POST['quantity'];
						// also do the transaction
						$result=create_transaction($buyer , $product->idOwner,  $productId, $product->title,$finalQ);
						if($result){
							echo $result;
							//Reset the product quantity to its original value
							product_update_quantity($product->idProducts,$product->quantity);
						}
						else{
							//If the product is out of stock, we delete it
							if($finalQ==0) $result=delete_product($productId);
							if(!$result){
								echo "The purchase was successful";
								echo "<meta http-equiv='REFRESH' content='2;url=index.php'>";
								}
							else echo $result;
						}
					}
					else echo "Quantity too high";
					
				}
				else echo "Invalid value";
				
			}
		}
	}
	else echo "You must login to buy the product";
}
else{ ?>

<form name='buyproduct' id='buyproduct' method="POST" action="index.php?action=buyproduct" >
<input type="hidden" name="productIdbuy" value="<?php echo $product->idProducts; ?>" />

<a href="#" class="buyproduct" onclick=submitForm('buyproduct') >Buy</a><input type="text" class='quant_input' name="quantity" value=1 />
</form>
<?php } ?>




















