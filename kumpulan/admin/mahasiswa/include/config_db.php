<?php
	// ***************************************************
	// File config.php
	// File ini akan diperlukan oleh file-file php lainnya
	// ***************************************************
	
	if(ereg("config_db.php", $PHP_SELF))
	{
		header("location:../../index.php");
		die;
	}
	
	//---- konfigurasi untuk database
	define('DB_HOST','localhost');
	define('DB_USER','root');
	define('DB_PASSWORD','');
	define('DB_DATABASE','sisfo_kp');
	
	$con = mysql_connect(DB_HOST,DB_USER,DB_PASSWORD)
			or die("Error Could not connect");
	
	$db = mysql_select_db(DB_DATABASE, $con)
					or die("Error Could not select database");
?>