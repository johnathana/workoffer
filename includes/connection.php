<?php
	header('Content-Type: text/html ; charset=utf-8');
    //Create a database connection
    global $con;
	$con = mysql_connect("localhost","root");
    if(!$con){
        die("Database connection failed: ". mysql_error());
    }
	//Select a database to use
    $db_select = mysql_select_db("workoffer",$con);
    if(!$db_select){
        die("Database selection failed: ". mysql_error());
    }
	//Necessary conversion for greek
	$conversion = mysql_query("SET NAMES 'utf8'",$con);
	if(!$conversion){
        die("Conversion failed: ". mysql_error());
    }
	mysql_query("set character set 'utf8'", $con);
	
?>