<?php
	require($DOCUMENT_ROOT . "helpfiles/helpfunctions.php");
$error=null;
$result=null;
if(isset($_SESSION['idUsers']){
	if(isset($_POST['select']) $select=$_POST['select'];
	if(isset($_POST['comment']) $comment=$_POST['comment'];


	if($error=validate(&$select,$expType=digit, $min=1, $max=10,$can_be_null=FALSE));
	if($error=validate(&$comment,$expType=string, $min=2, $max=140,$can_be_null=FALSE);
	if($error) died($error);
	
	if($_GET['s'] && $_GET['b']) {
		died('We are sorry, but there appears to be a problem with the form you submitted.');
	}
	
	$comment=mysql_real_escape_string($comment);
	$comment=strip_tags($comment);
	
	if( $_GET['b']){ then 
		$query="UPDATE `buyerrating` SET `comment`= $comment , `rating`=$select , set valid=FALSE WHERE idTransaction=$_GET['b'] ΑΝD idFromUser=$_SESSION['idUsers']";
	}
	else id( $_GET['s']){ then 
		$query="UPDATE `buyerrating` SET `comment`= $comment , `rating`=$select , set valid=FALSE WHERE idTransaction=$_GET['s'] ΑΝD idFromUser=$_SESSION['idUsers']";
	}
	if($query)	$result=DBLib::execute_query($query);
	if(!$result) $error='Υπήρξε πρόβλημα κατα την αποστολή. Δοκιμάστε ξανά';
	else echo 'Επιτυχής αποθήκευση!Ευχαριστούμε για τον χρόνο σας.';
}

?>
