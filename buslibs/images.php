<?php
//TODO : Implement CRUD functins for images
include_once 'dblib/dblib.php';
/*
  Product image/photo handling function
  Contains the following sub-routines
  create_image()
  select_image()
  delete_image()

  Designed for a database with the following fields
  idImages        INT | Auto increment. DO NOT SET MANUALLY
  --------------------|--------------------------------------------------------
  idProduct       INT | The id of the product related to the image
  --------------------|--------------------------------------------------------
  image           BLOB| The image content
 
*/


/* IMAGE CREATION
* Writes the image data, as well as the related product, to the database
* Return values :
*    = 0: Successful execution
*   != 0: Problem during execution
*   
*   In case of an error, an error message is returned
*/
function create_image($product,$file)
{
    //Check if adding more photos is allowed
    if(get_image_count($product) >4) return "No other photos may be uploaded for this product";
    
    //Set the allowed image types for our product
    $allowedTypes=array('image/png','image/jpeg');
    
    //Read some information about the file
    $fileinfo=  getimagesize($file);
    
    //Check the file type
    if(!in_array($fileinfo['mime'],$allowedTypes,TRUE)) return 'Not allowed image type. Allowed types are .jpg and .png';
    
    //Read data from file
    $image=  file_get_contents($file);
    
    //Protect against SQL-Injection
    $image=  mysql_real_escape_string($image);
    
    //Executing query
    $query="INSERT INTO `images`(`idProduct`,`image`) VALUES ($product,'{$image}') ";
    $result=DBLib::execute_query($query);
    
    if(!$result) return "Something went wrong. Try again";
    else return 0;
    
}


/* READ IMAGE
* Reads and returns the data of an image from the database. Gets encoded
* and returns a value ready for display inside <img> tags
* Return values :
*   image string : Successful execution
*   ΝULL         : Problem during execution
*   
*   In case of an error, the function returns nothing (not even an error) message
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
  
  

/* IMAGE DELETION
* Reads and returns the data of an image from the database. Gets encoded
* and returns a value ready for display inside <img> tags
* Return values :
*   TRUE      : Successful execution
*   FALSE     : Problem during execution
*/
function delete_image($imageId){
    $query="DELETE `image` FROM `images` WHERE `idImages`={$imageId}";
    $result=  DBLib::execute_query($query);
    return $result;
}


//Returns how many images a product has
function get_image_count($productId){
    $num=0;
    $query ="SELECT `idImages` FROM `images` WHERE `idProduct`=$productId";
    $result=DBLib::execute_query($query);
    $num=  mysql_num_rows($result);
    return $num;
}


//Returns the images of a product (if they exist)
//NULL in case nothing is found
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