<?php

function validate(&$var,$expType=NULL, $min=NULL, $max=NULL,$can_be_null=TRUE)
{   
    if(!$can_be_null && ($var==NULL || $var=='')) return ' πρέπει να οριστεί';
    else{ 
		if($expType=='number') if(!is_numeric($var)) return ' δεν είναι σωστού τύπου';
		if($expType=='digit') 	if(!ctype_digit($var)) return ' δεν είναι σωστού τύπου';
			if ($expType=='string'){
				$var=trim($var);
				$len=strlen($var);
				if($min)
					if($len<$min) return ' είναι πολύ κοντό(ς)';
				if($max)
					if($len>$max) return ' είναι πολύ μακρύ(ς)';
			}	
			else if($expType='number' or $expType='digit'){
					$len=$var;
				if($min)
					if($len<$min) return ' είναι πολύ μικρός/ή';
				if($max)
					if($len>$max) return ' είναι πολύ μεγάλος/ή';
			}
    return NULL;
    }
}


function get_field_value($field,$table,$key,$value){
$query="SELECT `$field` FROM `$table` WHERE `$key` = $value";
$result=DBLib::getresult($query);

if(!$result) return NULL;
return $result;
}

function died($error) {
	echo "We are sorry, but there are errors found with your Feedback form.<br /><br />";
	echo $error."<br /><br />";
	echo "Please go back and fix these errors.<br /><br />";
	die();
}


?>
