<?php 

if(isset($_POST['deleteProductId'])){
	$product=read_product($_POST['deleteProductId']);
	if($product){
	if(isset($_SESSION['idUsers'])){
		if($_SESSION['role'] =='admin' || $_SESSION['idUsers']==$product->idOwner){
			$result=delete_product($product->idProducts);
			if($result) echo $result;
			else echo "Επιτυχής διαγραφή προϊόντος";
		}
		else
			echo ( "Δεν έχετε δικαιώματα να διαγράψετε αυτό το προϊόν");
		}
	}
	else echo 'Αυτό το προϊόν δεν υπάρχει';
}	
?>