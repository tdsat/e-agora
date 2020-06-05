<div class="top_prod_box_big"><img src='images/details_box_top.gif' class='top_prod_box_big' /></div>
<div class="center_prod_box_big">   
   
<?php
if(isset($_SESSION['idUsers']))
{
 
 $query ="SELECT idProducts
  FROM products
  WHERE  idOwner='{$_SESSION['idUsers']}'
  GROUP BY idProducts";
 $result_ids = DBLib::execute_query($query);
  
  
 $num_ids = mysql_num_rows($result_ids);
  
 
 if($num_ids==0) echo "<br>Δεν βρέθηκαν προϊόντα προς εμφάνιση";
 else
 {
  while($productId[] = mysql_fetch_array($result_ids,MYSQL_ASSOC));
  echo"<table class='yourstore' rules='all'>";
  
   echo"<th  align='left'>Title</th>";
   echo"<th  align='left'>Price</th>";
   echo "<th  align='left'>Descrption</th>";
   echo"<th align='left'>Quantity</th>";                  
   echo"<th width=360px>Image</th>";
   foreach($productId as $id)
   {
    if($id){
     $i=0;
     $products = read_product($id['idProducts']);
    
     $imid=get_imageid_of_product($id['idProducts']);
     array_pop($imid);
     if (isset($imid[0]))
     {
      echo"<tr>";
      echo"<td   align='left'>"; echo "<a href=index.php?action=productpage&productId=$products->idProducts>".$products->title."</td>";
      echo "<td  align='left'>".$products->price;echo "</td>";
      echo"<td  align='left'> <textarea id='yourstore'>".$products->description." </textarea></td>";   
      echo"<td align='left'>".$products->quantity."</td>";
      echo "<td>";
      $j=0;
      while(isset($imid[$j])){
       $src[$j]=read_image($imid[$j]->idImages);
       echo "<img class='storeimg'src='".$src[$j]."'/>";
       $j++;
      }
      echo "</td>";
      echo"</tr>";
     }
    
     else
     {
      echo"<tr>";
   
       echo"<td   align='left'>"; echo "<a href=index.php?action=productpage&productId=$products->idProducts>".$products->title."</td>";
       echo "<td align='left'>".$products->price."</td>";
       echo"<td align='left'> <textarea id='yourstore'>".$products->description." </textarea> </td>";   
       echo"<td  align='left'>".$products->quantity."</td>";
       echo "<td></td>";
       echo"</tr>";
     }
    }
   }
  }
   
 echo "</table>";
 
 }
 
else
 echo "Πρέπει να συνδεθείτε για να δείτε τα προϊόντα σας";
?>
</div>
<div class="bottom_prod_box_big"><img src='images/details_box_bottom.gif' class='bottom_prod_box_big' /></div>