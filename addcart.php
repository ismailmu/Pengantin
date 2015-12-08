<?php
	session_start();
	require "include/config_session.php";
	
	if($_SESSION['waktu'] || $_SESSION['id_product']) {
		if(($_SESSION['waktu']+18000)<WAKTU) {
			session_unregister(id_product);
			session_unregister(waktu);
			session_destroy();
		}
	}
	$_SESSION['waktu']=WAKTU;
	$_SESSION['id_product'].=($_SESSION['id_product'])?"&".$_GET['id_product']:$_GET['id_product'];
	
	echo "Proses Pemesan Telah Berhasil !!!";
?>