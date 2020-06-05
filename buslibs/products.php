<?php

include_once 'dblib/dblib.php';
include_once 'helpfiles/helpfunctions.php';

/* Επικύρωση εισόδου και αντιμετώπιση λαθών για τον πίνακα των «προϊόντων»
* Περιέχει τις παρακάτω υπορουτίνες
* create_product($owner, $title, $category, $price, $description, $quantity)
* read_product($id)
* update_product($title, $category, $price, $description, $quantity)
* delete_product($id)
* 

* Σχεδιασμένο για βάση με τα παρακάτω πεδία
* -------------------------------------------------------------------------
*  idProducts   INT        | Αυτόματη αρίθμηση. ΜΗΝ ΟΡΙΣΕΤΕ ΧΕΙΡΟΚΙΝΗΤΑ
* -------------------------|-----------------------------------------------
*  idOwner      INT        | Ξένα κλειδιά των ανάλογων πινάκων. Προσοχή 
*  idCategory   INT        | ώστε να διατηρηθεί η ακεραιότητα της βάσης
* -------------------------|-----------------------------------------------
*  title        VarC[45]   | Αυτές οι μεταβλητές είναι ΑΠΑΡΑΙΤΗΤΕΣ.
*  price        FLOAT      |
* -------------------------|-----------------------------------------------
*  description  TEXT       | Προεραιτικές μεβαβλητές. Οι προεπιλεγμένες 
*  quantity     INT        | τιμές τους είναι NULL και 1 (ανάλογα)
*      
*/



/* ΔΗΜΙΟΥΡΓΙΑ ΠΡΟΪΟΝΤΟΣ
* Επιστρεφόμενες τιμές :
*    = 0: Επιτυχής εκτέλεση
*   != 0: Πρόβλημα κατα την εκτέλεση
*   
*   Σε περίπτωση λάθους, ένας πίνακας με όλα τα μηνύματα λάθους επιστρέφεται
*/

function create_product($owner, $category, $title, $price, $description='', $quantity=1)
{
    $errorList=NULL;
    
    //Έλεγχος και επικύρωση εισόδων
    if(validate($title,'string',4,25,FALSE))           	$errorList[]="Ο τίτλος ".validate($title,'string',4,20,FALSE);
    if(validate($price,'number',0.1,4000000000,FALSE))  $errorList[]="Η τιμή ".validate($price,'integer,double',0.1,4000000000,FALSE);
	if(validate($description,'string',NULL,500))       	$errorList[]="Η περιγραφή".validate($description,'string',NULL,200);
    if(validate($quantity,'digit',1,10000))            $errorList[]="Η ποσότητα".validate($quantity,'integer',1,10000);
    
    
    
    //Προστασία απο SQL injection
    $title=  mysql_real_escape_string($title);
    $description=  mysql_real_escape_string($description);
	
	//Αφαίρεση php/html tags
	$title=  strip_tags($title);
    $description=  strip_tags($description);
    
	//Ελέγχουμε αν υπάρχει η κατηγορία
    if(!read_categories($category)) $errorList[]='Επιλέχθηκε μη αποδεκτή κατηγορία';
    
    if($errorList==NULL)
    {
        $query = "INSERT INTO `products` (`idOwner`,`idCategory`,`title`,`price`,`description`,`quantity`) VALUES ('$owner', '$category', '$title', '$price','$description','$quantity')";
        $result = DBLib::execute_query($query);
    }
    else
        return $errorList;
   
    if ($result === FALSE) return "Υπήρξε κάποιο πρόβλημα. Δοκιμάστε ξανά.";

    return 0;
    
    
}


//DELETE PRODUCT
// Συνάρτηση για την διαγραφή ενός προϊόντος
function delete_product($id){
    if(!read_product($id)) return "Δεν βρέθηκε προϊόν με αυτό το id($id)";
    
    $query="DELETE FROM `products` WHERE `idProducts`= $id";
    $result = DBLib::execute_query($query);
    
    if($result === FALSE) return "Υπήρξε κάποιο πρόβλημα. Δοκιμάστε ξανά.";
    return 0;
    
}


function update_product($id,$title=NULL, $category=NULL, $price=NULL, $description=NULL, $quantity=NULL){
    $errorList=NULL;
    
    //Έλεγχος και επικύρωση εισόδων
    if(validate($title,'string',4,20,FALSE))                $errorList[]=validate($title,'string',4,20,FALSE);
    if(validate($price,'integer,double',0.1,NULL,FALSE))    $errorList[]=validate($price,'integer,double',0.1,NULL,FALSE);
    if(validate($category,'integer',NULL,NULL,FALSE))       $errorList[]=validate($category,'string',NULL,NULL,FALSE);
    if(validate($description,'string',NULL,200))            $errorList[]=validate($description,'string',NULL,200);
    if(validate($quantity,'integer',1,10000))               $errorList[]=validate($quantity,'integer',1,10000);
    
    
    
    
    //Προστασία απο SQL injection
    $title=  mysql_real_escape_string($title);
    $description=  mysql_real_escape_string($description);
    
    if(!read_category($category)) $errorList[]='Επιλέχθηκε μη αποδεκτή κατηγορία';
    
    if($errorList==NULL)
    {
        $query = "UPDATE `products` SET `idCategory`={$category}, `title`='{$title}' ,`price`={$price},`description`='{$description}',`quantity`={$quantity} WHERE `idProduct`={$id}";
        $result = DBLib::execute_query($query);
    }
    else
        return $errorList;
   
    if ($result === FALSE) return "Υπήρξε κάποιο πρόβλημα. Δοκιμάστε ξανά.";

    return 0;
    
    
}
//Επιστρέφει το προϊόν με idProduct=$id\
//Επιστρέφει NULL σε περίπτωση λάθους
function read_product($id){
    $rows = NULL;
    $num = 0;
    
    $query="SELECT * FROM `products` WHERE `idProducts`=$id";
    DBLib::getrows($query, $rows, $num);
    
   
    if ($num == 0) return NULL;

    $product = mysql_fetch_object($rows);
    return $product;
}


function product_update_quantity($id,$q){

$query="UPDATE `products` SET `quantity`=$q WHERE `idProducts`=$id";
$result=DBLib::execute_query($query);

if(!$result) return FALSE;
else return TRUE;

}

?>
