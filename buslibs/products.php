<?php

include_once 'dblib/dblib.php';
include_once 'helpfiles/helpfunctions.php';

/* Input validations and error handling for the «products» table
* Contains the following subroutines
* create_product($owner, $title, $category, $price, $description, $quantity)
* read_product($id)
* update_product($title, $category, $price, $description, $quantity)
* delete_product($id)
* 

* Designed for a database with the following fields
* -------------------------------------------------------------------------
*  idProducts   INT        | Auto increment. DO NOT SET MANUALLY
* -------------------------|-----------------------------------------------
*  idOwner      INT        | Foreign keys of related tables. Take care to
*  idCategory   INT        | maintain database integrity
* -------------------------|-----------------------------------------------
*  title        VarC[45]   | These variables are REQUIRED
*  price        FLOAT      |
* -------------------------|-----------------------------------------------
*  description  TEXT       | Optional variables. Their default values are
*  quantity     INT        | 1 and null (respectively)
*      
*/



/* PRODUCT CREATION
* Return values :
*    = 0: Successful execution
*   != 0: Problem during execution
*   
*   In case of an error, an array with all the error messages is returned
*/

function create_product($owner, $category, $title, $price, $description='', $quantity=1)
{
    $errorList=NULL;
    
    //Input validation check
    if(validate($title,'string',4,25,FALSE))           	$errorList[]="The title ".validate($title,'string',4,20,FALSE);
    if(validate($price,'number',0.1,4000000000,FALSE))  $errorList[]="The price ".validate($price,'integer,double',0.1,4000000000,FALSE);
	if(validate($description,'string',NULL,500))       	$errorList[]="The description".validate($description,'string',NULL,200);
    if(validate($quantity,'digit',1,10000))            $errorList[]="The quantity".validate($quantity,'integer',1,10000);
    
    
    
    //Protect against SQL injection
    $title=  mysql_real_escape_string($title);
    $description=  mysql_real_escape_string($description);
	
	//Remove php/html tags
	$title=  strip_tags($title);
    $description=  strip_tags($description);
    
	//Check if the category exists
    if(!read_categories($category)) $errorList[]='Unacceptable category selected';
    
    if($errorList==NULL)
    {
        $query = "INSERT INTO `products` (`idOwner`,`idCategory`,`title`,`price`,`description`,`quantity`) VALUES ('$owner', '$category', '$title', '$price','$description','$quantity')";
        $result = DBLib::execute_query($query);
    }
    else
        return $errorList;
   
    if ($result === FALSE) return "There was an error. Try again.";

    return 0;
    
    
}


//DELETE PRODUCT
// Function to delete a product
function delete_product($id){
    if(!read_product($id)) return "Could not find a product with this id($id)";
    
    $query="DELETE FROM `products` WHERE `idProducts`= $id";
    $result = DBLib::execute_query($query);
    
    if($result === FALSE) return "There was an error. Try again.";
    return 0;
    
}


function update_product($id,$title=NULL, $category=NULL, $price=NULL, $description=NULL, $quantity=NULL){
    $errorList=NULL;
    
    //Input validation check
    if(validate($title,'string',4,20,FALSE))                $errorList[]=validate($title,'string',4,20,FALSE);
    if(validate($price,'integer,double',0.1,NULL,FALSE))    $errorList[]=validate($price,'integer,double',0.1,NULL,FALSE);
    if(validate($category,'integer',NULL,NULL,FALSE))       $errorList[]=validate($category,'string',NULL,NULL,FALSE);
    if(validate($description,'string',NULL,200))            $errorList[]=validate($description,'string',NULL,200);
    if(validate($quantity,'integer',1,10000))               $errorList[]=validate($quantity,'integer',1,10000);
    
    
    
    
    //Protect against SQL injection
    $title=  mysql_real_escape_string($title);
    $description=  mysql_real_escape_string($description);
    
    if(!read_category($category)) $errorList[]='Επιλέχθηκε μη αποδεκτή Category';
    
    if($errorList==NULL)
    {
        $query = "UPDATE `products` SET `idCategory`={$category}, `title`='{$title}' ,`price`={$price},`description`='{$description}',`quantity`={$quantity} WHERE `idProduct`={$id}";
        $result = DBLib::execute_query($query);
    }
    else
        return $errorList;
   
    if ($result === FALSE) return "There was an error. Try again.";

    return 0;
    
    
}
//Returns the product with idProduct=$id\
//Returns NULL in case of an error
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
