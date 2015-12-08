<?php
	// ***************************************************
	// File config_session.php
	// File ini akan diperlukan oleh file-file php lainnya
	// ***************************************************
	
	if(ereg("config_session.php", $PHP_SELF))
	{
		header("location:../index.php");
		die;
	}
		
	require "config_master.php";
	require "config_db.php";			//Pemanggilan koneksi databases
	require "function.php";
?>