<div class="top_prod_box_big"><img src='images/details_box_top.gif' class='top_prod_box_big' /></div>
<div class="center_prod_box_big"> 
<?php 
if(!isset($_SESSION['idUsers'])){
	echo "You must login in order to see your members' ratings";
}
else{
	if(isset($_GET['user'])){
		$id=array('even','odd');
		$userid=user_get_id($_GET['user']);
		$sellerratings=read_seller_ratings($userid);
		//array_pop($sellerratings);
		$buyerratings=read_buyer_ratings($userid);
		//array_pop($buyerratings);
		//var_dump($sellerratings);
		echo "<hr />";
		//var_dump($buyerratings);
		
		
		if(isset($sellerratings)){ ?>
		<span class='red'>Seller ratings</span><hr />
		<table class='rating_details'><th id='fromuser'>From </th><th id='score'> Rating</th><thid='nostyle'>Comments</th>
<?php	$i=0;
		while($sellerratings[$i]){
			$name=get_field_value('username','users','idUsers',$sellerratings[$i]->idFromUser);
			echo "<tr id='".$id[$i%2]."'><td>".$name."</td><td>".$sellerratings[$i]->rating."</td><td>".$sellerratings[$i]->comment."</td></tr>";
				$i++;
			}
		echo "</table>";
		}
		
		if(isset($buyerratings)){ ?>
		<span class='red'>Buyer ratings</span><hr />
		<table class='rating_details'><th id='fromuser'>From </th><th id='score'> Rating</th><th id='comments'>Comments</th>
<?php	$i=0;
			while($buyerratings[$i]){
				$name=get_field_value('username','users','idUsers',$buyerratings[$i]->idFromUser);
				echo "<tr id='".$id[$i%2]."'>
					<td>".$name."</td>
					<td>".$buyerratings[$i]->rating."</td>
					<td>".$buyerratings[$i]->comment."</td>
				</tr>";
				$i++;
			}
		echo "</table>";
		}
	}
}?>
		

		

  




</div>
<div class="bottom_prod_box_big"><img src='images/details_box_bottom.gif' class='bottom_prod_box_big' /></div>