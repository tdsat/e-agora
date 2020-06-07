<?php
//TODO : Implement CRUD Functions for ratings
/*
 * Basic functions for the ratings table
 * Talk is cheap
 */
 
 function read_buyer_ratings($userid){
	$rows = NULL;
    $num = 0;
	$query="SELECT * FROM `buyerrating` WHERE `idForUser`=$userid AND (`valid`=FALSE OR `comment`<>NULL)";
    DBLib::getrows($query, $rows, $num);

    //If no record is found, return NULL
    if ($num == 0) return NULL;

    while($ratings[] = mysql_fetch_object($rows));

    return $ratings;
 }
 
 
 
  function read_seller_ratings($userid){
	$rows = NULL;
    $num = 0;
	$query="SELECT * FROM `sellerrating` WHERE `idForUser`=$userid AND (`valid`=FALSE OR `comment`<>NULL)";
    DBLib::getrows($query, $rows, $num);

    //If no record is found, return NULL
    if ($num == 0) return NULL;

    while($ratings[] = mysql_fetch_object($rows));

    return $ratings;
 }


?>
