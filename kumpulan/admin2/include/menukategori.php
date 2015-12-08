<?php
	// ***************************************************
	// File menukategori.php
	// File ini akan diperlukan oleh file-file php lainnya
	// ***************************************************
	
	if(ereg("menukategori.php", $PHP_SELF))
	{
			header("location:../../index.php");
			die;
	}
	
	$nokategori=1;
	$isikategori="";
	$qkategori=mysql_query("select id_kategori,nama_kategori from kategori");
	$jkategori=mysql_num_rows($qkategori);
	
	while($dkategori=mysql_fetch_array($qkategori)) {
		$noskategori=1;
		$skategori="";
		$qskategori=mysql_query("select id_skategori,nama_skategori from skategori where id_kategori='$dkategori[0]'");
		
		while($dskategori=mysql_fetch_array($qskategori)) {
			if($noskategori==1) $skategori.="<a href=\"?action=product&kcari=$dskategori[0]\" class=\"kuning\">$dskategori[1]</a>";
			else $skategori.=", <a href=\"?action=product&kcari=$dskategori[0]\" class=\"kuning\">$dskategori[1]</a>";
			
			$noskategori++;
		}
		$tdkategori="<td align=\"left\" width=\"50%\" class=\"merah\"><span  class=\"bbiru\">$dkategori[1]</span><br />$skategori</td>";
		
		if($nokategori%2==1 && $nokategori==$jkategori) $isikategori.="<tr>$tdkategori<td>&nbsp;</td></tr>";
		else if($nokategori%2==1) $isikategori.="<tr>$tdkategori";
		else $isikategori.="$tdkategori</tr>";
		$nokategori++;
	}
	
	if($jkategori>0) $menukategori="<table width=\"100%\" border=\"0\" cellspacing=\"10\" cellpadding=\"3\">$isikategori</table>";	
?>