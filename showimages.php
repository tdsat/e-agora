<script type='text/javascript'> 
function changePic(sourceId){
	document.getElementById('bigpic').src= document.getElementById(sourceId).src;
	} 
</script>

<?php

//Display product images (if any)
global $productId;
$existing_images=  get_imageid_of_product($productId);
if($existing_images[0]){
	//Set the place they will be displayed at
	echo "<div class='product_img_big'>";
	//Define the original (big) image...
	$mainImage=read_image($existing_images[0]->idImages);
	//...and display it ?>
	<a href="javascript:popImage('<?php echo $mainImage; ?>','Image')" title="header=[Zoom] body=[&nbsp;] fade=[on]"><img id='bigpic' src='<?php echo $mainImage; ?>' alt="" title="" border="0" /></a>
	<div class="thumbs">
<?php	$i=0;
        while($existing_images[$i]){
            $show=read_image($existing_images[$i++]->idImages);
			echo  "<a href=# title='header=[Image".$i."] body=[&nbsp;] fade=[on]'><img onclick='changePic(this.id)' id='thumb".$i."' src='".$show."' alt='' title='' border='0' /></a>";
        }
		echo  "</div>
 </div>";
}

?>