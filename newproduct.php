<div class="top_prod_box_big"><img src='images/details_box_top.gif' class='top_prod_box_big' /></div>
<div class="center_prod_box_big"  > <div id="textleft">



<?php 
	
if(isset($_SESSION['idUsers'])){
	$failedAddProduct = TRUE; 
	$addproductbutton=NULL;

	
	if (key_exists("Title", $_POST)) $Title = $_POST["Title"];
	if (key_exists("Price", $_POST)) $Price = $_POST["Price"];
	if (key_exists("Category", $_POST)) $Category = $_POST["Category"];
	if (key_exists("Description", $_POST)) $Description = $_POST["Description"];
	if (key_exists("Quantity", $_POST)) $Quantity = $_POST["Quantity"];
	if (key_exists("addproductbutton", $_POST)) $addproductbutton= $_POST["addproductbutton"];
	
	if($addproductbutton)
	{
		
		$failedAddProduct=create_product($_SESSION['idUsers'],$Category,$Title,$Price,$Description,$Quantity);
		if ($failedAddProduct)
		{
			
			echo "<div class='error'>Τα παρακάτω προβλήματα παρουσιάστηκαν κατα την προσπάθια αποστολής της αίτησής σας</br>";
			foreach($failedAddProduct as $error)
			{
				if(isset($error)) echo "$error</br>";
			}
			echo "</div>";
		}
		else 
			echo "<h1>Η καταχώρηση ήταν επιτυχής</h1>";
	}

	if($failedAddProduct)
		{ ?>
			<h1>Add your Product</h1>

			<form method="post" action="index.php?action=newproduct"> 
				<table>
					<tr>
						<td>Τίτλος</td>
						<td><input type="text" name="Title" /></td>
					</tr>
					<tr>
						<td>Τιμή</td>
						<td><input type="text" id="price_in" name="Price" /><span id='euro_sign'>€<span></td>
					</tr>
					<tr>
						<td>Ποσότητα</td>
						<td><input type="text"  name="Quantity" value=1 /></td>
					</tr>
					<tr>
						<td>Κατηγορία</td>
						<td><select id="categ_in" name="Category"> 
							<?php 	$categories=read_categories(); foreach($categories as $cat) if($cat) echo "<option value=".$cat->idCategories.">".$cat->category."</option>";  ?>
							</select>
						</td>
					</tr>
					<tr>
						<td>Περιγραφή</td>
						<td><textarea name="Description" /></textarea></td>
					</tr>

					<tr><td><input type="submit" name="addproductbutton" value="Καταχώρηση"/></td></tr>
					</table>
			</form>

  <?php }
  }
  else echo "<h2> Πρέπει να συνδεθείτε για να μπορέσετε να ανεβάσετε αγγελία" ?>
  
  </div>
</div>
<div class="bottom_prod_box_big"><img src='images/details_box_bottom.gif' class='bottom_prod_box_big' /></div> 		