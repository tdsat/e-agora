
<?php 
if(isset($_POST['productIdbuy'])){
	$productId=$_POST['productIdbuy'];
	$result=NULL;
	//Έλεγχος αν είναι συνδεδεμένος
	if(isset($_SESSION['idUsers'])){
		//Έλεγχος αν έχει δώσει ποσότητα για αγορά
		if(isset($_POST['quantity'])){
			//Έλεγχος αν υπάρχει το προϊόν
			$product=  read_product($productId);

			if($product){
				$buyer=$_SESSION['idUsers'];
				//Έλεγχος την ποσότητας
				if(filter_var($_POST['quantity'],FILTER_VALIDATE_INT) and $_POST['quantity'] > 0){
					//Ελέγχουμε αν έχει δώσει πολύ μεγάλο αριθμό για ποσότητα
					if($_POST['quantity'] <= $product->quantity){
						//Θέτουμε την τελική ποσότητα του προϊόντος
						$finalQ=$product->quantity - $_POST['quantity'];
						// κάνουμε και το transaction
						$result=create_transaction($buyer , $product->idOwner,  $productId, $product->title,$finalQ);
						if($result){
							echo $result;
							//Επαναφέρουμε την ποσότητα του προϊόντος στην αρχική του τιμή
							product_update_quantity($product->idProducts,$product->quantity);
						}
						else{
							//Αν έχουν τελειώσει τα αποθέματα του προϊόντος, το διαγράφουμε
							if($finalQ==0) $result=delete_product($productId);
							if(!$result){
								echo "Η αγορά ήταν επιτυχής";
								echo "<meta http-equiv='REFRESH' content='2;url=index.php'>";
								}
							else echo $result;
						}
					}
					else echo "Πολύ μεγάλη ποσότητα";
					
				}
				else echo "Μη αποδεκτή τιμή";
				
			}
		}
	}
	else echo "Πρέπει να συνδεθείτε για να αγοράσετε προϊόντα";
}
else{ ?>

<form name='buyproduct' id='buyproduct' method="POST" action="index.php?action=buyproduct" >
<input type="hidden" name="productIdbuy" value="<?php echo $product->idProducts; ?>" />

<a href="#" class="buyproduct" onclick=submitForm('buyproduct') >Αγορά</a><input type="text" class='quant_input' name="quantity" value=1 />
</form>
<?php } ?>




















