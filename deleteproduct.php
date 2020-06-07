<?php 

if(isset($_POST['deleteProductId'])){
	$product=read_product($_POST['deleteProductId']);
	if($product){
	if(isset($_SESSION['idUsers'])){
		if($_SESSION['role'] =='admin' || $_SESSION['idUsers']==$product->idOwner){
			$result=delete_product($product->idProducts);
			if($result) echo $result;
			else echo "Successfully deleted product";
		}
		else
			echo ( "You are not allowed to delete this product");
		}
	}
	else echo "This product doesn't exist";
}	
?>