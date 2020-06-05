<?php 
$product=NULL;
$productId=NULL;


if(isset($_GET['productId']) and $_GET['productId']!=''){

	$productId=$_GET['productId'];
	$product=read_product($productId);
	if($product){
		$r=  user_read_id($product->idOwner);?>
		    <div class="prod_box_big">
        	<div class="top_prod_box_big"><img src='images/details_box_top.gif' class='top_prod_box_big' /></div>
            <div class="center_prod_box_big">            
					<?php include_once 'showimages.php'; ?>

                     <div class="details_big_box">
                         <div class="product_title_big"><?php echo $product->title ; ?></div>
                         <div class="specifications">
                            Απο : <span class="blue"><?php echo "<a href='index.php?action=profile&user=".$r->username."'>".$r->username."</a>"; ?></span><br />

                            Ποσότητα : <span class="blue"><?php echo $product->quantity;?></span><br />
                            
                            Περιγραφή : <span class="blue"><?php echo $product->description; ?></span><br />
                         </div>
                         <div class="prod_price_big"><span class="price"><?php echo $product->price.'€';?></span></div>

                     </div>    
				<?php 
				if(isset($_SESSION['idUsers'])){ 
					if($_SESSION['idUsers']!=$product->idOwner) include_once 'buyproduct.php';
					if($_SESSION['role']=='admin' || $_SESSION['idUsers']==$product->idOwner){?>
						<form method="POST" id='deleteproduct' action="index.php?action=deleteproduct"><br />
						<input type="hidden" name="deleteProductId" value=<?php echo $product->idProducts;?>>
						<a href="#" class="delete" onclick=submitForm('deleteproduct') >Διαγραφή</a>
						</form><?php
					}   
				} ?>					 
            </div>
            <div class="bottom_prod_box_big"><img src='images/details_box_bottom.gif' class='bottom_prod_box_big' /></div> 
<?php		if(isset($_SESSION['idUsers']))
				if($_SESSION['idUsers']==$product->idOwner){
?>
				<div class='center_title_bar' ><img src="images/bar_bg.gif" id='bg' /><div id='content' >Upload φωτογραφιών</div></div>
				<div class="top_prod_box_big"><img src='images/details_box_top.gif' class='top_prod_box_big' /></div>
				<div class="center_prod_box_big">
				<div id="uploadform">
<?php			include_once 'imageupload.php';  
?>
				</div>
				</div>
			<div class="bottom_prod_box_big"><img src='images/details_box_bottom.gif' class='bottom_prod_box_big' /></div> 		
		</div>

<?php			}
	}
	else echo "Το προϊόν που ψάχνετε δεν βρέθηκε";
}
?>

