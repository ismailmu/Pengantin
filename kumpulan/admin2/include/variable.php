<?php
	// ***************************************************
	// File variable.php
	// File ini akan diperlukan oleh file-file php lainnya
	// ***************************************************
	
	if(ereg("variable.php", $PHP_SELF))
	{
			header("location:../../index.php");
			die;
	}
	
	define(TANGGAL,date("Y-m-d H:i:s"),true);
	define(WAKTU,time(),true);
	define(TGLPOSTING,minusDay(TANGGAL,7),true);
	$array_bln=array("Jan","Feb","Mar","Apr","Mei","Jun","Jul","Ags","Sep","Okt","Nov","Des");
	$array_bulan=array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
	$array_hari=array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu");
	define(FORMAT_EMAIL,"^.+@.+\..+$",true);
?>