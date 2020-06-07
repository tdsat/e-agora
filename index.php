<?php
include_once 'header.php';
$mainsite= 'main.php';
if(isset($_GET['action'])){ 
    $mainsite=$_GET['action'];
    $mainsite=$mainsite.'.php';
}
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>e-agora.gr - Internet Marketplace</title>
<link rel="stylesheet" type="text/css" href="style.css" />
<link rel="icon" type="image/png"  href="images/favicon.png">
<!--[if IE 6]>
<link rel="stylesheet" type="text/css" href="iecss.css" />
<![endif]-->
<script>
PositionX = 100;
PositionY = 100;


defaultWidth  = 500;
defaultHeight = 500;
var AutoClose = true;

if (parseInt(navigator.appVersion.charAt(0))>=4){
var isNN=(navigator.appName=="Netscape")?1:0;
var isIE=(navigator.appName.indexOf("Microsoft")!=-1)?1:0;}
var optNN='scrollbars=no,width='+defaultWidth+',height='+defaultHeight+',left='+PositionX+',top='+PositionY;
var optIE='scrollbars=no,width=150,height=100,left='+PositionX+',top='+PositionY;
function popImage(id,imageTitle){
if (isNN){imgWin=window.open('about:blank','',optNN);}
if (isIE){imgWin=window.open('about:blank','',optIE);}
with (imgWin.document){
writeln('<html><head><title>Loading...</title><style>body{margin:0px;}</style>');writeln('<sc'+'ript>');
writeln('var isNN,isIE;');writeln('if (parseInt(navigator.appVersion.charAt(0))>=4){');
writeln('isNN=(navigator.appName=="Netscape")?1:0;');writeln('isIE=(navigator.appName.indexOf("Microsoft")!=-1)?1:0;}');
writeln('function reSizeToImage(){');writeln('if (isIE){');writeln('window.resizeTo(300,300);');
writeln('width=300-(document.body.clientWidth-document.images[0].width);');
writeln('height=300-(document.body.clientHeight-document.images[0].height);');
writeln('window.resizeTo(width,height);}');writeln('if (isNN){');       
writeln('window.innerWidth=document.images["Εικόνα"].width;');writeln('window.innerHeight=document.images["Εικόνα"].height;}}');
writeln('function doTitle(){document.title="'+imageTitle+'";}');writeln('</sc'+'ript>');
if (!AutoClose) writeln('</head><body bgcolor=ffffff scroll="no" onload="reSizeToImage();doTitle();self.focus()">')
else writeln('</head><body bgcolor=ffffff scroll="no" onload="reSizeToImage();doTitle();self.focus()" onblur="self.close()">');
var imageURL=document.getElementById('bigpic').src;
writeln('<img name="Εικόνα" src='+imageURL+' style="display:block"></body></html>');
close();		
}}

</script>
<script type='text/javascript'> 
function changePic(sourceId){
	document.getElementById('bigpic').src= document.getElementById(sourceId).src;
	} 
	

function submitForm(formid){
	document.getElementById(formid).submit();
}
</script>
<script type="text/javascript" src="js/boxOver.js"></script>
</head>
<body>

<div id="main_container">
	<div class="top_bar">
    	<div class="top_search">
        	<div class="search_text"> Quick Search</div>
			<form method="GET" action="index.php" id='search' >
				<input type="hidden" name="action" value="productlist" />
				<input type="text" class="search_input" name="s" />
				<a href=# ><img id='src_img' src="images/search.gif" onclick=submitForm('search') /></a>
			</form>
        </div>
	</div>
	<div id="header">
        
        <div id="logo">
            <a href="index.php"><img class="logoimg" src="images/logo.png" alt="" title="" border="0" /></a>
	    </div>
        
        <div class="oferte_content">
       	
        </div> <!-- end of oferte_content-->
        

    </div>
    
   <div id="main_content"> 
   
            <div id="menu_tab">
            <div class="left_menu_corner"></div>
                    <ul class="menu">
                         <?php include_once 'userstatus.php' ?>
                         <li></li>
                         <li class="divider"></li>
                         <li><a href="index.php?action=feedback" class="nav6">Contact</a>            </li>
                    </ul>
 <div class="right_menu_corner"></div>
            </div><!-- end of menu tab -->  
        
   <div class="left_content">
    <div class="title_box">Categories</div>
    
        <ul class="left_menu">
		<?php include_once 'categorylist.php'; ?>
        </ul>
      <div class="banner_adds"></div>    
        
    
   </div><!-- end of left content -->
   
   
   <div class="center_content">
   <?php include_once $mainsite; ?>
   </div><!-- end of center content -->
    
            
   </div><!-- end of main content -->
   
   
   
   <div class="footer">
   

        <div class="left_footer">
        <img src="images/footer_logo.png" alt="" title="" width="170" height="49"/>
        </div>
        <div class="right_footer">
        <a href="index.php">home</a>
        <a href="index.php?action=about">about</a>
        <a href="index.php?action=feedback">contact us</a>
        </div>   
   
   </div>                 


</div>
<!-- end of main_container -->
</body>
</html>