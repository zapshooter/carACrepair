<?php
date_default_timezone_set("Asia/Kolkata");

	function db_connect(){
		define("HOSTNAME","localhost");
		define("DB_NAME","carwaleac_accar");
		define("DB_USERNAME","root");
		define("DB_PASS","");
	try{
	   $con = new PDO('mysql:host='.HOSTNAME.';dbname='.DB_NAME, DB_USERNAME, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
	   $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	   $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
	   $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);   
	   return $con;
	}
	catch (PDOException $e) {
	    echo "Error Connecting with Database".$e->getmessage();
	}
		return null;
	}
?>