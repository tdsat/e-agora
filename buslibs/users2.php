<?php
include_once 'dblib/dblib.php';
include_once 'helpfiles/helpfunctions.php';
/* Input validation and error handling for the 'users' table
* Contains routines for : 
*  User Login
*  User Creation
*  User Delete
*  User Update
*  User Login
* User Logout
* Designed for a database with  the following fields
* -------------------------------------------------------------------------
* idUser         INT           | Auto increment. DO NOT SET MANUALLY
* -----------------------------|------------------------------------------- 
* username  VarC[25](U,NN)     |  These variables are REQUIRED
* password  VarC[25](Not Null) |  If they are not set, the subroutines
* email     VarC[100](Not Null)|  return error messages
* -----------------------------|-------------------------------------------
* firstName     VarC[45]       |
* city          VarC[45]       |  Optional variables
* lastName      VarC[45]       |  Their default values are NULL.
* country       VarC[45]       |  Input integrity is confirmed but not
* postalCode    VarC[15]       |  the correctness (so someone could
* streetAddress VarC[45]       |  input anything as long as it doesn't
* phoneNumber   VarC[25]       |  cause problems in the operation of
* dateOfBirth   VarC[45]       |  the application)
* role          VarC[20]       |
*/


/*
    * CREATE USER
    * Return Values:
    *    = 0: Success
    *   != 0: Error
    *   
    *   In case of an error, an array with all the error messages is returned.
    * 
    * USAGE
    *  user_create accepts the fields of the users table as arguments
    *  For required fields a check is run and their integrity is confirmed.
    *  If any of them is not set, an error message is returned
    *  Optional variables have a default value of NULL
    *
*/
function user_create($username, $password, $email, $fName=null, $lName=null, $address=null, $pcode=null, $city=null,$country=null,$phone=null,$dob=null){
    $errorList = NULL;
    
    //Check variables
    if (validate($username,'string',2,25,FALSE))      $errorList[]='The user name'.validate($username,'string',4,25,FALSE);
    if (validate($password,'string',2,25,FALSE))      $errorList[]='The password'.validate($password,'string',4,25,FALSE);
    if (validate($email,'string',NULL,60,FALSE))      $errorList[]='The E-mail'.validate($email,'string',4,60,FALSE);
    if (validate($fName,'string',NULL,25))            $errorList[]='The name'.validate($fName,'string',NULL,25);
    if (validate($lName,'string',NULL,25))            $errorList[]='The surname'.validate($lName,'string',NULL,25);
    if (validate($address,'string',NULL,25))          $errorList[]='The address'.validate($address,'string',NULL,25);
    if (validate($pcode,'string',NULL,10))            $errorList[]='The post code'.validate($pcode,'string',NULL,10);
    if (validate($city,'string',NULL,25))             $errorList[]='The city name'.validate($city,'string',NULL,25);
    if (validate($country,'string',NULL,25))          $errorList[]='The country name'.validate($country,'string',NULL,25);
    if (validate($phone,'string',NULL,25))            $errorList[]='The phone number'.validate($phone,'string',NULL,25);
    
    
    //Remove php and html taqs
    $username=strip_tags($username);
    $fName=strip_tags($fName);
    $lName=strip_tags($lName);
    $address=strip_tags($address);
    $pcode=strip_tags($pcode);
    $city=strip_tags($city);
    $country=strip_tags($country);
    $phone=strip_tags($phone);
    $email=strip_tags($email);
    
    
    //Protect against SQL injection
    $username = mysql_real_escape_string($username);
    //Check if the username already exists
    if (user_read($username)) $errorList[]="That username is taken";
    
    //Protection for the rest of the variables
    $password = mysql_real_escape_string($password);
    $fName = mysql_real_escape_string($fName);
    $address = mysql_real_escape_string($address);
    $pcode = mysql_real_escape_string($pcode);
    $city = mysql_real_escape_string($city);
    $country = mysql_real_escape_string($country);
    $email= mysql_real_escape_string($email);
    $phone = mysql_real_escape_string($phone);
    

    //  Final check for the dates. If any of the values is outside of bounds
    //  they are set to the closest allowed value
    if ($dob["day"]<1) $dob["day"]=1;
    if ($dob["day"]>30) $dob["day"]=30;
    if ($dob["month"]<1) $dob["month"]=1;
    if ($dob["month"]>12) $dob["month"]=12;
    if ($dob["year"]<1900) $dob["year"]=1900;
    if ($dob["year"]>2300) $dob["year"]=2300;

    $dob=$dob["year"].'-'.$dob["month"].'-'.$dob["day"];
    
    if($errorList==NULL)
    {
        $query = "INSERT INTO `users` (username, password, firstName, lastName, streetAddress, postalCode, city, country, email, phoneNumber,dateOfBirth,role)
        VALUES ('$username', '$password', '$fName', '$lName','$address','$pcode','$city','$country','$email','$phone','$dob','user')";
        $result = DBLib::execute_query($query);
    }
    else
        return $errorList;
    if ($result === FALSE) return $errorList[]="There was an error. Try again.";

    return 0;
}


/*
    * READ USER
    * Return Values:
    *   - If the user was found, an object containing all user properties is returned
    *   - If the user was not found, NULL is returned 
    */
function user_read($username){
    $rows = NULL;
    $num = 0;

    //Protect against SQL injection
    $username = mysql_real_escape_string($username);

    $query = "SELECT * FROM `users` WHERE `username` = '{$username}'";
    DBLib::getrows($query, $rows, $num);

    //If no record is found, return NULL
    if ($num == 0) return NULL;

    $user = mysql_fetch_object($rows);

    return $user;
}
/*
    * UPDATE USER
    * Return values :
    *    = 0: Successful execution
    *   != 0: Problem during execution
    *   
    *   In case of an error, an array with all the error messages is returned.
    *   USAGE:
    *   The function changes the information of a registered user.
 */
function user_update($username, $password, $email, $fName=null, $lName=null, $address=null, $pcode=null, $city=null,$country=null,$phone=null,$dob=null ){
    $errorList = NULL;
    
    //Check variables
    if (validate($password,'string',4,20,FALSE))      $errorList[]='Password'.validate($password,'string',4,20,FALSE);
    if (validate($email,'string',NULL,60,FALSE))      $errorList[]='E-mail'.validate($email,'string',4,60,FALSE);
    if (validate($fName,'string',NULL,20))            $errorList[]='First name'.validate($fName,'string',NULL,20);
    if (validate($lName,'string',NULL,20))            $errorList[]='Last name'.validate($lName,'string',NULL,20);
    if (validate($address,'string',NULL,20))          $errorList[]='Address'.validate($address,'string',NULL,20);
    if (validate($pcode,'string',NULL,10))            $errorList[]='Postal Code'.validate($pcode,'string',NULL,10);
    if (validate($city,'string',NULL,20))             $errorList[]='City name'.validate($city,'string',NULL,20);
    if (validate($country,'string',NULL,20))          $errorList[]='Country name'.validate($country,'string',NULL,20);
    if (validate($phone,'string',NULL,20))            $errorList[]='Phone Number'.validate($phone,'string',NULL,20);
    
    //Remove php and html taqs
    $username=strip_tags($username);
    $fName=strip_tags($fName);
    $lName=strip_tags($lName);
    $address=strip_tags($address);
    $pcode=strip_tags($pcode);
    $city=strip_tags($city);
    $country=strip_tags($country);
    $phone=strip_tags($phone);
    $email=strip_tags($email);

    //Protect against SQL injection
    $password = mysql_real_escape_string($password);
    $fName = mysql_real_escape_string($fName);
    $address = mysql_real_escape_string($address);
    $pcode = mysql_real_escape_string($pcode);
    $city = mysql_real_escape_string($city);
    $country = mysql_real_escape_string($country);
    $email= mysql_real_escape_string($email);
    $phone = mysql_real_escape_string($phone);

    //  Final check for the dates. If any of the values is outside of bounds
    //  they are set to the closest allowed value
    if ($dob["day"]<1 || $dob["day"]==NULL) $dob["day"]=1;
    if ($dob["day"]>30) $dob["day"]=30;
    if ($dob["month"]<1 || $dob["month"]==NULL) $dob["month"]=1;
    if ($dob["month"]>12) $dob["month"]=12;
    if ($dob["year"]<1900 || $dob["year"]==NULL) $dob["year"]=1900;
    if ($dob["year"]>2300) $dob["year"]=2300;

    $dob=$dob["year"].'-'.$dob["month"].'-'.$dob["day"];


    if($errorList==NULL)
    {
        $query = "UPDATE `users` SET `password` = '{$password}', `firstName` = {$fName},`lastName` = '{$lName}',`streetAddress`= '{$address}', `postalCode`='{$pcode}',`city`='{$city}',`country`='{$country}', `email`='{$email}', `phoneNumber`='{$phone}',`dateOfBirth`='{$dob}' WHERE `username` = '{$username}'";
        $result = DBLib::execute_query($query);
    }
    else
        return $errorList;
    if ($result === FALSE) return $errorList[]="There was an error with your request. Please try again.";
    
    return $result;
}
/*
    * DELETE USER
    * Return values :
    *    = 0: Successful execution
    *   != 0: Problem during execution
    *   
    *   In case of an error, an array with all the error messages is returned.
    *   USAGE :
    *   The function accepts as the argument the username and, if found,
    *   deletes its data
    *
 */
function user_delete($username){
    if ($username==NULL) exit('Must give a username to delete');

    //    Protection against SQL injection
    $username = mysql_real_escape_string($username);

    //Check if the user exists
    $user = user_read($username);
    if(!$user) return "The user doesn't exist";

    $query = "DELETE FROM `users` WHERE `username` = '$username'";
    $result = DBLib::execute_query($query);
    return $result;
}

//Login function
function login($username, $password)
    {
        //session_start();
        $user = user_read($username);

        //user does not exist
        if (!$user) return FALSE;

        if ($user->password == $password)
        {
            $_SESSION['username'] = $username;
            $_SESSION['idUsers']= $user->idUsers;
            $_SESSION['role']=$user->role;
            return TRUE;
        }
        else 
        return FALSE;
    }
		
function logout()
    {
       // session_start();
		$_SESSION=array();
		session_unset();
        session_destroy();
        session_write_close();
        setcookie(session_name(),'',0,'/');
        session_regenerate_id(true);
    }
	
    
function user_read_id($id){
    $rows = NULL;
    $num = 0;

    $query = "SELECT * FROM `users` WHERE `idUsers` = $id";
    DBLib::getrows($query, $rows, $num);

    //If no record is found, return NULL
    if ($num == 0) return NULL;

    $user = mysql_fetch_object($rows);

    return $user;
}

function user_get_id($username){
    $username=  mysql_real_escape_string($username);
    
    $query="SELECT `idUsers` FROM `users` WHERE `username`='{$username}'";
	$result=DBLib::getresult($query);

	if(!$result) return NULL;
	return $result;
}

	
	
?>