<?php
	// ***************************************************
	// File registrasi.php
	// File ini akan diperlukan oleh file-file php lainnya
	// ***************************************************
	
	session_start();
	
	if(!session_is_registered(user)){
		header("location:../index.php");
	}
	
	if(ereg("registrasi.php", $PHP_SELF))
	{
		header("location:../index.php");
		die;
	}
	
	if($_GET['hapus']) {
		mysql_query("delete from mahasiswa where nim='$_GET[hapus]'");
		mysql_query("delete from user where user='$_GET[hapus]' and id_akses='4'");
	}
	
	if($_GET['confirm']) {
		$qcmahasiswa=mysql_query("select distinct m.email as email,u.pass as pass from mahasiswa as m,user as u where m.nim=u.user and u.status='0' and u.id_akses='4' and u.user='$_GET[confirm]'");
		$dcmahasiswa=mysql_fetch_array($qcmahasiswa);
		
		@mail("$dcmahasiswa[email]","Konfirmasi Registrasi pendaftaran Skripsi / Tugas Akhir.","Registrasi pendaftaran Skripsi / Tugas Akhir anda telah diterima. \n Untuk melakukan Penginputan Abstraksi Skripsi / Tugas Akhir anda, gunakan : \n Username : $_GET[confirm] \n Password : $dcmahasiswa[pass] \n Segeralah Kirimkan Abstraksi anda.","From: admin@sinus.co.id");
		mysql_query("update user set status='1' where user='$_GET[confirm]' and id_akses='4'");
	}
			
	$tcari=$_POST['tcari'].$_GET['tcari'];
	$kcari=$_POST['kcari'].$_GET['kcari'];
	if($kcari=="0" || $kcari=="") $where="";
	else $where="and $kcari like '%$tcari%'";
	
	$batas=20;
	$limit=($_GET['page'])?($_GET['page']-1)*$batas:0;
	
	$qjmahasiswa=mysql_query("select distinct d.nim from mahasiswa as d,jurusan as j,user as u where d.nim=u.user and u.status='0' and u.id_akses='4' and d.id_jurusan=j.id_jurusan $where");
	$jmahasiswa=mysql_num_rows($qjmahasiswa);
	$hal=ceil($jmahasiswa/$batas);
	
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
	
	$array_kcari=array('d.nim'=>'Nim','d.nama'=>'Nama','d.email'=>'Email','j.nama'=>'Jurusan');
	$body="";
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
				<td align=\"left\">&nbsp;</td>
				<td align=\"center\">&nbsp;</td>
				</tr>
			  <tr>
				<td width=\"3%\" align=\"center\" bgcolor=\"#4682b4\" class=\"bputih\">No</td>
				<td width=\"12%\" align=\"center\" bgcolor=\"#4682b4\" class=\"bputih\">Nim</td>
				<td width=\"24%\" align=\"center\" bgcolor=\"#4682b4\" class=\"bputih\">Nama</td>
				<td width=\"25%\" align=\"center\" bgcolor=\"#4682b4\" class=\"bputih\">Email</td>
				<td width=\"27%\" align=\"center\" bgcolor=\"#4682b4\" class=\"bputih\">Jurusan</td>
				<td width=\"9%\" align=\"center\" bgcolor=\"#4682b4\">&nbsp;</td>
			  </tr>";
	$qmahasiswa=mysql_query("select distinct d.nim as nim,d.nama as nama,d.email as email,j.nama as nama_jurusan from mahasiswa as d,jurusan as j,user as u where d.nim=u.user and u.status='0' and u.id_akses='4' and d.id_jurusan=j.id_jurusan $where order by d.nim asc limit $limit,$batas");
	
	$no=$limit+1;
	while($dmahasiswa=mysql_fetch_array($qmahasiswa)) {
		$bgcolor=($no%2==0)?"bgcolor=\"#f5f5f5\"":"";
				  
		$body.="
			  <tr $bgcolor>
				<td align=\"center\">$no</td>
				<td align=\"left\">$dmahasiswa[nim]</td>
				<td align=\"left\">$dmahasiswa[nama]</td>
				<td align=\"left\">$dmahasiswa[email]</td>
				<td align=\"left\">$dmahasiswa[nama_jurusan]</td>
				<td align=\"center\">
				 	<a href=\"?action=$_GET[action]&tcari=$tcari&kcari=$kcari&page=$_GET[page]&confirm=$dmahasiswa[nim]\" target=\"_self\" class=\"merah\" title=\"Untuk mengkonfirmasi data...\">Acc</a> || 
					<a href=\"?action=$_GET[action]&tcari=$tcari&kcari=$kcari&page=$_GET[page]&hapus=$dmahasiswa[nim]\" target=\"_self\" class=\"merah\" title=\"Untuk menghapus data...\">Del</a>
				</td>
			  </tr>";
		$no++;
	}
	
	$body.="  <tr>
				<td colspan=\"6\" align=\"right\" bgcolor=\"#dbeaf5\">$paging</td>
				</tr>
			</table><br />";
?>