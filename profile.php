        	<div class="top_prod_box_big"><img src='images/details_box_top.gif' class='top_prod_box_big' /></div>
            <div class="center_prod_box_big">   
			
			


<?php
if(!isset($_SESSION['idUsers']))
	echo "Πρέπει να συνδεθείτε για να δείτε το προφίλ των μελών μας";
	else {
if(isset($_GET['user'])){
    $user=$_GET['user'];
    $user=  mysql_real_escape_string($user);
    $user=  user_read($user);
    if(!$user) exit("Ο χρήστης δεν βρέθηκε");
    ?>
<table class='user_info'>
    <tr>
        <td>Όνομα</td>
        <td><?php echo $user->firstName ?></td>
    </tr>
    <tr>
        <td>Επίθετο</td>
        <td><?php echo $user->lastName ?></td>
    </tr>
    <tr>
        <td>email</td>
        <td><?php echo $user->email ?></td>
    </tr>
    <tr>
        <td>Χώρα</td>
        <td><?php echo $user->country ?></td>
    </tr>
    <tr>
        <td>Διεύθυνση</td>
        <td><?php echo $user->streetAddress ?></td>
    </tr>
    <tr>
        <td>ΤΚ</td>
        <td><?php echo $user->postalCode ?></td>
    </tr>
    <tr>
        <td>Τηλέφωνο</td>
        <td><?php echo $user->phoneNumber ?></td>
    </tr>
    <tr>
        <td><a href="index.php?action=ratingdetails&user=<?php echo $user->username ?>">Buyer Rating</a></td>
        <td><?php echo $user->buyerRating ?></td>
    </tr>
    <tr>
        <td><a href="index.php?action=ratingdetails&user=<?php echo $user->username ?>">Seller Rating</a></td>
        <td><?php echo $user->sellerRating ?></td>
    </tr>
</table>
<a href="index.php?action=productlist&user=<?php echo $user->username ?>">Προϊόντα απο αυτόν τον χρήστη</a></br>
<?php if( $_SESSION['username']==$user->username) {?><a href="index.php?action=updateUser">Επεξεργασία προφίλ</a>
    <?php
	}
}
}
?>
			</div>
			<div class="bottom_prod_box_big"><img src='images/details_box_bottom.gif' class='bottom_prod_box_big' /></div>