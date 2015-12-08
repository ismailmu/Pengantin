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
	define(STANGGAL,date("Y-m-d"),true);
	define(WAKTU,time(),true);
	$array_bln=array("Jan","Feb","Mar","Apr","Mei","Jun","Jul","Ags","Sep","Okt","Nov","Des");
	$array_bulan=array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
	$array_hari=array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu");
	$array_abstraksi=array("Menunggu Acc Dosen Ketua Jurusan","Abstraksi ditolak, ganti Abstraski Anda","Abstrasi Diterima, konsultasikan ke Dosen Pembimbing");
	define(FORMAT_EMAIL,"^.+@.+\..+$",true);
?>