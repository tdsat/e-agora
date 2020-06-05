
<div class='center_title_bar' ><img src="images/bar_bg.gif" id='bg' /><div id='content' >Συναλλαγές που δεν έχετε ακόμα σχολιάσει ή βαθμολογίσει</div></div>
<div class="top_prod_box_big"><img src='images/details_box_top.gif' class='top_prod_box_big' /></div>
<div class="center_prod_box_big"> 

<?php
//Μόνο αν είναι συνδεδεμένος
if(isset($_SESSION['idUsers'])){
	//Διαβάζουμε όλες τις συναλαγές που έχει κάνει
	$transactions=get_rating_pending($_SESSION['idUsers']);
	//if(isset($transactions)) array_pop($transactions);

?>

<?php 
	if(isset($transactions)){
		//Αν υπάρχουν,τις χωρίζουμε σε αγορές και πωλήσεις
		$sales=NULL;
		$buyes=NULL;
		
		foreach($transactions as $trans){
			if($trans->idBuyer==$_SESSION['idUsers']) $buys[]=$trans;
			else $sales[]=$trans;
		}
	//και τις εμφανίζουμε
?>
<span class='red'> Πωλήσεις </span> <hr />
<?php if(isset($sales)){ ?>
<table class='sales_headers'><th>Τίτλος</th><th>Πωλήθηκε σε</th><th>Ημερομηνία πώλησης</th></table>
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

<span class='red'> Αγορές </span><hr />


<?php 
	if(isset($buys)){ ?>
	<table class='sales_headers'><th>Τίτλος</th><th>Αγοράστηκε από</th><th>Ημερομηνία πώλησης</th></table>
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
else echo "Δεν βρέθηκε τίποτα";
}
else echo "Πρέπει να συνδεθείτε";
?>


</div>
<div class="bottom_prod_box_big"><img src='images/details_box_bottom.gif' class='bottom_prod_box_big' /></div> 		

