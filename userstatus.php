<?php
    if(isset($_SESSION['idUsers'])) {
        echo "<li class='text1'>Welcome,</li><li class='text1'><a class='nav7' href='index.php?action=profile&user={$_SESSION['username']}'> {$_SESSION['username']}</a></li>";
		include_once 'logout.php';
		echo "<li class='divider'></li>";
		echo "<li><a href='index.php?action=yourstore' class='nav4'>Τα προϊόντα μου</a></li>";
		echo "<li class='divider'></li>";
		echo "<li><a href='index.php?action=newproduct' class='nav3'>Νέα αγγελία</a></li>";
		//Check if user has pending ratings
		$transactions=get_user_transactions($_SESSION['idUsers']);
		array_pop($transactions);
		//If they exist, we shot the stupid little thing for them to leave rafgasgdfghh
		if(isset($transactions))
			echo "<li><a href='index.php?action=feedbacklist' class='nav9'  id='float_right'>Rating pending</a></li>";
    }
    else {
        include 'login.php';
		echo "<li class='divider'></li>";
		echo "<li><a href='index.php?action=sighnup' class='nav4'>Sign up</a></li>";
    }
?>
