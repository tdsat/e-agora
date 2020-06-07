
<div class='center_title_bar' ><img src="images/bar_bg.gif" id='bg' /><div id='content' >Συναλλαγές που δεν έχετε ακόμα σχολιάσει ή βαθμολογίσει</div></div>
<div class="top_prod_box_big"><img src='images/details_box_top.gif' class='top_prod_box_big' /></div>
<div class="center_prod_box_big"> 

<?php
//Only if you are logged in
if(isset($_SESSION['idUsers'])){
	//Read the transaction the user has done
	$transactions=get_rating_pending($_SESSION['idUsers']);
	//if(isset($transactions)) array_pop($transactions);

?>

<?php 
	if(isset($transactions)){
		//If they exists, separate them to purchases and sales
		$sales=NULL;
		$buyes=NULL;
		
		foreach($transactions as $trans){
			if($trans->idBuyer==$_SESSION['idUsers']) $buys[]=$trans;
			else $sales[]=$trans;
		}
	//και τις εμφανίζουμε
?>
<span class='red'> Sales </span> <hr />
<?php if(isset($sales)){ ?>
<table class='sales_headers'><th>Title</th><th>Sold to</th><th>Sale date</th></table>
<?php 
		echo "<table class='sales_pending'>";
		foreach($sales as $sale){
		if($sale){
			$buyer=get_field_value('username','users','idUsers',$sale->idBuyer);
			echo "<tr>
				<td><a href='index.php?action=feedback_form&b=".$sale->idTransaction."'>".$sale->productTitle."</a></td>
				<td><a href='index.php?action=feedback_form&b=".$sale->idTransaction."'>".$buyer."</a></td>
				<td id='nostyle'><a href='index.php?action=feedback_form&b=".$sale->idTransaction."'>".$sale->date."</a></td>
			</tr>";
	}
	}
echo "</table>";
}?>

<span class='red'> Purchases </span><hr />


<?php 
	if(isset($buys)){ ?>
	<table class='sales_headers'><th>Title</th><th>Bought by</th><th>Date bought</th></table>
<?php
		echo "<table class='sales_pending'>";
		foreach($buys as $buy){
			if($buy){
			$seller=get_field_value('username','users','idUsers',$buy->idSeller);
			echo "<tr>
				<td><a href='index.php?action=feedback_form&s=".$buy->idTransaction."'>".$buy->productTitle."</a></td>
				<td><a href='index.php?action=feedback_form&s=".$buy->idTransaction."'>".$seller."</a></td>
				<td id='nostyle'><a href='index.php?action=feedback_form&ss=".$buy->idTransaction. "'>".$buy->date."</a></td>
			</tr>";
			}
		}
		echo "</table>";
	}
}
else echo "Nothing found";
}
else echo "You must log in";
?>


</div>
<div class="bottom_prod_box_big"><img src='images/details_box_bottom.gif' class='bottom_prod_box_big' /></div> 		

