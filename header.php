<?php 
    session_start();
    require_once 'dblib/dblib.php';
    DBLib::open();
	foreach (glob("buslibs/*.php") as $filename){
		include_once $filename;
	}
?>