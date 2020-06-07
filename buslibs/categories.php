<?php


//Returns an array with all the categories in the database
function read_categories(){
    $rows = NULL;
    $num = 0;
    
    $query="SELECT * FROM `categories`";
    DBLib::getrows($query, $rows, $num);
   
    if ($num == 0) return NULL;

    $categories = NULL;
    while($categories[]=mysql_fetch_object($rows));
    return $categories;
}


?>
