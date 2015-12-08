<?php
	// ***************************************************
	// File bimbing.php
	// File ini akan diperlukan oleh file-file php lainnya
	// ***************************************************
	
	session_start();
	
	if(!session_is_registered(user)){
		header("location:../index.php");
	}
	
	if(ereg("bimbing.php", $PHP_SELF))
	{
		header("location:../index.php");
		die;
	}
	
	if($_GET['hapus']) {
		mysql_query("delete from dosen_bimbing where nik='$_GET[hapus]'");
		mysql_query("delete from user where user='$_GET[hapus]' and id_akses='3'");
	}
	
	if($_POST['simpan']) {
		$ubah=$_POST['ubah'];
		$nik=$_POST['nik'];
		$nama=$_POST['nama'];
		$email=$_POST['email'];
		$pass=$_POST['pass'];
		$cpass=$_POST['cpass'];
		
		if($ubah!="") {
			$wcheckNik="and nik!='$ubah'";
			$wcheckUser="and ( user!='$ubah' or id_akses!='3' )";
		}
		
		if(empty($nik)) $enik="Nik masih kosong";
		else {
			$checkNik=mysql_query("select nik from dosen_bimbing where nik='$nik' $wcheckNik");
			if(mysql_num_rows($checkNik)>0) $enik="Nik sudah terdaftar";
			
			$checkUser=mysql_query("select user from user where user='$nik' and pass='$pass' $wcheckUser");
			if(mysql_num_rows($checkUser)>0) $enik="User sudah terdaftar";
		}
		if(empty($nama)) $enama="Nama masih kosong";		
		if(empty($email) || !eregi(FORMAT_EMAIL,$email)) $eemail="Email masih kosong / salah";
		
		if($ubah!="") { if(!empty($pass) && (strlen($pass)<5 || $pass!=$cpass)) $epass="Password masih salah"; }
		else { if(empty($pass) || strlen($pass)<5 || $pass!=$cpass) $epass="Password masih kosong/salah"; }
		
		if($enik=="" && $enama=="" && $ejurusan=="" && $eemail=="" && $epass=="") {
			if($ubah!="") {
				mysql_query("update dosen_bimbing set nik='$nik',nama='$nama',email='$email' where nik='$ubah'");
				if(!empty($pass)) mysql_query("update user set user='$nik',pass='$pass' where user='$ubah' and id_akses='3'");
				else mysql_query("update user set user='$nik' where user='$ubah' and id_akses='3'");
				
				$enik="Proses Ubah data $ubah telah berhasil";
			}
			else {
				mysql_query("insert into dosen_bimbing(nik,nama,email) values('$nik','$nama','$email')");
				mysql_query("insert into user(user,pass,id_akses,status) values('$nik','$pass','3','1')");
				
				$enik="Proses Input data $nik telah berhasil";
			}
			
			$ubah="";
			$nik="";
			$nama="";
			$email="";
		}
	}
	
	if($_GET['ubah']) {
		$ubah=$_GET['ubah'];
		$nik=$_GET['ubah'];
		
		$qubimbing=mysql_query("select * from dosen_bimbing where nik='$ubah'");
		$dubimbing=mysql_fetch_array($qubimbing);
		
		$nama=$dubimbing['nama'];
		$email=$dubimbing['email'];
	}
			
	$body="<br />
			<form id=\"form2\" name=\"form2\" method=\"post\" action=\"?action=bimbing\">
			  <table width=\"50%\" border=\"0\" align=\"center\" cellpadding=\"3\" cellspacing=\"1\" style=\"border:1px solid #4682b4;\">
				<tr>
				  <td colspan=\"5\" align=\"right\" bgcolor=\"#4682b4\" class=\"gputih\">FORM INPUT DOSEN PEMBIMBING </td>
				</tr>
				<tr>
				  <td width=\"8%\">&nbsp;</td>
				  <td width=\"26%\">&nbsp;</td>
				  <td width=\"3%\">&nbsp;</td>
				  <td width=\"55%\">&nbsp;</td>
				  <td width=\"8%\">&nbsp;</td>
				</tr>
				<tr>
				  <td>&nbsp;</td>
				  <td style=\"border-top:1px solid #4682b4\">NIK</td>
				  <td style=\"border-top:1px solid #4682b4\">:</td>
				  <td style=\"border-top:1px solid #4682b4\" class=\"merah\"><input name=\"nik\" type=\"text\" id=\"nik\" size=\"10\" maxlength=\"10\" value=\"$nik\" />
					  <br /><input type=\"hidden\" name=\"ubah\" value=\"$ubah\" />
					$enik</td>
				  <td>&nbsp;</td>
				</tr>
				<tr>
				  <td>&nbsp;</td>
				  <td style=\"border-top:1px solid #4682b4\">Nama</td>
				  <td style=\"border-top:1px solid #4682b4\">:</td>
				  <td style=\"border-top:1px solid #4682b4\" class=\"merah\"><input name=\"nama\" type=\"text\" id=\"nama\" size=\"35\" maxlength=\"50\" value=\"$nama\" />
					  <br />
					$enama</td>
				  <td>&nbsp;</td>
				</tr>
				<tr>
				  <td>&nbsp;</td>
				  <td style=\"border-top:1px solid #4682b4\">Email</td>
				  <td style=\"border-top:1px solid #4682b4\">:</td>
				  <td style=\"border-top:1px solid #4682b4\" class=\"merah\"><input name=\"email\" type=\"text\" id=\"email\" size=\"35\" maxlength=\"50\" value=\"$email\" onblur=\"validasi(this,'email')\" />
					  <br />
					$eemail</td>
				  <td>&nbsp;</td>
				</tr>
				<tr>
				  <td>&nbsp;</td>
				  <td style=\"border-top:1px solid #4682b4\">Password</td>
				  <td style=\"border-top:1px solid #4682b4\">:</td>
				  <td style=\"border-top:1px solid #4682b4\" class=\"merah\"><input name=\"pass\" type=\"password\" id=\"pass\" size=\"20\" maxlength=\"20\" /> Min 5 Char
					  <br />
					$epass</td>
				  <td>&nbsp;</td>
				</tr>
				<tr>
				  <td>&nbsp;</td>
				  <td style=\"border-top:1px solid #4682b4\">Confirm Pass </td>
				  <td style=\"border-top:1px solid #4682b4\">:</td>
				  <td style=\"border-top:1px solid #4682b4\" class=\"merah\"><input name=\"cpass\" type=\"password\" id=\"cpass\" size=\"20\" maxlength=\"20\" onkeyup=\"valPass('pass',this)\" /> Min 5 Char</td>
				  <td>&nbsp;</td>
				</tr>
				<tr>
				  <td>&nbsp;</td>
				  <td colspan=\"3\" style=\"border-top:1px solid #4682b4\">&nbsp;</td>
				  <td>&nbsp;</td>
				</tr>
				<tr>
				  <td colspan=\"5\" align=\"right\" bgcolor=\"#dbeaf5\"><input name=\"simpan\" type=\"submit\" id=\"Simpan\" value=\" Simpan \" style=\"background:#FFFFFF\" /></td>
				</tr>
			  </table>
			</form>
			<br />";
			
	$tcari=$_POST['tcari'].$_GET['tcari'];
	$kcari=$_POST['kcari'].$_GET['kcari'];
	if($kcari=="0" || $kcari=="") $where="";
	else $where="where $kcari like '%$tcari%'";
	
	$batas=20;
	$limit=($_GET['page'])?($_GET['page']-1)*$batas:0;
	
	$qjbimbing=mysql_query("select distinct d.nik from dosen_bimbing as d $where");
	$jbimbing=mysql_num_rows($qjbimbing);
	$hal=ceil($jbimbing/$batas);
	
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
	
	$array_kcari=array('d.nik'=>'NIK','d.nama'=>'Nama','d.email'=>'Email');
	
	$body.="<table width=\"90%\" border=\"0\" align=\"center\" cellpadding=\"3\" cellspacing=\"1\" style=\"border:1px solid #4682b4;\">
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
	$qbimbing=mysql_query("select distinct d.nik as nik,d.nama as nama,d.email as email from dosen_bimbing as d $where order by d.nik asc limit $limit,$batas");
	
	$no=$limit+1;
	while($dbimbing=mysql_fetch_array($qbimbing)) {
		$bgcolor=($no%2==0)?"bgcolor=\"#f5f5f5\"":"";
				  
		$body.="
			  <tr $bgcolor>
				<td align=\"center\">$no</td>
				<td align=\"left\">$dbimbing[nik]</td>
				<td align=\"left\">$dbimbing[nama]</td>
				<td align=\"left\">$dbimbing[email]</td>
				<td align=\"center\">
				 	<a href=\"?action=$_GET[action]&tcari=$tcari&kcari=$kcari&page=$_GET[page]&ubah=$dbimbing[nik]\" target=\"_self\" class=\"merah\" title=\"Untuk merubah data...\">Edit</a> || 
					<a href=\"?action=$_GET[action]&tcari=$tcari&kcari=$kcari&page=$_GET[page]&hapus=$dbimbing[nik]\" target=\"_self\" class=\"merah\" title=\"Untuk menghapus data...\">Del</a>
				</td>
			  </tr>";
		$no++;
	}
	
	$body.="  <tr>
				<td colspan=\"5\" align=\"right\" bgcolor=\"#dbeaf5\">$paging</td>
				</tr>
			</table><br />";
?>