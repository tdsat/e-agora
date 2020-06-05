<?php
include_once 'buslibs/users2.php';

if( isset($_SESSION['role']) && $_SESSION['role']=='user')
        exit("Δεν έχετε τα κατάλληλα δικαιώματα");
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
			if($userDeleted) echo "Επιτυχής διαγραφή του χρήστη $username";
			else echo "Κάτι πήγε στραβά. Δοκιμάστε ξανά";
		}
	}
?>
            