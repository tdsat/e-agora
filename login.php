<li class='text1'>Όνομα</li><form method='post' ><input type='text' name='username' class='login' /><li class="text1">Κωδικός</li><input type='password' name='password' class='login' /> <input type='submit' name='loginbutton' value='Είσοδος' class='login_btn' /></form>
<?php
    $loginbutton=false;
    
    if(isset($_POST['username'])) $username=$_POST['username'];
    if(isset($_POST['password'])) $password=$_POST['password'];
    if(isset($_POST['loginbutton'])) $loginbutton=$_POST['loginbutton'];
    
    if ($loginbutton)
    {
        $_SESSION['loggedin']=  login($username,$password);
       echo "<META HTTP-EQUIV='refresh' CONTENT='0'>";
    }
        
?>
