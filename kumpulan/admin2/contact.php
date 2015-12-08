<?php
	// ***************************************************
	// File contact.php
	// File ini akan diperlukan oleh file-file php lainnya
	// ***************************************************
	
	if(ereg("contact.php", $PHP_SELF))
	{
			header("location:../index.php");
			die;
	}
	
	require "include/pencarian.php";
	
	$isi="
	<table width=\"100%\" border=\"0\" cellspacing=\"10\" cellpadding=\"3\"><td align=\"left\" valign=\"middle\">
			<p class=\"gbbiru\">
			  <object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0\" width=\"424\" height=\"296\">
				<param name=\"movie\" value=\"images/Peta.swf\" />
				<param name=\"quality\" value=\"high\" />
				<embed src=\"images/Peta.swf\" quality=\"high\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\" type=\"application/x-shockwave-flash\" width=\"424\" height=\"296\"></embed>
			  </object>
			</p>
			</td></table>
		";
	
	require "include/menukategori.php";
?>