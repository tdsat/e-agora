<?php
/* Input validations and error handling for the transactions table
* Contains the following subroutines
* create_transaction($buyerId, $sellerId,$productId, $title)
* read_transaction($id)
* delete_transaction($id)
* 
//TODO : Implement CRUD functions for transactions
* Designed for a database with the following fields
* -------------------------------------------------------------------------
*  idTransaction  INT       | Auto increment. DO NOT SET MANUALLY
* --------------------------|-----------------------------------------------
*  idSeller       INT       | Foreign keys of related tables. Take care to
*  idBuyer        INT       | maintain database integrity
*  idProduct      INT       |
* --------------------------|-----------------------------------------------
*  title          VarC[45]  | These variables are REQUIRED
*  date           TIMESTAMP | 
*/

function create_transaction($buyer, $seller,$productId, $title,$quantity){
	$result1=NULL;
	$result2=NULL;
    
    //Αφαίρεση tags απο τον τίτλο
    $title=  mysql_real_escape_string($title);
    $title=  strip_tags($title);

    if($buyer==$seller) return "Δεν γίνεται να αγοράσεις το δικό σου προϊόν";
    
    $result1=product_update_quantity($productId,$quantity);
    $query="INSERT INTO `transaction` (`idBuyer`,`idSeller`,`idProduct`,`productTitle`,`date`) VALUES ($buyer,$seller,$productId,'{$title}', NOW() )";
    $result2=  DBLib::execute_query($query);
    
    if($result1 and $result2) return 0;
    return "Something went wrong. Try again";
}       

function read_transaction($id){
    $rows = NULL;
    $num = 0;
    
    $query="SELECT * FROM `transaction` WHERE `idTransaction`={$id}";
    DBLib::getrows($query, $rows, $num);
    
    if ($num == 0) return NULL;

    $transaction = mysql_fetch_object($rows);

    return $transaction;
}

function delete_transaction($id){
    
    $query="DELETE FROM `transaction` WHERE `idTransaction`={$id}";
    $result=  DBLib::execute_query($query);
    
    if($result) return 0;
    else return "Η διαγραφή απέτυχε. Δοκιμάστε ξανά";
}


//Επιστρέφει όλες τις συναλαγές στις οποίες έχει συμμετάσχει κάποιος χρήστης
//NULL σε περίπτωση λάθους
function get_user_transactions($userid){
$trans=NULL;
$query="SELECT * FROM `transaction` WHERE `idSeller`=$userid OR `idBuyer`=$userid";
$result=DBLib::execute_query($query);

	if($result){
		while($trans[]=mysql_fetch_object($result));
		return $trans;
	}
	else
		return NULL;
	

}

//Επιστρέφει τους συναλλαγές στις οποίες δεν έχει αφήσει ακόμα σχόλιο ή βαθμολογία
function get_rating_pending($userid){
$result=null;
$list=null;
$query="SELECT `transaction`.*
FROM `transaction`,`buyerrating`,`sellerrating`
WHERE (`buyerrating`.`valid`=TRUE AND`buyerrating`.`idTransaction`=`transaction`.`idTransaction` AND (`transaction`.`idSeller`=".$userid." OR `transaction`.`idBuyer`=$userid) )
OR (`sellerrating`.`valid`=TRUE AND `sellerrating`.`idTransaction`=`transaction`.`idTransaction` AND (`transaction`.`idSeller`=".$userid." OR `transaction`.`idBuyer`=$userid) )
GROUP BY `idTransaction`";

$result=DBLib::execute_query($query);
if ($result){
	while($list[]=mysql_fetch_object($result));
	return $list;
}
else return NULL;

}





?>
