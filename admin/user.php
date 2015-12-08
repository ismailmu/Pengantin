<?php
	// *********************************************
	// File index.php
	// *********************************************
	
	session_start();
	
	require "../include/config_session.php";
	
	if(!session_is_registered(user)){
		header("location:../index.php");
	}
			
	$waktu=time();
	$counter=$_SESSION['waktu']+1800;
	
	if($_SESSION['waktu'] && ($waktu>$counter)) {
		session_unregister(user);
		session_unregister(waktu);
		header("location:index.php");
		exit();
	}
	else session_register(waktu);;
	
	if($_GET['act']=='logout')
	{  	 	
		session_unregister(user);
		session_unregister(waktu);
		header("location:index.php");
		exit();
	}
	else
	{	
		require "../include/config_functionclass.php";			//Pemanggilan fungsi class templete.
		//------------------------------------------------------------------------------------------------------------------------------------------------------
		$act=$_GET['act'];
		include("left.php");
		
		switch($act) {
			case'kategori':
				include('kategori.php');
				break;
			case'satuan':
				include('satuan.php');
				break;
			case'berita':
				include('berita.php');
				break;
			case'pembayaran':
				include('pembayaran.php');
				break;
			case'pelanggan':
				include('pelanggan.php');
				break;
			case'pengunjung':
				include('pengunjung.php');
				break;
			default:
				include("product.php");
				break;
		}
		
		//----------------------------------------------------------Penjabaran Class Templete.
		$tpl = new template;
		$tpl->define_theme("layout.html");
		$tpl->define_tag("{BODY}",$body);
		$tpl->define_tag("{LEFT}",$left);
		$tpl->parse();
		$tpl->printproses();
		//------------------------------------------------------------------------------------------------------------------------------------------------------
	}
?>