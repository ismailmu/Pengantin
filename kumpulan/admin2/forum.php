<?php
	// ***************************************************
	// File home.php
	// File ini akan diperlukan oleh file-file php lainnya
	// ***************************************************
	
	if(ereg("home.php", $PHP_SELF))
	{
			header("location:../index.php");
			die;
	}
	
	require "include/pencarian.php";
	
	$isi="
		<table width=\"100%\" border=\"0\" cellspacing=\"10\" cellpadding=\"3\"><td align=\"left\">
			<p class=\"gbbiru\">Bergabunglah diforum kami!</p>
			<p class=\"biru\">Tempat anda mencari, menjual  dan membeli barang second berkualitas, menarik dan murah.<br />
			Untuk memulai silahkan klik dimenu kategori disebelah kiri, untuk mendaftar dan mendapatkan fasilitas lebih, silahkan melakukan registrasi, <a href=\"?action=registrasi\" title=\"registrasi\" target=\"_self\" class=\"merah\">Klik disini</a>.<br />
			Member memiliki fasilitas menjual Online, forum dan mendapatkan promo spesial dari kami. </p>
		</td></table>
		";
	
	require "include/menukategori.php";
?>