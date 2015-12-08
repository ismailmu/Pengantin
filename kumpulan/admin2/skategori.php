<?php
	// ***************************************************
	// File skategori.php
	// File ini akan diperlukan oleh file-file php lainnya
	// ***************************************************
	
	if(ereg("skategori.php", $PHP_SELF))
	{
			header("location:../index.php");
			die;
	}
	
	$kcari=$_POST['kcari'].$_GET['kcari'].$_POST['id_kategori'];
	$ncari=$_POST['ncari'].$_GET['ncari'];
	
	if($kcari=="") $kcari="%%";
	
	if($_POST['Tambah']) {
		if($_POST['nama_skategori']=="") $informasi="Sub Kategori masih salah / kosong";
		if($_POST['id_kategori']=="%%") $informasi="Kategori belum dipilih";
		
		if(!$informasi) {
			$qcskategori=mysql_query("select id_skategori from skategori order by id_skategori desc limit 0,1");
			$dcskategori=mysql_fetch_array($qcskategori);
			$id_urut = $dcskategori[0]+1;
			$informasi=(mysql_query("insert into skategori values('$id_urut','$_POST[nama_skategori]','$_POST[id_kategori]')"))?"Data $_POST[nama_skategori] telah berhasil disimpan.":"Data $_POST[nama_skategori] telah gagal disimpan.";
		}
	}
	else if($_POST['Ubah']) {
		if($_POST['nama_skategori']=="") $informasi="Sub Kategori masih salah / kosong";
		if($_POST['id_kategori']=="%%") $informasi="Kategori belum dipilih";
		
		if(!$informasi) 
			$informasi=(mysql_query("update skategori set nama_skategori='$_POST[nama_skategori]',id_kategori='$_POST[id_kategori]' where id_skategori='$_POST[id_skategori]'"))?"Data telah berhasil diubah.":"Data telah gagal diubah.";
	}
	else if($_GET['hapus']) {
		$informasi=(mysql_query("delete from skategori where id_skategori='$_GET[hapus]'"))?"Data telah berhasil dihapus.":"Data telah gagal dihapus.";
	}
	
	$selectkategori="";
	
	$qkategori=mysql_query("select id_kategori,nama_kategori from kategori");
	
	while($dkategori=mysql_fetch_array($qkategori)) {
		if($dkategori[0]==$_GET['id_kategori']) $select="selected=\"selected\"";
		else if($dkategori[0]==$kcari) $select="selected=\"selected\"";
		else $select="";
		
		$selectkategori.="<option value=\"$dkategori[0]\" $select>$dkategori[1]</option>";
	}
	
	$pencarian="
		<form action=\"?action=$action\" method=\"post\" name=\"fcari\" target=\"_self\" id=\"fcari\">&nbsp;&nbsp;&nbsp;<span class=\"bkuning\">Cari :</span>
			  <input name=\"ncari\" type=\"text\" id=\"ncari\" size=\"20\" maxlength=\"20\" value=\"$ncari\"/>
			   <select name=\"kcari\" id=\"kcari\">
				<option value=\"%%\">-Pilih Semua-</option>
				$selectkategori
			  </select>
			  <input name=\"cari\" type=\"submit\" class=\"bhitam\" id=\"cari\" value=\"Cari Sekarang\" />
				</form>
		";
	
	$batas=20;
	$limit=($_GET['page'])?($_GET['page']-1)*$batas:0;
	
	$qjskategori=mysql_query("select id_skategori from skategori where nama_skategori like '%$ncari%' and id_kategori like '$kcari'");
	$jskategori=mysql_num_rows($qjskategori);
	$hal=ceil($jskategori/$batas);
	
	$paging="";
	
	for($i=1;$i<=$hal;$i++)
	{
		if($hal>1) {
			if($i!=1) $paging.=" || ";
			if($_GET['page']==$i)$paging.="$i";
			else if(($i==1)&&(!$_GET['page']))$paging.="$i";
			else $paging.="<a href=\"?action=$action&ncari=$ncari&kcari=$kcari&page=$i\" class=\"bmerah\">$i</a>";
		}
	}
	
	$isi="
		<table border=\"0\" cellpadding=\"4\" cellspacing=\"1\" width=\"90%\">
		  <tbody>
		  	<tr class=\"kuning\">
			  <td align=\"left\" width=\"4\">&nbsp;</td>
			  <td align=\"left\" colspan=\"4\">$informasi $paging</td>
			</tr>
			<tr class=\"bbiru\">
			  <td align=\"left\">&nbsp;</td>
			  <td width=\"250\" align=\"left\" bgcolor=\"#ffcc66\">Nama Sub Kategori </td>
			  <td align=\"left\" bgcolor=\"#ffcc66\">Nama Kategori </td>
			  <td width=\"90\" align=\"left\" bgcolor=\"#ffcc66\">&nbsp;</td>
			  <td  width=\"4\" align=\"left\">&nbsp;</td>
			</tr>"
		;
	
	$qskategori=mysql_query("select distinct s.id_skategori,s.nama_skategori,k.nama_kategori,s.id_kategori from skategori as s,kategori as k where s.nama_skategori like '%$ncari%' and s.id_kategori like '$kcari' and k.id_kategori=s.id_kategori order by k.nama_kategori limit $limit,$batas");
	
	while($dskategori=mysql_fetch_array($qskategori)) {
		$bgcolor=($warna%2==0)?"bgcolor=\"#eeeeee\"":"";
		$isi.="
				<tr class=\"kuning\">
				  <td align=\"left\">&nbsp;</td>
				  <td align=\"left\" $bgcolor>$dskategori[1]</td>
				  <td align=\"left\" $bgcolor>$dskategori[2]</td>
				  <td align=\"center\" $bgcolor>
				  	<a href=\"?action=$action&ncari=$ncari&kcari=$kcari&page=$_GET[page]&ubah=$dskategori[0]&nama=$dskategori[1]&id_kategori=$dskategori[3]\" target=\"_self\" class=\"sbmerah\" title=\"Untuk merubah data...\">Ubah</a> || 
					<a href=\"?action=$action&ncari=$ncari&kcari=$kcari&page=$_GET[page]&hapus=$dskategori[0]\" target=\"_self\" class=\"sbmerah\" title=\"Untuk merubah data...\">Hapus</a>
				  </td>
				  <td align=\"left\">&nbsp;</td>
				</tr>
			";
		$warna++;
	}
	
	$tombol=($_GET['ubah'])?"Ubah":"Tambah";

	$isi.="</table><br />
			<form action=\"?action=$action\" method=\"post\" name=\"fskategori\" target=\"_self\" id=\"fskategori\">&nbsp;&nbsp;&nbsp;<span class=\"bkuning\">Input :</span>
			  <input name=\"id_skategori\" type=\"hidden\" id=\"id_kategori\" value=\"$_GET[ubah]\" /><input name=\"nama_skategori\" type=\"text\" id=\"nama_skategori\" size=\"40\" maxlength=\"40\" value=\"$_POST[nama_skategori]$_GET[nama]\"/>
			  <select name=\"id_kategori\" id=\"id_kategori\">
				<option value=\"%%\">-Pilih Kategori-</option>
				$selectkategori
			  </select>
			  <input name=\"$tombol\" type=\"submit\" class=\"bhitam\" id=\"cari\" value=\"$tombol\" />
				</form>";
	
	require "include/menukategori.php";
?>