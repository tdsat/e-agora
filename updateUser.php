
        	<div class="top_prod_box_big"><img src='images/details_box_top.gif' class='top_prod_box_big' /></div>
            <div class="center_prod_box_big">   
			
			

<?php

if(isset($_SESSION['idUsers'])){
	$user=user_read($_SESSION['username']);
	
?>
<form method='POST'>
<table>
<tr>
<td>Name</td><td><input value='<?php echo $user->firstName ?>' type=text name=forname></td>
</tr>
<tr>
<td>Surname</td><td><input value='<?php echo $user->lastName ?>'  type=text name=surname></td>
</tr>
<tr>
<td>Password</td><td><input value='<?php echo $user->password ?>' type=text name=password></td>
</tr>
<tr>
<td>Address</td><td><input value='<?php echo $user->streetAddress ?>' type=text name=address></td>
</tr>
<tr>
<td>email</td><td><input value='<?php echo $user->email ?>' type=text name=email></td>
</tr>
</table>
<input type='submit' name='update' value='Ενημέρωση' >
</form>

<?php
	if(isset($_POST['update'])){
		$forname=$_POST['forname'];
		$surname=$_POST['surname'];
		$password=$_POST['password'];
		$address=$_POST['address'];
		$email=$_POST['email'];

	
		$address = mysql_real_escape_string($address);
		$email = mysql_real_escape_string($email);
		$password = mysql_real_escape_string($password);
		$surname = mysql_real_escape_string($surname);
		$forname = mysql_real_escape_string($forname);
		
		$query = "UPDATE `users` SET `password` = '{$password}',`streetAddress`='{$address}', `email`='{$email}', `lastName` = '{$surname}', `firstName` = '{$forname}' WHERE `username` = '{$_SESSION['username']}'";
		$result = DBLib::execute_query($query);
		return $result;
		}

}
else echo "You are not logged in";
?>

			</div>
			<div class="bottom_prod_box_big"><img src='images/details_box_bottom.gif' class='bottom_prod_box_big' /></div>

