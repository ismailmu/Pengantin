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
	
	if($_POST['simpan']) {
		mysql_query("update home set judul='$_POST[judul]',isi='$_POST[isi]'");
	}
	
	require "include/pencarian.php";
	$dhome=mysql_fetch_array(mysql_query("select judul,isi from home"));
	$home_isi=str_replace("\n","<br />",$dhome['isi']);
	
	$isi="
		<table width=\"100%\" border=\"0\" cellspacing=\"10\" cellpadding=\"3\">
			<td align=\"left\" class=\"gbbiru\">$dhome[judul]<p class=\"biru\">$home_isi</p></td>
		</table>
		";
	
	require "include/menukategori.php";
?>