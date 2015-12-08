<?php
	// ***************************************************
	// File home.php
	// File ini akan diperlukan oleh file-file php lainnya
	// ***************************************************
	
	if(ereg("home.php", $PHP_SELF))
	{
		header("location:index.php");
		die;
	}
	
	if($_POST['simpan']) {
		if($_POST['komentar']!="") {
			$checkNourut=mysql_query("select id_komentar from komentar order by id_komentar desc limit 0,1");
			$hasil=mysql_fetch_array($checkNourut);
			mysql_query("insert into komentar values('".($hasil['id_komentar']+1)."','$_POST[komentar]','".TANGGAL."','$_POST[checkComment]')");
		}
	}
	
	$body="<br /><form action=\"\" method=\"post\" target=\"_self\">
				<table width=\"95%\" border=\"0\" align=\"right\" cellpadding=\"3\" cellspacing=\"1\">
				  <tr>
					<td colspan=\"2\" class=\"bbiru\">Share your opini, comment , response or question...<br /> <textarea name=\"komentar\" id=\"komentar\" cols=\"100\" rows=\"4\" onfocus=\"this.style.background='#ffffff'\" onblur=\"this.style.background='#eeeeee'\" style=\"background:#eeeeee\"></textarea><br /><input type=\"submit\" name=\"simpan\" value=\" Simpan \" /></td>
				  </tr>
			";
	
	$garis=0;
	$query=mysql_query("select * from komentar where id_skomentar='0' order by tanggal desc");
	while($data=mysql_fetch_array($query)) {
		if($garis>0) $style="style=\"border-top:1px dashed #4682b4;\"";
		$body.="
				<tr>
					<td colspan=\"2\" $style>
						$data[isi]...<br />
						<span class=\"biru\">Posting ".substr($data['tanggal'],8,2)." ".$array_bln[substr($data['tanggal'],5,2)-1]." ".substr($data['tanggal'],0,4)." ".substr($data['tanggal'],11,8)."</span> <em>Click for your comment</em> <input name=\"checkComment\" type=\"radio\" value=\"$data[id_komentar]\" onclick=\"document.getElementById('komentar').focus();\" /></td>
				  </tr>
			";
		$query2=mysql_query("select * from komentar where id_skomentar='$data[id_komentar]' order by tanggal desc");
		while($data2=mysql_fetch_array($query2)) {
			$body.="
					<tr>
						<td width=\"3%\">&nbsp;</td>
						<td width=\"97%\">
							$data2[isi]...<br />
							<span class=\"biru\">Posting ".substr($data2['tanggal'],8,2)." ".$array_bln[substr($data2['tanggal'],5,2)-1]." ".substr($data2['tanggal'],0,4)." ".substr($data2['tanggal'],11,8)."</span></td>
				  	</tr>";
		}
		$garis++;
	}
	
	$body.="<tr><td colspan=\"2\">&nbsp;</td></tr></table></form>";
?>