<?php
//TODO : Implement CRUD functins for images
include_once 'dblib/dblib.php';
/*
  Συναρτήσεις χειρισμού των εικόνων/φωτογραφιών των προϊόντων
  Περιέχονται οι παρακάτω υπορουτίνες
  create_image()
  select_image()
  delete_image()

  Σχεδιασμένο για βάση με τα παρακάτω πεδία
  idImages        INT | Αυτόματη αρίθμηση. ΜΗΝ ΟΡΙΣΕΤΕ ΧΕΙΡΟΚΙΝΗΤΑ
  --------------------|--------------------------------------------------------
  idProduct       INT | Το id του προϊόντος με το οποίο σχετίζεται η εικόνα
  --------------------|--------------------------------------------------------
  image           BLOB| Το περιεχόμενο της εικόνας
 
*/


/* ΔΗΜΙΟΥΡΓΙΑ EIKONAΣ
* Γράφει τα δεδομένα μιας εικόνας, καθός και το προϊόν με το οποίο σχετίζονται
* στη βάση δεδομένων.
* Επιστρεφόμενες τιμές :
*    = 0: Επιτυχής εκτέλεση
*   != 0: Πρόβλημα κατα την εκτέλεση
*   
*   Σε περίπτωση λάθους, επιστρέφεται μύνημα λάθους
*/
function create_image($product,$file)
{
    //Ελέγχουμε αν επιτρέπεται να ανεβάσει και άλλες φωτογραφίες
    if(get_image_count($product) >4) return "Δεν επιτρέπεται να βάλεται και άλλες φωτογραφίες για αυτό το προϊόν";
    
    //Ορίζουμε τι είδους εικόνες επιτρέπονται στο προϊόν μας
    $allowedTypes=array('image/png','image/jpeg');
    
    //Διαβάζουμε κάποιες πληροφορίες για το αρχείο
    $fileinfo=  getimagesize($file);
    
    //Έλεγχος για τον τύπο του αρχείου
    if(!in_array($fileinfo['mime'],$allowedTypes,TRUE)) return 'Μη αποδεκτός τύπος εικόνας. Οι αποδεκτοί τύποι είναι .jpg και .png';
    
    //Διάβασμα δεδομένων απο το αρχείο
    $image=  file_get_contents($file);
    
    //Προστασία απο SQL-Injection
    $image=  mysql_real_escape_string($image);
    
    //Εκτέλεση ερωτήματος
    $query="INSERT INTO `images`(`idProduct`,`image`) VALUES ($product,'{$image}') ";
    $result=DBLib::execute_query($query);
    
    if(!$result) return "Κάτι πήγε στραβά. Δοκιμάστε ξανά";
    else return 0;
    
}


/* ΔΙΑΒΑΣΜΑ EIKONAΣ
* Διαβάζει και επιστρέφει τα δεδομένα μιας εικόνας απο την βάση. Γίνεται η 
* κωδικοποίησή τους και επιστρέφονται έτοιμα για εμφάνιση σε <img> tags
* Επιστρεφόμενες τιμές :
*   string με την εικόνα : Επιτυχής εκτέλεση
*   ΝULL                 : Πρόβλημα κατα την εκτέλεση
*   
*   Σε περίπτωση λάθους, η συνάρτηση δεν επιστρέφει τίποτα (ούτε κάποιο μύνημα) λάθους
*/
function read_image($imageId)
  {
    
    $query="SELECT `image` FROM `images` WHERE `idImages`=$imageId";
    $result=  DBLib::execute_query($query);
    
    if(!$result) return NULL;
    else {
        $result= mysql_fetch_row($result);
        $result= base64_encode($result[0]);
		$result="data:image/png;base64,".$result;
		return $result;
    }
  }
  
  

/* ΔΙΑΓΡΑΦΗ EIKONAΣ
* Διαβάζει και επιστρέφει τα δεδομένα μιας εικόνας απο την βάση. Γίνεται η 
* κωδικοποίησή τους και επιστρέφονται έτοιμα για εμφάνιση σε <img> tags
* Επιστρεφόμενες τιμές :
*   TRUE      : Επιτυχής εκτέλεση
*   FALSE     : Πρόβλημα κατα την εκτέλεση
*/
function delete_image($imageId){
    $query="DELETE `image` FROM `images` WHERE `idImages`={$imageId}";
    $result=  DBLib::execute_query($query);
    return $result;
}


//Επιστρέφει πόσες εικόνες έχει ένα προϊόν
function get_image_count($productId){
    $num=0;
    $query ="SELECT `idImages` FROM `images` WHERE `idProduct`=$productId";
    $result=DBLib::execute_query($query);
    $num=  mysql_num_rows($result);
    return $num;
}


//Επιστρέφει τις εικονες ενός προϊόντος (αν υπάρχουν)
//NULL σε περίπτωση που δεν βρεθεί τίποτα
function get_imageid_of_product($productId){
    $ids=array();
    $query="SELECT `idImages` FROM `images` WHERE `idProduct`=$productId";
    $result=  DBLib::execute_query($query);
    
    if($result){
        while($ids[]=  mysql_fetch_object($result));
        return $ids;
    }
    else
        return NULL;
    
}

?>