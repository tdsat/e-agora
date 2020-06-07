<?php
include_once 'buslibs/users2.php';

if( isset($_SESSION['role']) && $_SESSION['role']=='user')
        exit("You don't have the required permissions");
else{
		$userDeleted = FALSE;
		$username=NULL;
		$delUserButton=FALSE;
		if (key_exists("username", $_POST)) $username = $_POST["username"];
		if (key_exists("delUserButton", $_POST)) $delUserButton = $_POST["delUserButton"];
		
		if ($delUserButton)
		{
			$userDeleted= user_delete($username);
			//TODO : delete user feedback
			if($userDeleted) echo "Successfully deleted user $username";
			else echo "Something went wrong. Try again";
		}
	}
?>
            