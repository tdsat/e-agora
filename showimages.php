<script type='text/javascript'> 
function changePic(sourceId){
	document.getElementById('bigpic').src= document.getElementById(sourceId).src;
	} 
</script>

<?php

//Εμφάνιση φωτογραφιών προϊόντως (αν υπάρχουν)
global $productId;
$existing_images=  get_imageid_of_product($productId);
if($existing_images[0]){
	//Ορίζουμε το μέρος που θα εμφανίζονται
	echo "<div class='product_img_big'>";
	//Ορίζουμε την αρχική (μεγάλη) εικόνα...
	$mainImage=read_image($existing_images[0]->idImages);
	//...και την εμφανίζουμε ?>
	<a href="javascript:popImage('<?php echo $mainImage; ?>','Εικόνα')" title="header=[Zoom] body=[&nbsp;] fade=[on]"><img id='bigpic' src='<?php echo $mainImage; ?>' alt="" title="" border="0" /></a>
	<div class="thumbs">
<?php	$i=0;
        while($existing_images[$i]){
            $show=read_image($existing_images[$i++]->idImages);
			echo  "<a href=# title='header=[Εικόνα".$i."] body=[&nbsp;] fade=[on]'><img onclick='changePic(this.id)' id='thumb".$i."' src='".$show."' alt='' title='' border='0' /></a>";
        }
		echo  "</div>
 </div>";
}

?>