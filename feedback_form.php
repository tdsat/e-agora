<div class="top_prod_box_big"><img src='images/details_box_top.gif' class='top_prod_box_big' /></div>
<div class="center_prod_box_big">   


<?php
$error=null;
$result=null;
if(isset($_SESSION['idUsers'])){
	if(!isset($_POST['subBut'])){ ?>
<form method='post' action='<?php echo $_SERVER['REQUEST_URI'] ?>'>
	Give us your opinion...
	<table border="0" width="450px">
		<tr>
			<td colspan="2" style="text-align:center">
				 Rating
			</td>
			<td colspan="2" style="text-align:center">
				<select name="select">
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
					<option value="6">6</option>
					<option value="7">7</option>
					<option value="8">8</option>
					<option value="9">9</option>
					<option value="10" selected>10</option>
				</select>
			</td>
		</tr>
		<tr>
			<td colspan="2" style="text-align:center">
				 Message
			</td>
			<td colspan="2" style="text-align:center">
				<textarea name="comment" cols=40 rows=6>
					I think...
				</textarea>
			</td>
		</tr>
		<tr>
			<td colspan="0" style="text-align:center">
				<input type="submit" name='subBut' value="Submit">
			</td>
		</tr>
	</table>
</form>
<?php
}
else{	
		if($_GET['s'] && $_GET['b']) {
			died('We are sorry, but there appears to be a problem with the form you submitted.');
		}
		if(isset($_POST['select'])) $select=$_POST['select'];
		if(isset($_POST['comment'])) $comment=$_POST['comment'];


		if($error=validate(&$select,$expType=digit, $min=1, $max=10,$can_be_null=FALSE));
		if($error=validate(&$comment,$expType=string, $min=2, $max=140,$can_be_null=FALSE));
		if($error) died($error);
		
		$comment=mysql_real_escape_string($comment);
		$comment=strip_tags($comment);
		
		if( isset($_GET['b'])){  
			$query="UPDATE `buyerrating` SET `comment`='".$comment."' , `rating`=$select ,`valid`=0 WHERE idTransaction=".$_GET['b']." AND idFromUser=".$_SESSION['idUsers'];
		}
		else if(isset($_GET['s'])){ 
			$query="UPDATE `sellerrating` SET `comment`='".$comment."', `rating`=$select , `valid`=0 WHERE idTransaction=".$_GET['s']." AND idFromUser=".$_SESSION['idUsers'];
		}
		else died('We are sorry, but there appears to be a problem with the form you submitted.');	
		if($query)	$result=DBLib::execute_query($query);
		if(!$result) $error='There was an error during submission. Try again';
		else echo 'Successfully saved! Thank you for your time.';
	}
}

?>

</div>
			<div class="bottom_prod_box_big"><img src='images/details_box_bottom.gif' class='bottom_prod_box_big' /></div>