<?php
	// ***************************************************
	// File satuan.php
	// File ini akan diperlukan oleh file-file php lainnya
	// ***************************************************
	
	if(ereg("satuan.php", $PHP_SELF))
	{
			header("location:../index.php");
			die;
	}
	
	if($_POST['Simpan']) { //=================================================================== jika submit Simpan
		$ubah=$_POST['ubah'];
		$nama=$_POST['nama'];
		$errnama=($nama=="")?"Nama masih kosong":"";
		
		if($errnama=="") {
			if($ubah) { //====================================================================== jika Text Hidden Ubah
				if(mysql_query("update satuan set nama='$nama' where id_satuan='$ubah'")) {
					$ubah="";
					$nama="";
					$errnama="Data telah berhasil diubah.";
				}
				else $errnama.="Data telah gagal diubah.";
			}
			else { //============================================================================ Else  input Satuan
				if($query=new query("select id_satuan from satuan order by id_satuan desc limit 0,1")) {
					if($query->rs_count) {
						$query->fetch();
						$id_satuan=$query->row['id_satuan']+1;
					}
					else $id_satuan=1;
				}
				if(mysql_query("insert into satuan(id_satuan,nama) values('$id_satuan','$nama')")) {
					$ubah="";
					$nama="";
					$errnama="Data telah berhasil disimpan.";
				}
				else $errnama.="Data telah gagal disimpan.";
			}
		}
	}
	else if($_GET['hapus']) { //=================================================================== Jika GET Hapus
		$errnama=(mysql_query("delete from satuan where id_satuan='$_GET[hapus]'"))?"Data telah berhasil dihapus.":"Data telah gagal dihapus.";
	}
	
	$body.="<br />";
	include("form/satuan.php"); // =========================================================== Pemanggilan Form
		
	$textcari=$_POST['textcari'].$_GET['textcari']; // ========================================= Pencarian
	
	$body.="<br />";
	$body.="
		<div align=\"left\">
			<form action=\"?act=$act\" method=\"post\" name=\"fcari\" target=\"_self\" id=\"fcari\">&nbsp;&nbsp;&nbsp;<span class=\"bkuning\">Cari :</span>
				  <input name=\"textcari\" type=\"text\" id=\"textcari\" size=\"20\" maxlength=\"20\" value=\"$textcari\"/>
				  <input name=\"cari\" type=\"submit\" class=\"bhitam\" id=\"cari\" value=\"Cari Sekarang\" />
			</form>
		</div>
		";
		
	$baris_paging=10;
	$page=($_GET['page'])?$_GET['page']:1; // menunjukkan halaman yang ditampilkan
	$array_paging=explode("&&",paging($baris_paging,10,"select distinct id_satuan from satuan where nama like '%$textcari%'",$page,"act=$act&textcari=$textcari"));
	
	$body.="
		<table border=\"0\" cellpadding=\"4\" cellspacing=\"1\" width=\"600\" style=\"border:1px solid #4682b4\">
		  <tbody>
		  	<tr class=\"biru\">
			  <td align=\"left\" colspan=\"3\">".$array_paging[1]."</td>
			</tr>
			<tr class=\"bputih\">
			  <td width=\"20\" align=\"left\" bgcolor=\"#4682b4\">No</td>
			  <td width=\"460\" align=\"center\" bgcolor=\"#4682b4\">Nama Satuan </td>
			  <td align=\"left\" bgcolor=\"#4682b4\">&nbsp;</td>
			</tr>"
		;
	
	if($tabel=new query("select id_satuan,nama from satuan where nama like '%$textcari%' limit $array_paging[0],$baris_paging")) {
		for($i=0;$i<$tabel->rs_count;$i++) {
			$tabel->fetch($i);
			
			$no=(($page-1)*$baris_paging)+$i+1;
			$bgcolor=($i%2==0)?"bgcolor=\"#f1f1f1\"":"";
			$body.="
					<tr class=\"kuning\">
					  <td align=\"left\" $bgcolor>$no</td>
					  <td align=\"left\" $bgcolor>&nbsp;".$tabel->row['nama']."</td>
					  <td align=\"center\" $bgcolor>
						<a href=\"?act=$act&textcari=$textcari&page=$page&ubah=".$tabel->row['id_satuan']."\" target=\"_self\" class=\"merah\" title=\"Untuk Merubah data...\">Ubah</a> || 
						<a href=\"?act=$act&textcari=$textcari&page=$page&hapus=".$tabel->row['id_satuan']."\" target=\"_self\" class=\"merah\" title=\"Untuk Menghapus data...\">Hapus</a>
					  </td>
					</tr>
				";
		}
	}

	$body.="</table>";
	$body.="<br />";
?>