        	<div class="top_prod_box_big"><img src='images/details_box_top.gif' class='top_prod_box_big' /></div>
            <div class="center_prod_box_big">  

<?php
	
	$email_to = "feedback@agora.com";
	
	$email_subject = "Agora Feedback";
	
	
	function died($error) {
		echo "We are sorry, but there are errors found with your Feedback form.<br /><br />";
		echo $error."<br /><br />";
		echo "Please go back and fix these errors.<br /><br />";
		die();
	}
	
	// έλεγχος των πεδίων της φόρμας
	if(!isset($_POST['first_name']) ||
		!isset($_POST['last_name']) ||
		!isset($_POST['email']) ||
		!isset($_POST['comments'])) {
		died('We are sorry, but there appears to be a problem with the form you submitted.');		
	}
	
	$first_name = $_POST['first_name'];
	$last_name = $_POST['last_name'];
	$email_from = $_POST['email'];
	$comments = $_POST['comments'];
	
	$error_message = "";
	
	$email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
  if(!preg_match($email_exp,$email_from)) {
  	$error_message .= 'The Email Address you entered does not appear to be valid.<br />';
  }
  
	$string_exp = "/^[A-Za-z .'-]+$/";
  if(!preg_match($string_exp,$first_name)) {
  	$error_message .= 'The First Name you entered does not appear to be valid.<br />';
  }
  if(!preg_match($string_exp,$last_name)) {
  	$error_message .= 'The Last Name you entered does not appear to be valid.<br />';
  }
  
  if(strlen($comments) < 2) {
  	$error_message .= 'The Comments you entered do not appear to be valid.<br />';
  }
  
  if(strlen($error_message) > 0) {
  	died($error_message);
  }
  
  
	$email_message = "Feedback details below.\n\n";
	
	$email_message .= "First Name: ".$first_name."\n";
	$email_message .= "Last Name: ".$last_name."\n";
	$email_message .= "Email: ".$email_from."\n";
	$email_message .= "Comments: ".$comments."\n";
	
// δημιουργία headers
$headers = 'From: '.$email_from."\r\n".
'Reply-To: '.$email_from."\r\n" .
'X-Mailer: PHP/' . phpversion();

@mail($email_to, $email_subject, $email_message, $headers);
?>

Thank you for taking the time to provide us with your feedback.

<?php
die();
?>

				</div>
			<div class="bottom_prod_box_big"><img src='images/details_box_bottom.gif' class='bottom_prod_box_big' /></div> 

