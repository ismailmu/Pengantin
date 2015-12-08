<?php
	// ***************************************************
	// File setbimbing.php
	// File ini akan diperlukan oleh file-file php lainnya
	// ***************************************************
	
	session_start();
	
	if(!session_is_registered(user)){
		header("location:../index.php");
	}
	
	if(ereg("setbimbing.php", $PHP_SELF))
	{
		header("location:../index.php");
		die;
	}
		
	if($_POST['simpan']) {
		for($i=1;$i<=$_POST['loop_penguji'];$i++) {
			if(!empty($_POST['nim'.$i])) {
				$array_value=explode("&&",$_POST['nim'.$i]);
				mysql_query("update mahasiswa set nik_pembimbing='$array_value[1]' where nim='$array_value[0]'");
			}
		}
		$status="<span class=\"biru\">Set Pembimbing telah berhasil</span>";
	}
			
	$tcari=$_POST['tcari'].$_GET['tcari'];
	$kcari=$_POST['kcari'].$_GET['kcari'];
	if($kcari=="0" || $kcari=="") $where="";
	else $where="and $kcari like '%$tcari%'";
	
	$batas=20;
	$limit=($_GET['page'])?($_GET['page']-1)*$batas:0;
	
	$qjpembimbing=mysql_query("select distinct d.nim from mahasiswa as d,jurusan as j,abstraksi as a where d.nim=a.nim and a.status='2' and d.id_jurusan=j.id_jurusan $where");
	$jpembimbing=mysql_num_rows($qjpembimbing);
	$hal=ceil($jpembimbing/$batas);
	
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
	
	$array_kcari=array('d.nim'=>'NIM','d.nama'=>'Nama','d.email'=>'Email','j.nama'=>'Jurusan');
	
	$body="";
	$body.="<br />
			$status
			<form id=\"form2\" name=\"form2\" method=\"post\" action=\"?action=setbimbing\">
			<table width=\"90%\" border=\"0\" align=\"center\" cellpadding=\"3\" cellspacing=\"1\" style=\"border:1px solid #4682b4;\">
			  <tr class=\"bhitam\">
				<td colspan=\"4\" align=\"left\">
				    Cari :  <input name=\"tcari\" type=\"text\" id=\"tcari\" size=\"20\" maxlength=\"20\" value=\"$tcari\" />
						<select name=\"kcari\" id=\"kcari\">
						  <option value=\"0\">- Pilih Salah Satu -</option>";
						  
	while(list($list,$key)=each($array_kcari)) {
		$selected=($list==$kcari)?"selected=\"selected\"":"";
		$body.="<option value=\"$list\" $selected>$key</option>";
	}
						  
	$body.="	</select>
				 <input name=\"cari\" type=\"submit\" id=\"cari\" value=\" Cari \" />
				</td>
				<td align=\"left\">&nbsp;</td>
				<td align=\"center\">&nbsp;</td>
				</tr>
			  <tr>
				<td width=\"3%\" align=\"center\" bgcolor=\"#4682b4\" class=\"bputih\">No</td>
				<td width=\"10%\" align=\"center\" bgcolor=\"#4682b4\" class=\"bputih\">NIM</td>
				<td width=\"22%\" align=\"center\" bgcolor=\"#4682b4\" class=\"bputih\">Nama</td>
				<td width=\"23%\" align=\"center\" bgcolor=\"#4682b4\" class=\"bputih\">Email</td>
				<td width=\"22%\" align=\"center\" bgcolor=\"#4682b4\" class=\"bputih\">Jurusan</td>
				<td width=\"20%\" align=\"center\" bgcolor=\"#4682b4\" class=\"bputih\">Pembimbing</td>
			  </tr>";
	
	$qipembimbing=mysql_query("select nik,nama from dosen_bimbing");
	while($dipembimbing=mysql_fetch_array($qipembimbing)) {
		$array_pembimbing[$dipembimbing['nik']]=$dipembimbing['nama'];
	}
	
	$qpembimbing=mysql_query("select distinct d.nim as nim,d.nama as nama,d.email as email,j.nama as nama_jurusan,d.nik_pembimbing as nik from mahasiswa as d,jurusan as j,abstraksi as a where d.nim=a.nim and a.status='2' and d.id_jurusan=j.id_jurusan $where order by d.nik_pembimbing asc,d.nim asc limit $limit,$batas");
	
	$no=$limit+1;
	$loop=0;
	while($dpembimbing=mysql_fetch_array($qpembimbing)) {
		$bgcolor=($no%2==0)?"bgcolor=\"#f5f5f5\"":"";
		$loop++;
				  
		$body.="
			  <tr $bgcolor>
				<td align=\"center\">$no</td>
				<td align=\"left\">$dpembimbing[nim]</td>
				<td align=\"left\">$dpembimbing[nama]</td>
				<td align=\"left\">$dpembimbing[email]</td>
				<td align=\"left\">$dpembimbing[nama_jurusan]</td>
				<td align=\"left\">
					<select name=\"nim$loop\" id=\"kcari\">
						  <option value=\"0\">- Pilih Salah Satu -</option>";
						  
		while(list($list2,$key2)=each($array_pembimbing)) {
			$selected=($list2==$dpembimbing['nik'])?"selected=\"selected\"":"";
			$body.="<option value=\"$dpembimbing[nim]&&$list2\" $selected>$key2</option>";
		}
						  
		$body.="</select></td>
			  </tr>";
		$no++;
	}
	
	$body.="  <tr>
				<td colspan=\"6\" align=\"right\" bgcolor=\"#dbeaf5\">$paging</td>
				</tr>
			  <tr>
				<td colspan=\"6\" align=\"right\" bgcolor=\"#4682b4\"><input type=\"hidden\" name=\"loop_penguji\" value=\"$loop\" /><input name=\"simpan\" id=\"simpan\" value=\" Simpan \" style=\"background:#ffffff\" type=\"submit\"></td>
				</tr>
			</table></form><br />";
?>