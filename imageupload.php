<?php
include_once 'buslibs/images.php';
global $productId;
//Εκτέλεση του παρακάτω κώδικα μόνο αν υπάρχει κάποιο productId διαθέσιμο
if($productId){
    //Έλεγχος για το πόσες φωτογραφίες έχουν ανέβει ήδη για το προϊόν
    $product_images= get_image_count($productId);
    $remainingImages=5-$product_images;
    //Αν επιτρέπεται να ανεβάσει και άλλες εικόνες, εμφάνισε την φόρμα
    if($remainingImages>0){ ?>    
    <form enctype="multipart/form-data" method="POST">
        <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
        <?php

        for($i=0;$i<$remainingImages;$i++) echo "<input id='img".$i."' name=\"images[]\" type=\"file\" /><br />"
        ?>
        <input type="submit" name='imageupbutton' value="Αποθήκευση" />
    </form>
    <?php }
    //Μώλις πατήσει το κουμπί...
    if(isset($_POST['imageupbutton'])){
		//...αν έχει επιλέξει αρχεία για ανέβασμα...
        if(isset($_FILES['images'])){
            //...για κάθε αρχείο που ανέβηκε...
			for($i=0;$i<$remainingImages;$i++){
				$error=NULL;
				//Αλέγχουμε αν η φορμα ήταν κενή
			    if( $_FILES['images']['tmp_name'][$i] ){
					//..έλεγχος για το αν έγινε σωστή λήψη του αρχείου...
                    if($_FILES['images']['error'][$i]!=0){         
						//...αν κάτι πήγε στραβά, καταγράφουμε το error
						$error="Κάτι πήγε στραβά κατα την αποστολή ενός ή περισσότερων αρχείων. Δοκιμάστε ξανά <br />";
                    }
					//...αν κάποιο αρχείο είναι μεγαλύτερο απο 1 ΜΒ, εμφάνιση μυνήματος και έξοδος απο το script.
					if($_FILES['images']['size'][$i] > 1048576)
						$error="To μέγιστο επιτρεπτό όριο για κάθε αρχείο είναι 1 ΜΒ.<br />";
						
					//Ελέγχουμε αν έχει εμφανιστεί κάποιο πρόβλημα. Αν όχι, ανεβάζουμε το αρχείο
					//Η  εντολή θα ελέγχξει αν είναι σωστού τύπου και θα επιστρέψει μύνημα λάθους σε
					//περίπτωση που δεν κάνουν. Βέβαια αυτός ο έλεγχος δεν είναι απόλυτα ασφαλής
					//αλλά δεν βαριέσαι. THUG LIFE!
					if(!$error){
						$result=create_image($productId, $_FILES['images']['tmp_name'][$i]);
						if($result) echo $result;
						else     echo "<META HTTP-EQUIV='refresh' CONTENT='0'>";
					}
					//αλλιώς εμφανίζουμε το error
					else echo "<div id='error' >".$error."</div>";
			   }
			//Και επαναφέρουμε το error flag
			$error=NULL;
            }//end of file loop
		}
	}
}
?>