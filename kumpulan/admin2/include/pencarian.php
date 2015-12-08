<?php
	// ***************************************************
	// File pencarian.php
	// File ini akan diperlukan oleh file-file php lainnya
	// ***************************************************
	
	if(ereg("pencarian.php", $PHP_SELF))
	{
			header("location:../../index.php");
			die;
	}
	
	$kcari=$_POST['kcari'].$_GET['kcari'];
	
	$selectkategori="";
	
	$qskategori=mysql_query("select id_skategori,nama_skategori from skategori");
	
	while($dskategori=mysql_fetch_array($qskategori)) {
		$select=($dskategori[0]==$kcari)?"selected=\"selected\"":"";
		$selectkategori.="<option value=\"$dskategori[0]\" $select>$dskategori[1]</option>";
	}
	
	if($action=='mproduct') $action_jual="mproduct";
	else if($action=='cproduct') $action_jual="cproduct";
	else $action_jual="product";

	$pencarian="
		<form action=\"?action=$action_jual\" method=\"post\" name=\"fcari\" target=\"_self\" id=\"fcari\">&nbsp;&nbsp;&nbsp;<span class=\"bkuning\">Cari :</span>
			  <input name=\"ncari\" type=\"text\" id=\"ncari\" size=\"20\" maxlength=\"20\" value=\"$_POST[ncari]$_GET[ncari]\"/>
			  <select name=\"kcari\" id=\"kcari\">
				<option value=\"%%\">-Pilih Semua-</option>
				$selectkategori
			
			  </select>
			  <input name=\"cari\" type=\"submit\" class=\"bhitam\" id=\"cari\" value=\"Cari Sekarang\" />
				</form>
		";
?>