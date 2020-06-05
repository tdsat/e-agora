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
* idUser         INT           | Αυτόματη αρίθμηση. ΜΗΝ ΟΡΙΣΕΤΕ ΧΕΙΡΟΚΙΝΗΤΑ
* -----------------------------|------------------------------------------- 
* username  VarC[25](U,NN)     |  Αυτές οι μεταβλητές είναι ΑΠΑΡΑΙΤΗΤΕΣ.
* password  VarC[25](Not Null) |  Αν δεν οριστούν, οι ρουτίνες επιστρέφουν
* email     VarC[100](Not Null)|  μυνήματα λάθους
* -----------------------------|-------------------------------------------
* firstName     VarC[45]       |
* city          VarC[45]       |  Προεραιτικές μεταβλητές.
* lastName      VarC[45]       |  Οι προεπιλεγμένες τιμές τους είναι NULL.
* country       VarC[45]       |  Επιβεβαιώνεται η ακεραιότητα των εισόδων
* postalCode    VarC[15]       |  αλλά όχι η ορθότητα (δηλαδή κάποιος μπορεί
* streetAddress VarC[45]       |  να βάλει ότι θέλει, εφόσων δεν δημιουργεί
* phoneNumber   VarC[25]       |  πρόβλημα στην λειτουργία της εφαρμογής)
* dateOfBirth   VarC[45]       |  
* role          VarC[20]       |
*/


/*
    * CREATE USER
    * Return Values:
    *    = 0: Success
    *   != 0: Error
    *   
    *   Σε περίπτωση λάθους, ένας πίνακας με όλα τα μηνύματα λάθους επιστρέφεται.
    * 
    * ΧΡΗΣΗ
    *  H user_create δέχεται σαν ορίσματα τα στοιχεία του πίνακα users.
    *  Στα απαραίτητα ορίσματα κάνει έλεγχο και επιβεβαιώνει την ακεραιώτητά τους.
    *  Αν κάποιο απο αυτά δεν έχει οριστεί, επιστρέφει μήνυμα σφάλματος.
    *  Οι προεραιτικές μεταβλητές έχουν ως προκαθορισμένη τιμή το NULL
    *  
*/
function user_create($username, $password, $email, $fName=null, $lName=null, $address=null, $pcode=null, $city=null,$country=null,$phone=null,$dob=null){
    $errorList = NULL;
    
    //Έλεγχος μεταβλητών
    if (validate($username,'string',2,25,FALSE))      $errorList[]='Το όνομα χρήστη'.validate($username,'string',4,25,FALSE);
    if (validate($password,'string',2,25,FALSE))      $errorList[]='Ο κωδικός'.validate($password,'string',4,25,FALSE);
    if (validate($email,'string',NULL,60,FALSE))      $errorList[]='Το E-mail'.validate($email,'string',4,60,FALSE);
    if (validate($fName,'string',NULL,25))            $errorList[]='Το όνομα'.validate($fName,'string',NULL,25);
    if (validate($lName,'string',NULL,25))            $errorList[]='Το επίθετο'.validate($lName,'string',NULL,25);
    if (validate($address,'string',NULL,25))          $errorList[]='Η διεύθυνση'.validate($address,'string',NULL,25);
    if (validate($pcode,'string',NULL,10))            $errorList[]='Ο ταχυδρομικός κωδικός'.validate($pcode,'string',NULL,10);
    if (validate($city,'string',NULL,25))             $errorList[]='Το όνομα της πόλης'.validate($city,'string',NULL,25);
    if (validate($country,'string',NULL,25))          $errorList[]='Το όνομα της χώρας'.validate($country,'string',NULL,25);
    if (validate($phone,'string',NULL,25))            $errorList[]='Ο αριθμός τηλεφώνου'.validate($phone,'string',NULL,25);
    
    
    //Αφαίρεση php και html taqs
    $username=strip_tags($username);
    $fName=strip_tags($fName);
    $lName=strip_tags($lName);
    $address=strip_tags($address);
    $pcode=strip_tags($pcode);
    $city=strip_tags($city);
    $country=strip_tags($country);
    $phone=strip_tags($phone);
    $email=strip_tags($email);
    
    
    //Προστασία από SQL injection
    $username = mysql_real_escape_string($username);
    //Ελέγχουμε αν υπάρχει ήδη το όνομα χρήστη
    if (user_read($username)) $errorList[]="That username is taken";
    
    //Προστασία για τις υπόλοιπες μεταβλητές
    $password = mysql_real_escape_string($password);
    $fName = mysql_real_escape_string($fName);
    $address = mysql_real_escape_string($address);
    $pcode = mysql_real_escape_string($pcode);
    $city = mysql_real_escape_string($city);
    $country = mysql_real_escape_string($country);
    $email= mysql_real_escape_string($email);
    $phone = mysql_real_escape_string($phone);
    

    //  Τελικός έλεγχος ημερομηνίας. Αν κάποιο απο τα πεδία είναι εκτός ορίον,
    //  αλλάζει στο πλησιέστερο επιτρεπτό όριο  
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
    if ($result === FALSE) return $errorList[]="Υπήρξε κάποιο πρόβλημα. Δοκιμάστε ξανά.";

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

    //Προστασία από SQL injection		
    $username = mysql_real_escape_string($username);

    $query = "SELECT * FROM `users` WHERE `username` = '{$username}'";
    DBLib::getrows($query, $rows, $num);

    //Αν δεν βρεθεί εγγραφή, επιστρέφουμε NULL
    if ($num == 0) return NULL;

    $user = mysql_fetch_object($rows);

    return $user;
}
/*
    * UPDATE USER
    * Επιστρεφόμενες τιμές :
    *    = 0: Επιτυχής εκτέλεση
    *   != 0: Πρόβλημα κατα την διάρκεια εκτέλεσης
    *   
    *   Σε περίπτωση λάθους, ένας πίνακας με όλα τα μηνύματα λάθους επιστρέφεται.
    *   ΧΡΗΣΗ:
    *   Η συνάρτηση αλλάζει τα στοιχεία ενός εγγεγραμένου χρήστη.
 */
function user_update($username, $password, $email, $fName=null, $lName=null, $address=null, $pcode=null, $city=null,$country=null,$phone=null,$dob=null ){
    $errorList = NULL;
    
    //Έλεγχος μεταβλητών
    if (validate($password,'string',4,20,FALSE))      $errorList[]='Password'.validate($password,'string',4,20,FALSE);
    if (validate($email,'string',NULL,60,FALSE))      $errorList[]='E-mail'.validate($email,'string',4,60,FALSE);
    if (validate($fName,'string',NULL,20))            $errorList[]='First name'.validate($fName,'string',NULL,20);
    if (validate($lName,'string',NULL,20))            $errorList[]='Last name'.validate($lName,'string',NULL,20);
    if (validate($address,'string',NULL,20))          $errorList[]='Address'.validate($address,'string',NULL,20);
    if (validate($pcode,'string',NULL,10))            $errorList[]='Postal Code'.validate($pcode,'string',NULL,10);
    if (validate($city,'string',NULL,20))             $errorList[]='City name'.validate($city,'string',NULL,20);
    if (validate($country,'string',NULL,20))          $errorList[]='Country name'.validate($country,'string',NULL,20);
    if (validate($phone,'string',NULL,20))            $errorList[]='Phone Number'.validate($phone,'string',NULL,20);
    
    //Αφαίρεση php και html taqs
    $username=strip_tags($username);
    $fName=strip_tags($fName);
    $lName=strip_tags($lName);
    $address=strip_tags($address);
    $pcode=strip_tags($pcode);
    $city=strip_tags($city);
    $country=strip_tags($country);
    $phone=strip_tags($phone);
    $email=strip_tags($email);

    //Προστασία απο SQL injection
    $password = mysql_real_escape_string($password);
    $fName = mysql_real_escape_string($fName);
    $address = mysql_real_escape_string($address);
    $pcode = mysql_real_escape_string($pcode);
    $city = mysql_real_escape_string($city);
    $country = mysql_real_escape_string($country);
    $email= mysql_real_escape_string($email);
    $phone = mysql_real_escape_string($phone);
    
    //  Τελικός έλεγχος ημερομηνίας. Αν κάποιο απο τα πεδία είναι εκτός ορίον,
    //  αλλάζει στο πλησιέστερο επιτρεπτό όριο  
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
    * Επιστρεφόμενες τιμές :
    *    = 0: Επιτυχής εκτέλεση
    *   != 0: Πρόβλημα κατα την διάρκεια εκτέλεσης
    *   
    *   Σε περίπτωση λάθους, ένας πίνακας με όλα τα μηνύματα λάθους επιστρέφεται.
    *   ΧΡΗΣΗ :
    *   Η συνάρτηση δέχεται σαν όρισμα το username ενός χρήστη και, 
    *   εφόσων βρεθεί , διαγράφει τα στοιχεία του.
    *
 */
function user_delete($username){
    if ($username==NULL) exit('Πρέπει να δώσετε username προς διαγραφή');

    //    Προστασία από SQL injection
    $username = mysql_real_escape_string($username);

    //Έλεγχος αν υπάρχει ο χρήστης
    $user = user_read($username);
    if(!$user) return 'Ο χρήστης δεν υπάρχει';

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

    //Αν δεν βρεθεί εγγραφή, επιστρέφουμε NULL
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