<?php
include_once 'buslibs/images.php';
global $productId;
//Execute the following code only if a productId is available
if($productId){
    //Check how many photos have already been uploaded for the product
    $product_images= get_image_count($productId);
    $remainingImages=5-$product_images;
    //If the user is allowed to upload more images, show the form
    if($remainingImages>0){ ?>
    <form enctype="multipart/form-data" method="POST">
        <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
        <?php

        for($i=0;$i<$remainingImages;$i++) echo "<input id='img".$i."' name=\"images[]\" type=\"file\" /><br />"
        ?>
        <input type="submit" name='imageupbutton' value="Αποθήκευση" />
    </form>
    <?php }
    //When he clicks the button...
    if(isset($_POST['imageupbutton'])){
		//...if he has selected images to upload...
        if(isset($_FILES['images'])){
            //...for every uploaded file...
			for($i=0;$i<$remainingImages;$i++){
				$error=NULL;
				//Check if the form is empty
			    if( $_FILES['images']['tmp_name'][$i] ){
					//..Check if the files were received correctly...
                    if($_FILES['images']['error'][$i]!=0){         
						//...if something went wrong, register the error
						$error="Something went wrong while uploading one or more files. Try again <br />";
                    }
					//...if a file is more than 1 MB, show a message and exit the script
					if($_FILES['images']['size'][$i] > 1048576)
						$error="The maximum allowed size for each file is 1 MB.<br />";

          //Check if there were any errors. If not, upload the file
					//The  function will check if it's the correct file type and will return an error
					//message in case they are incorrect. Of course this check is not perfectly safe
					//but why bother. THUG LIFE!
					if(!$error){
						$result=create_image($productId, $_FILES['images']['tmp_name'][$i]);
						if($result) echo $result;
						else     echo "<META HTTP-EQUIV='refresh' CONTENT='0'>";
					}
					//else we display the error
					else echo "<div id='error' >".$error."</div>";
			   }
			//and reset the error flag
			$error=NULL;
            }//end of file loop
		}
	}
}
?>