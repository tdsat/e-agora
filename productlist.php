        	<div class="top_prod_box_big"><img src='images/details_box_top.gif' class='top_prod_box_big' /></div>
            <div class="center_prod_box_big">  

<?php
	$query=NULL;

    if(isset($_GET['s'])){   
        $name=$_GET['s'];
        $name=  mysql_real_escape_string($name);
        if(strlen($name)>=3) $query="SELECT * FROM `products` WHERE `title` LIKE '%{$name}%'";
		else echo ("You must added at least 3 character to search");
    }
    else if(isset($_GET['cat'])){
        $cat=$_GET['cat'];
        $cat=  mysql_real_escape_string($cat);
        $query="SELECT * FROM `products` WHERE `idCategory`=$cat";
    }
    else if(isset($_GET['user'])){
        $user=$_GET['user'];
        $id=user_get_id($user);
        if($id) $query="SELECT * FROM `products` WHERE `idOwner`=$id";
    }

    if($query){
		$result=DBLib::execute_query($query);
		$num=mysql_num_rows($result);
		if ($num != 0) { ?>
			<table class="product_list">
			<tr>
				<th>Title</th>
				<th>Price</th>
				<th>Description</th>
			</tr>
	<?php
			$row = mysql_fetch_array($result);
			while($row)
			{
				echo "<tr>";
				echo"<td id='link'><a href='index.php?action=productpage&productId={$row['idProducts']}' >".$row['title']."</td>";
				echo"<td>".$row['price']."€</td>";
				echo"<td id='nostyle'>".$row['description']."</td></tr>";
				echo"</tr>";
				$row = mysql_fetch_array($result);
			}
		echo "</table>";
		}
		else echo "Nothing found";
	}
?>
			</div>
			<div class="bottom_prod_box_big"><img src='images/details_box_bottom.gif' class='bottom_prod_box_big' /></div>