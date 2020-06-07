<?php
//Grab a few products from the database along with one of their images
$query="SELECT `idProduct`,`idOwner`,`quantity`,`title`,`price`,`image`
FROM `images`,`products`
WHERE `images`.`idProduct`=`products`.`idProducts`
GROUP BY `idProduct`
ORDER BY RAND()
LIMIT 9
";
$result=DBLib::execute_query($query);
while($products[]=mysql_fetch_object($result));
array_pop($products);


//And then we display them!!!!YEAH!

foreach($products as $p){
	$p->image=base64_encode($p->image);
	echo 	"<div class='prod_box'>";
	echo 	"<div class='top_prod_box'></div>";
	echo 	"<div class='center_prod_box'>";            
	echo		"<div class='product_title'><a href='index.php?action=productpage&productId=".$p->idProduct."'>".$p->title."</a></div>";
	echo		"<div class='product_img'><a href='index.php?action=productpage&productId=".$p->idProduct."'><img class='product_img' src='data:image/png;base64,".$p->image."' alt=".$p->title." border='0' /></a></div>";
	echo		"<div class='prod_price'><span class='price'>".$p->price."€</span></div>";                        
	echo 		'</div>';
	echo		"<div class='bottom_prod_box'></div>";             
	echo		"<div class='prod_details_tab'>";       
	echo		"<a href='index.php?action=productpage&productId=". $p->idProduct ."' class='prod_details'>details</a>";            
	echo		"</div>";                 
	echo 	"</div>";
}


?>