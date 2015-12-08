<?php
	// ***************************************************
	// File config_master.php
	// File ini akan diperlukan oleh file-file php lainnya
	// ***************************************************
	
	if(ereg("config_master.php", $PHP_SELF))
	{
		header("location:../index.php");
		die;
	}
	
	$array_tgl29=array(31,29,31,30,31,30,31,31,30,31,30,31);
	$array_tgl28=array(31,28,31,30,31,30,31,31,30,31,30,31);
	$array_bln=array("Jan","Feb","Mar","Apr","Mei","Jun","Jul","Ags","Sep","Okt","Nov","Des");
	$array_bulan=array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
	$array_hari=array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu");

	//---- konfigurasi untuk database
	define('DB_HOST','localhost');
	define('DB_USER','joglbcom_chusya');
	define('DB_PASSWORD','281084');
	define('DB_DATABASE','joglbcom_butik');
	define('TANGGAL',date("Y-m-d H:i:s"),true);
	define('WAKTU',time(),true);
	define('VALEMAIL',"^.+@.+\..+$",true);
	define('VALCHAR',"^[A-Za-z0-9\.\_\@-]+$",true);
	define('VALCHAR2',"^[A-Za-z0-9-]+$",true);
	define('TANGGALINDO',substr(TANGGAL,8,2)."-".$array_bln[substr(TANGGAL,5,2)-1]."-".substr(TANGGAL,0,4));	
?>