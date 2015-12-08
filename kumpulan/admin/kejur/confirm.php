<?php
	// ***************************************************
	// File confirm.php
	// File ini akan diperlukan oleh file-file php lainnya
	// ***************************************************
	
	session_start();
	
	if(!session_is_registered(user)){
		header("location:../index.php");
	}
	
	if(ereg("confirm.php", $PHP_SELF))
	{
		header("location:../index.php");
		die;
	}
	
	if($_POST['terima']) {
		mysql_query("update abstraksi set status='2' where nim='$_POST[nim]'");
	}
	
	if($_POST['tolak']) {
		mysql_query("update abstraksi set status='1' where nim='$_POST[nim]'");
	}
	
	$body.="";
	
	if($_GET['detail']) {
		$nim=$_GET['detail'];
		
		$qdabstraksi=mysql_query("select distinct m.nama as nama,j.nama as nama_jurusan,a.judul as judul,a.latar_belakang as latar_belakang,a.identifikasi as identifikasi,a.batasan as batasan,a.metode as metode,a.tanggal as tanggal 
								from mahasiswa as m,abstraksi as a,jurusan as j where m.nim='$nim' and m.nim=a.nim and m.id_jurusan=j.id_jurusan and a.status='0'");
		$ddabstraksi=mysql_fetch_array($qdabstraksi);
		
		$body=" <br>
				<form id=\"form2\" name=\"form2\" method=\"post\" action=\"?action=confirm\">
				  <table style=\"border: 1px solid rgb(70, 130, 180);\" align=\"center\" border=\"0\" cellpadding=\"3\" cellspacing=\"1\" width=\"90%\">
					<tbody>
					  <tr>
						<td colspan=\"5\" class=\"gputih\" align=\"right\" bgcolor=\"#4682b4\"><input type=\"hidden\" name=\"nim\" value=\"$nim\" /> ABSTRASKSI MAHASISWA </td>
					  </tr>
					  <tr>
						<td width=\"3%\">&nbsp;</td>
						<td colspan=\"3\" align=\"left\">&nbsp;</td>
						<td width=\"3%\">&nbsp;</td>
					  </tr>
					  <tr>
						<td>&nbsp;</td>
						<td width=\"11%\" align=\"left\">Nama </td>
						<td width=\"2%\" align=\"center\">: </td>
						<td width=\"81%\" align=\"left\">$ddabstraksi[nama]</td>
						<td>&nbsp;</td>
					  </tr>
					  <tr>
						<td>&nbsp;</td>
						<td align=\"left\">NIM</td>
						<td align=\"center\">: </td>
						<td align=\"left\">$nim</td>
						<td>&nbsp;</td>
					  </tr>
					  <tr>
						<td>&nbsp;</td>
						<td align=\"left\">Jurusan</td>
						<td align=\"center\">: </td>
						<td align=\"left\">$ddabstraksi[nama_jurusan]</td>
						<td>&nbsp;</td>
					  </tr>
					  <tr>
						<td>&nbsp;</td>
						<td colspan=\"3\" align=\"left\">&nbsp;</td>
						<td>&nbsp;</td>
					  </tr>
					  <tr>
						<td>&nbsp;</td>
						<td colspan=\"3\" align=\"left\" class=\"bhitam\">Judul</td>
						<td>&nbsp;</td>
					  </tr>
					  <tr>
						<td>&nbsp;</td>
						<td colspan=\"3\" align=\"left\">$ddabstraksi[judul]</td>
						<td>&nbsp;</td>
					  </tr>
					  <tr>
						<td>&nbsp;</td>
						<td colspan=\"3\" align=\"left\">&nbsp;</td>
						<td>&nbsp;</td>
					  </tr>
					  <tr>
						<td>&nbsp;</td>
						<td colspan=\"3\" align=\"left\" class=\"bhitam\">Latar Belakang </td>
						<td>&nbsp;</td>
					  </tr>
					  <tr>
						<td>&nbsp;</td>
						<td colspan=\"3\" align=\"left\">$ddabstraksi[latar_belakang]</td>
						<td>&nbsp;</td>
					  </tr>
					  <tr>
						<td>&nbsp;</td>
						<td colspan=\"3\" align=\"left\">&nbsp;</td>
						<td>&nbsp;</td>
					  </tr>
					  <tr>
						<td>&nbsp;</td>
						<td colspan=\"3\" align=\"left\" class=\"bhitam\">Identifikasi Masalah </td>
						<td>&nbsp;</td>
					  </tr>
					  <tr>
						<td>&nbsp;</td>
						<td colspan=\"3\" align=\"left\">$ddabstraksi[identifikasi]</td>
						<td>&nbsp;</td>
					  </tr>
					  <tr>
						<td>&nbsp;</td>
						<td colspan=\"3\" align=\"left\">&nbsp;</td>
						<td>&nbsp;</td>
					  </tr>
					  <tr>
						<td>&nbsp;</td>
						<td colspan=\"3\" align=\"left\" class=\"bhitam\">Pembatasan Masalah </td>
						<td>&nbsp;</td>
					  </tr>
					  <tr>
						<td>&nbsp;</td>
						<td colspan=\"3\" align=\"left\">$ddabstraksi[batasan]</td>
						<td>&nbsp;</td>
					  </tr>
					  <tr>
						<td>&nbsp;</td>
						<td colspan=\"3\" align=\"left\">&nbsp;</td>
						<td>&nbsp;</td>
					  </tr>
					  <tr>
						<td>&nbsp;</td>
						<td colspan=\"3\" align=\"left\" class=\"bhitam\">Metode yang Digunakan </td>
						<td>&nbsp;</td>
					  </tr>
					  <tr>
						<td>&nbsp;</td>
						<td colspan=\"3\" align=\"left\">$ddabstraksi[metode]</td>
						<td>&nbsp;</td>
					  </tr>
					  <tr>
						<td>&nbsp;</td>
						<td colspan=\"3\" align=\"left\">&nbsp;</td>
						<td>&nbsp;</td>
					  </tr>
					  <tr>
						<td>&nbsp;</td>
						<td colspan=\"3\" align=\"left\">Surakarta, ".substr($ddabstraksi['tanggal'],8,2)." ".$array_bulan[substr($ddabstraksi['tanggal'],5,2)-1]." ".substr($ddabstraksi['tanggal'],0,4)."</td>
						<td>&nbsp;</td>
					  </tr>
	
					  <tr>
						<td>&nbsp;</td>
						<td colspan=\"3\">&nbsp;</td>
						<td>&nbsp;</td>
					  </tr>
					  <tr>
						<td colspan=\"5\" align=\"right\" bgcolor=\"#dbeaf5\"><input name=\"terima\" id=\"terima\" value=\" Terima \" style=\"background:#ffffff\" type=\"submit\">
							<input name=\"tolak\" id=\"tolak\" value=\" Tolak \" style=\"background:#ffffff\" type=\"submit\"></td>
					  </tr>
					</tbody>
				  </table>
				</form>";
	}
			
	$qid_jurusan=mysql_query("select id_jurusan from dosen_kejur where nik='$_SESSION[user]'");
	$did_jurusan=mysql_fetch_array($qid_jurusan);
			
	$tcari=$_POST['tcari'].$_GET['tcari'];
	$kcari=$_POST['kcari'].$_GET['kcari'];
	if($kcari=="0" || $kcari=="") $where="";
	else $where="and $kcari like '%$tcari%'";
	
	$batas=20;
	$limit=($_GET['page'])?($_GET['page']-1)*$batas:0;
	
	$qjabstraksi=mysql_query("select distinct a.nim from abstraksi as a,mahasiswa as m where a.nim=m.nim and m.id_jurusan='$did_jurusan[id_jurusan]' and a.status='0' $where");
	$jabstraksi=mysql_num_rows($qjabstraksi);
	$hal=ceil($jabstraksi/$batas);
	
	$paging="";
	
	for($i=1;$i<=$hal;$i++)
	{
		if($hal>1) {
			if($i!=1) $paging.=" || ";
			if($_GET['page']==$i)$paging.="$i";
			else if(($i==1)&&(!$_GET['page']))$paging.="$i";
			else $paging.="<a href=\"?action=$_GET[action]&tcari=$tcari&kcari=$kcari&page=$i\" class=\"bmerah\">$i</a>";
		}
	}		
	
	$array_kcari=array('m.nim'=>'NIM','m.nama'=>'Nama','m.email'=>'Email');
	
	$body.="<br /><table width=\"90%\" border=\"0\" align=\"center\" cellpadding=\"3\" cellspacing=\"1\" style=\"border:1px solid #4682b4;\">
			  <tr class=\"bhitam\">
				<td colspan=\"4\" align=\"left\"><form id=\"form2\" name=\"form2\" method=\"post\" action=\"\">
				    Cari :  <input name=\"tcari\" type=\"text\" id=\"tcari\" size=\"20\" maxlength=\"20\" value=\"$tcari\" />
						<select name=\"kcari\" id=\"kcari\">
						  <option value=\"0\">- Pilih Salah Satu -</option>";
						  
	while(list($list,$key)=each($array_kcari)) {
		$selected=($list==$kcari)?"selected=\"selected\"":"";
		$body.="<option value=\"$list\" $selected>$key</option>";
		$i++;
	}
						  
	$body.="			</select>
						 <input name=\"cari\" type=\"submit\" id=\"cari\" value=\" Cari \" />
				</form>
				</td>
				<td align=\"center\">&nbsp;</td>
				</tr>
			  <tr>
				<td width=\"3%\" align=\"center\" bgcolor=\"#4682b4\" class=\"bputih\">No</td>
				<td width=\"12%\" align=\"center\" bgcolor=\"#4682b4\" class=\"bputih\">NIK</td>
				<td width=\"24%\" align=\"center\" bgcolor=\"#4682b4\" class=\"bputih\">Nama</td>
				<td width=\"25%\" align=\"center\" bgcolor=\"#4682b4\" class=\"bputih\">Email</td>
				<td width=\"9%\" align=\"center\" bgcolor=\"#4682b4\">&nbsp;</td>
			  </tr>";
	$qabstraksi=mysql_query("select distinct m.nim as nim,m.nama as nama,m.email as email from abstraksi as a,mahasiswa as m where a.nim=m.nim and m.id_jurusan='$did_jurusan[id_jurusan]' and a.status='0' $where order by m.nim asc limit $limit,$batas");
	
	$no=$limit+1;
	while($dabstraksi=mysql_fetch_array($qabstraksi)) {
		$bgcolor=($no%2==0)?"bgcolor=\"#f5f5f5\"":"";
				  
		$body.="
			  <tr $bgcolor>
				<td align=\"center\">$no</td>
				<td align=\"left\">$dabstraksi[nim]</td>
				<td align=\"left\">$dabstraksi[nama]</td>
				<td align=\"left\">$dabstraksi[email]</td>
				<td align=\"center\">
				 	<a href=\"?action=$_GET[action]&tcari=$tcari&kcari=$kcari&page=$_GET[page]&detail=$dabstraksi[nim]\" target=\"_self\" class=\"merah\" title=\"Untuk Menampilkan data... \">Show Detail</a>
				</td>
			  </tr>";
		$no++;
	}
	
	$body.="  <tr>
				<td colspan=\"5\" align=\"right\" bgcolor=\"#dbeaf5\">$paging</td>
				</tr>
			</table><br />";
?>