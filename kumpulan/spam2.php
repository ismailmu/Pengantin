<?php
	require "include/config_session.php";
	
	$tanggal=date("Y-m-d");
	for($i=99;$i<=99;$i++) {
		$kategori=($i<86)?1:2;
		mysql_query("insert into product values('1h$i','Nama','300000','1','Baris 1\nBaris 2\nBaris 3\nBaris 4\nBaris 5','".TANGGAL."','0')") or die("SPAM DATABASES GAGAL");
		mysql_query("insert into qproduct(id_product,id_kategori) values('1h$i','$kategori')");
	}
?>