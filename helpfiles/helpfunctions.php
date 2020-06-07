<?php

function validate(&$var,$expType=NULL, $min=NULL, $max=NULL,$can_be_null=TRUE)
{   
    if(!$can_be_null && ($var==NULL || $var=='')) return ' must be set';
    else{ 
		if($expType=='number') if(!is_numeric($var)) return ' is not the correct type';
		if($expType=='digit') 	if(!ctype_digit($var)) return ' is not the correct type';
			if ($expType=='string'){
				$var=trim($var);
				$len=strlen($var);
				if($min)
					if($len<$min) return ' is too short';
				if($max)
					if($len>$max) return ' is too long';
			}	
			else if($expType='number' or $expType='digit'){
					$len=$var;
				if($min)
					if($len<$min) return ' is too low';
				if($max)
					if($len>$max) return ' is too high';
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
