<?php
	// ***************************************************
	// File abstraski.php
	// File ini akan diperlukan oleh file-file php lainnya
	// ***************************************************
	
	session_start();
	
	if(!session_is_registered(user)){
		header("location:../index.php");
	}
	
	if(ereg("abstraski.php", $PHP_SELF))
	{
		header("location:../index.php");
		die;
	}
	
	if($_POST['simpan']) {
		$judul=$_POST['judul'];
		$latar_belakang=$_POST['latar_belakang'];
		$identifikasi=$_POST['identifikasi'];
		$batasan=$_POST['batasan'];
		$metode=$_POST['metode'];
		
		if(empty($judul)) $ejudul="<span class=\"biru\">Judul masih kosong</span>";
		if(empty($latar_belakang)) $elatar_belakang="<span class=\"biru\">Latar Belakang masih kosong</span>";
		if(empty($identifikasi)) $eidentifikasi="<span class=\"biru\">Identifikasi Masalah masih kosong</span>";
		if(empty($batasan)) $ebatasan="<span class=\"biru\">Pembatasan Masalah masih kosong</span>";
		if(empty($metode)) $emetode="<span class=\"biru\">Metode yang Digunakan masih kosong</span>";
		
		if($ejudul=="" && $elatar_belakang=="" && $eidentifikasi=="" && $ebatasan=="" && $emetode=="") {
			$qcabstraksi=mysql_query("select nim from abstraksi where nim='$_SESSION[user]'");
			$dcabstraksi=mysql_num_rows($qcabstraksi);
			
			if($dcabstraksi>0) {
				mysql_query("update abstraksi set judul='$judul',latar_belakang='$latar_belakang',identifikasi='$identifikasi',batasan='$batasan',metode='$metode',tanggal='".STANGGAL."',status='0' where nim='$_SESSION[user]' and status!='2'");
				$ejudul="<span class=\"biru\">Abstraksi sukses diubah</span>";
			}
			else {
				mysql_query("insert into abstraksi(nim,judul,latar_belakang,identifikasi,batasan,metode,tanggal,status) values('$_SESSION[user]','$judul','$latar_belakang','$identifikasi','$batasan','$metode','".STANGGAL."','0')");
				$ejudul="<span class=\"biru\">Abstraksi sukses disimpan</span>";
			}
		}
	}
	
	$qabstraksi=mysql_query("select * from abstraksi where nim='$_SESSION[user]'");
	$dabstraksi=mysql_fetch_array($qabstraksi);
	if(is_array($dabstraksi)) {
		$judul=$dabstraksi['judul'];
		$latar_belakang=$dabstraksi['latar_belakang'];
		$identifikasi=$dabstraksi['identifikasi'];
		$batasan=$dabstraksi['batasan'];
		$metode=$dabstraksi['metode'];
	}
	
	$status="<span class=\"biru\">".$array_abstraksi[$dabstraksi['status']]."</span>";
	$simpan=($dabstraksi['status']<2)?"<input name=\"simpan\" type=\"submit\" id=\"Simpan\" value=\" Simpan \" style=\"background:#FFFFFF\" />":"";
	$body.="<br />
			$status
			<form id=\"form1\" name=\"form1\" method=\"post\" action=\"?action=abstraksi\">
			  <table width=\"90%\" border=\"0\" align=\"center\" cellpadding=\"3\" cellspacing=\"1\" style=\"border:1px solid #4682b4;\">
				<tr>
				  <td colspan=\"5\" align=\"right\" bgcolor=\"#4682b4\" class=\"gputih\">FORM INPUT ABSTRAKSI </td>
				</tr>
				<tr>
				  <td width=\"3%\">&nbsp;</td>
				  <td width=\"7%\">&nbsp;</td>
				  <td width=\"2%\">&nbsp;</td>
				  <td width=\"85%\">&nbsp;</td>
				  <td width=\"3%\">&nbsp;</td>
				</tr>
				<tr>
				  <td>&nbsp;</td>
				  <td style=\"border-top:1px solid #4682b4\">Judul</td>
				  <td style=\"border-top:1px solid #4682b4\">:</td>
				  <td style=\"border-top:1px solid #4682b4\"><input name=\"judul\" type=\"text\" id=\"judul\" size=\"110\" maxlength=\"150\" value=\"$judul\" /><br />$ejudul</td>
				  <td>&nbsp;</td>
				</tr>
				<tr>
				  <td>&nbsp;</td>
				  <td style=\"border-top:1px solid #4682b4\">&nbsp;</td>
				  <td style=\"border-top:1px solid #4682b4\">&nbsp;</td>
				  <td style=\"border-top:1px solid #4682b4\">&nbsp;</td>
				  <td>&nbsp;</td>
				</tr>
				<tr>
				  <td>&nbsp;</td>
				  <td colspan=\"3\" style=\"border-top:1px solid #4682b4\">Latar Belakang </td>
				  <td>&nbsp;</td>
				</tr>
				<tr>
				  <td>&nbsp;</td>
				  <td colspan=\"3\"><textarea name=\"latar_belakang\" cols=\"105\" rows=\"7\" id=\"latar_belakang\">$latar_belakang</textarea><br />$elatar_belakang</td>
				  <td>&nbsp;</td>
				</tr>
				<tr>
				  <td>&nbsp;</td>
				  <td colspan=\"3\" style=\"border-top:1px solid #4682b4\">&nbsp;</td>
				  <td>&nbsp;</td>
				</tr>
				<tr>
				  <td>&nbsp;</td>
				  <td colspan=\"3\" style=\"border-top:1px solid #4682b4\">Identifikasi Masalah </td>
				  <td>&nbsp;</td>
				</tr>
				<tr>
				  <td>&nbsp;</td>
				  <td colspan=\"3\"><textarea name=\"identifikasi\" cols=\"105\" rows=\"7\" id=\"identifikasi\">$identifikasi</textarea><br />$eidentifikasi</td>
				  <td>&nbsp;</td>
				</tr>
				<tr>
				  <td>&nbsp;</td>
				  <td colspan=\"3\" style=\"border-top:1px solid #4682b4\">&nbsp;</td>
				  <td>&nbsp;</td>
				</tr>
				<tr>
				  <td>&nbsp;</td>
				  <td colspan=\"3\" style=\"border-top:1px solid #4682b4\">Pembatasan Masalah </td>
				  <td>&nbsp;</td>
				</tr>
				<tr>
				  <td>&nbsp;</td>
				  <td colspan=\"3\"><textarea name=\"batasan\" cols=\"105\" rows=\"7\" id=\"batasan\">$batasan</textarea><br />$ebatasan</td>
				  <td>&nbsp;</td>
				</tr>
				<tr>
				  <td>&nbsp;</td>
				  <td colspan=\"3\" style=\"border-top:1px solid #4682b4\">&nbsp;</td>
				  <td>&nbsp;</td>
				</tr>
				<tr>
				  <td>&nbsp;</td>
				  <td colspan=\"3\" style=\"border-top:1px solid #4682b4\">Metode yang Digunakan </td>
				  <td>&nbsp;</td>
				</tr>
				<tr>
				  <td>&nbsp;</td>
				  <td colspan=\"3\"><textarea name=\"metode\" cols=\"105\" rows=\"7\" id=\"metode\">$metode</textarea><br />$emetode</td>
				  <td>&nbsp;</td>
				</tr>
				<tr>
				  <td>&nbsp;</td>
				  <td colspan=\"3\" style=\"border-top:1px solid #4682b4\">&nbsp;</td>
				  <td>&nbsp;</td>
				</tr>
				<tr>
				  <td colspan=\"5\" align=\"right\" bgcolor=\"#dbeaf5\">$simpan</td>
				</tr>
			  </table>
			</form><br />
	";
?>