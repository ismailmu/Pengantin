<?php
	// *********************************************
	// File index.php
	// *********************************************
	
	session_start();
	
	if(!session_is_registered(user)){
		header("location:../index.php");
	}
	require "include/config_db.php";			//Pemanggilan koneksi database.
	
	$waktu=time();
	$counter=$_SESSION['duration']+1800;
	
	if($_SESSION['duration'] && ($waktu>$counter)) {
		session_destroy();
		$_SESSION['duration']=time();
		header("location:../index.php");
		exit();
	}
	else $_SESSION['duration']=time();
	
	if($_GET['action']=='logout')
	{  	 	
		session_destroy();
		header("location:../index.php");
		exit();
	}
	else
	{
		require "include/config_functionclass.php";			//Pemanggilan fungsi class templete.
		require "include/variable.php";

		//------------------------------------------------------------------------------------------------------------------------------------------------------
		if($_GET['action']=='konsultasi') include("konsultasi.php");
		else include("home.php");
		
		//----------------------------------------------------------Penjabaran Class Templete.
		$tpl = new template;
		$tpl->define_theme("layout.html");
		$tpl->define_tag("{BODY}",$body);
		$tpl->parse();
		$tpl->printproses();
		//------------------------------------------------------------------------------------------------------------------------------------------------------
	}
?>