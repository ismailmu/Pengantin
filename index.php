<?php
	// *********************************************
	// File index.php
	// *********************************************
	
	session_start();
	require "include/config_session.php";
	require "include/config_functionclass.php";			//Pemanggilan fungsi class templete.
	
	mysql_query("insert into statistik_pengunjung(ip_pengunjung,tanggal,act) values('".$_SERVER['REMOTE_ADDR']."','".TANGGAL."','$_GET[act]')");

	$title=":: House of Agus Salon, Bridal dan Taylor ::";
	include("judul-kategori.php");
	$isi="";
	
	if($_GET['addcard']) {
		if($_SESSION['waktu']) {
			if(($_SESSION['waktu']+18000)<WAKTU) {
				session_unregister(id_product);
				session_unregister(waktu);
			}
		}
		$_SESSION['waktu']=WAKTU;
		$_SESSION['id_product']=($_SESSION['id_product'])?"&".$_SESSION['id_product']:$_SESSION['id_product'];
		
		$isi.="Proses Pemesan $_GET[id_product] Telah Berhasil !!!";
	}
	if($_GET['view']) {
		$isi.="
				<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" align=\"center\">
					<tr><td class=\"dimage\"><img src=\"detail/".$_GET['view'].".jpg\" class=\"image\"></td></tr>
				</table>
			";
	}
	
	switch($_GET['act']) {
		case "about" :
			include("about.php");
			break;
		case "bayar" :
			include("pembayaran.php");
			break;
		case "cara" :
			include("cara-belanja.php");
			break;
		case "contact" :
			include("contact.php");
			break;
		case "product" :
			include("product.php");
			break;
		case "berita" :
			include("berita.php");
			break;
		default :
			include("home.php");
			break;
	}

	//----------------------------------------------------------Penjabaran Class Templete.
	
	$tpl = new template;
	$tpl->define_theme("layout.html");
	$tpl->define_tag("{TITLE}",$title);
	$tpl->define_tag("{JUDUL_KATEGORI}",$judul_kategori);
	$tpl->define_tag("{ISI}",$isi);
	$tpl->define_tag("{POSTING-LARIS}",$posting_laris);
	$tpl->define_tag("{POSTING-BARU}",$posting_baru);
	$tpl->parse();
	$tpl->printproses();
	//------------------------------------------------------------------------------------------------------------------------------------------------------
?>