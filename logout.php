<form method="POST">
<input class="logout_btn" type="submit" name="logoutbutton" value="Έξοδος">
</form>

<?php 
    include_once 'buslibs/users2.php';
    $dologout=false;
    if(isset($_POST['logoutbutton']))   $dologout=$_POST['logoutbutton'];
    
    if($dologout){
        logout();
        echo "<META HTTP-EQUIV='refresh' CONTENT='0'>";
    }

?>