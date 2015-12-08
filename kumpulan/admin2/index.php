<?php
	// *********************************************
	// File Index.php
	// *********************************************
	
	session_start();
	if(!session_is_registered(email) || !session_is_registered(admin)){
		header("location:../index.php");
	}
	require "include/config_db.php";			//Pemanggilan koneksi database.
	
	$action=$_GET['action'];
	
	$counter=$_SESSION['duration']+1800;
	
	if($_SESSION['duration'] && (WAKTU>$counter)) {
		session_destroy();
		$_SESSION['duration']=time();
	}
	else $_SESSION['duration']=time();
	
	if($action=='logout')
	{  	 	
		session_destroy();
		header("location:../");
		exit();
	}
	else
	{
	
		require "include/config_functionclass.php";			//Pemanggilan fungsi class templete.
		require "include/function.php";
		require "include/variable.php";
		
		//-----------------------------------------------------------------------------------------------------------------------------------------------------
		$bg1=rand(34,220);
		$bg2=rand(34,220);
		$bg3=rand(34,220);
		
		$bgcolor="$bg1,$bg2,$bg3";
		$onload="onload=\"header();\"";
		//-----------------------------------------------------------------------------------------------------------------------------------------------------
		if($_GET['action']) include($_GET['action'].".php");
		else include("home.php");
		
		require "include/left.php";
		require "include/posting.php";
	
		//----------------------------------------------------------Penjabaran Class Templete.
		$tpl = new template;
		$tpl->define_theme("layout.html");
		$tpl->define_tag("{SCRIPT}",$script);
		$tpl->define_tag("{ONLOAD}",$onload);
		$tpl->define_tag("{LEFT}",$left);
		$tpl->define_tag("{BGCOLOR}",$bgcolor);
		$tpl->define_tag("{PENCARIAN}",$pencarian);
		$tpl->define_tag("{ISI}",$isi);
		$tpl->define_tag("{POSTING}",$posting);
		$tpl->define_tag("{MENUKATEGORI}",$menukategori);
		$tpl->define_tag("{JUAL}",$jual);
		$tpl->parse();
		$tpl->printproses();
		//------------------------------------------------------------------------------------------------------------------------------------------------------
	
	}
?>