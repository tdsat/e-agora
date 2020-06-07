<html>
<head>
</head>

<body>
<table border="1">
<tr>
<td>Name</td>
<td>Surname</td>
<td>Username</td>
</tr>

<? php
        include_once 'buslibs/users2.php';        
        echo $username1=$_SESSION['username'];
		
		
		$user1=user_read($username);
	
	while($user1)
	{
	   echo"<tr><td>".$row['lastName']."</td>";
	   echo"<tr><td>".$row['firstName']."</td>";
	   echo"<tr><td>".$row['username']."</td></tr>";
	}
?>
</table>
</body>
</html>