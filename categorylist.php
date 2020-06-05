<?php
$categories=read_categories();
$class=array('even','odd');
$i=0;
if($categories)
while($categories[$i]) echo "<li class='".$class[$i%2]."'><a href='index.php?action=productlist&cat=".$categories[$i]->idCategories."' >".$categories[$i++]->category."</a></li>";

?>