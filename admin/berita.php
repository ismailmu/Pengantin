<?php
	// ***************************************************
	// File berita.php
	// File ini akan diperlukan oleh file-file php lainnya
	// ***************************************************
	
	if(ereg("berita.php", $PHP_SELF))
	{
			header("location:../index.php");
			die;
	}
	
	if($_POST['Simpan']) { //=================================================================== jika submit Simpan
		$ubah=$_POST['ubah'];
		$judul=$_POST['judul'];
		$isi=$_POST['isi'];
		$errjudul=($judul=="")?"Judul masih kosong":"";
		$errisi=($isi=="")?"Isi masih kosong":"";
		
		if($errjudul=="" && $errisi=="") {
			if($ubah) { //====================================================================== jika Text Hidden Ubah
				if(mysql_query("update berita set judul='$judul',isi='$isi',tanggal='".TANGGAL."' where id_berita='$ubah'")) {
					$ubah="";
					$judul="";
					$isi="";
					$errjudul="Data telah berhasil diubah.";
				}
				else $errjudul.="Data telah gagal diubah.$ubah";
			}
			else { //============================================================================ Else  input Berita
				if($query=new query("select id_berita from berita order by id_berita desc limit 0,1")) {
					if($query->rs_count) {
						$query->fetch();
						$id_berita=$query->row['id_berita']+1;
					}
					else $id_berita=1;
				}
				if(mysql_query("insert into berita(id_berita,judul,isi,tanggal) values('$id_berita','$judul','$isi','".TANGGAL."')")) {
					$ubah="";
					$judul="";
					$isi="";
					$errjudul="Data telah berhasil disimpan.";
				}
				else $errjudul.="Data telah gagal disimpan.";
			}
		}
	}
	else if($_GET['hapus']) { //=================================================================== Jika GET Hapus
		$errjudul=(mysql_query("delete from berita where id_berita='$_GET[hapus]'"))?"Data telah berhasil dihapus.":"Data telah gagal dihapus.";
	}
	
	$body.="<br />";
	include("form/berita.php"); // =========================================================== Pemanggilan Form
		
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
	$array_paging=explode("&&",paging($baris_paging,10,"select distinct id_berita from berita where judul like '%$textcari%'",$page,"act=$act&textcari=$textcari"));
	
	$body.="
		<table border=\"0\" cellpadding=\"4\" cellspacing=\"1\" width=\"600\" style=\"border:1px solid #4682b4\">
		  <tbody>
		  	<tr class=\"biru\">
			  <td align=\"left\" colspan=\"3\">".$array_paging[1]."</td>
			</tr>
			<tr class=\"bputih\">
			  <td width=\"20\" align=\"left\" bgcolor=\"#4682b4\">No</td>
			  <td width=\"460\" align=\"center\" bgcolor=\"#4682b4\">Nama Berita </td>
			  <td align=\"left\" bgcolor=\"#4682b4\">&nbsp;</td>
			</tr>"
		;
	
	if($tabel=new query("select id_berita,judul from berita where judul like '%$textcari%' order by tanggal desc limit $array_paging[0],$baris_paging")) {
		for($i=0;$i<$tabel->rs_count;$i++) {
			$tabel->fetch($i);
			
			$no=(($page-1)*$baris_paging)+$i+1;
			$bgcolor=($i%2==0)?"bgcolor=\"#f1f1f1\"":"";
			$body.="
					<tr class=\"kuning\">
					  <td align=\"left\" $bgcolor>$no</td>
					  <td align=\"left\" $bgcolor>&nbsp;".$tabel->row['judul']."</td>
					  <td align=\"center\" $bgcolor>
						<a href=\"?act=$act&textcari=$textcari&page=$page&ubah=".$tabel->row['id_berita']."\" target=\"_self\" class=\"merah\" title=\"Untuk Merubah data...\">Ubah</a> || 
						<a href=\"?act=$act&textcari=$textcari&page=$page&hapus=".$tabel->row['id_berita']."\" target=\"_self\" class=\"merah\" title=\"Untuk Menghapus data...\">Hapus</a>
					  </td>
					</tr>
				";
		}
	}

	$body.="</table>";
	$body.="<br />";
?>