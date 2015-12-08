<?php
	// ***************************************************
	// File kategori.php
	// File ini akan diperlukan oleh file-file php lainnya
	// ***************************************************
	
	if(ereg("kategori.php", $PHP_SELF))
	{
			header("location:../index.php");
			die;
	}
	
	$ncari=$_POST['ncari'].$_GET['ncari'];
	
	if($_POST['Tambah']) {
		if($_POST['nama_kategori']=="") $informasi="Kategori masih salah / kosong";
		
		if(!$informasi) {
			$qckategori=mysql_query("select id_kategori from kategori order by id_kategori desc limit 0,1");
			$dckategori=mysql_fetch_array($qckategori);
			$id_urut = $dckategori[0]+1;
			$informasi=(mysql_query("insert into kategori values('$id_urut','$_POST[nama_kategori]')"))?"Data $_POST[nama_kategori] telah berhasil disimpan.":"Data $_POST[nama_kategori] telah gagal disimpan.";
		}
	}
	else if($_POST['Ubah']) {
		if($_POST['nama_kategori']=="") $informasi="Kategori masih salah / kosong";
		
		if(!$informasi) 
			$informasi=(mysql_query("update kategori set nama_kategori='$_POST[nama_kategori]' where id_kategori='$_POST[id_kategori]'"))?"Data telah berhasil diubah.":"Data telah gagal diubah.";
	}
	else if($_GET['hapus']) {
		$informasi=(mysql_query("delete from kategori where id_kategori='$_GET[hapus]'"))?"Data telah berhasil dihapus.":"Data telah gagal dihapus.";
	}
	
	$batas=20;
	$limit=($_GET['page'])?($_GET['page']-1)*$batas:0;
	
	$pencarian="
		<form action=\"?action=$action\" method=\"post\" name=\"fcari\" target=\"_self\" id=\"fcari\">&nbsp;&nbsp;&nbsp;<span class=\"bkuning\">Cari :</span>
			  <input name=\"ncari\" type=\"text\" id=\"ncari\" size=\"20\" maxlength=\"20\" value=\"$ncari\"/>
			  <input name=\"cari\" type=\"submit\" class=\"bhitam\" id=\"cari\" value=\"Cari Sekarang\" />
				</form>
		";
		
	$qjkategori=mysql_query("select id_kategori from kategori where nama_kategori like '%$ncari%'");
	$jkategori=mysql_num_rows($qjkategori);
	$hal=ceil($jkategori/$batas);
	
	$paging="";
	
	for($i=1;$i<=$hal;$i++)
	{
		if($hal>1) {
			if($i!=1) $paging.=" || ";
			if($_GET['page']==$i)$paging.="$i";
			else if(($i==1)&&(!$_GET['page']))$paging.="$i";
			else $paging.="<a href=\"?action=$action&ncari=$ncari&page=$i\" class=\"bmerah\">$i</a>";
		}
	}
	
	$isi="
		<table border=\"0\" cellpadding=\"4\" cellspacing=\"1\" width=\"70%\">
		  <tbody>
		  	<tr class=\"kuning\">
			  <td align=\"left\" width=\"4\">&nbsp;</td>
			  <td align=\"left\" colspan=\"3\">$informasi&nbsp;$paging</td>
			</tr>
			<tr class=\"bbiru\">
			  <td align=\"left\">&nbsp;</td>
			  <td width=\"\" align=\"center\" bgcolor=\"#ffcc66\">Nama Kategori </td>
			  <td width=\"90\" align=\"left\" bgcolor=\"#ffcc66\">&nbsp;</td>
			  <td  width=\"4\" align=\"left\">&nbsp;</td>
			</tr>"
		;
	
	$qkategori=mysql_query("select id_kategori,nama_kategori from kategori where nama_kategori like '%$ncari%' limit $limit,$batas");
	
	while($dkategori=mysql_fetch_array($qkategori)) {
		$bgcolor=($warna%2==0)?"bgcolor=\"#eeeeee\"":"";
		$isi.="
				<tr class=\"kuning\">
				  <td align=\"left\">&nbsp;</td>
				  <td align=\"left\" $bgcolor>&nbsp;$dkategori[1]</td>
				  <td align=\"center\" $bgcolor>
				  	<a href=\"?action=$action&ncari=$ncari&page=$_GET[page]&ubah=$dkategori[0]&nama=$dkategori[1]\" target=\"_self\" class=\"sbmerah\" title=\"Untuk merubah data...\">Ubah</a> || 
					<a href=\"?action=$action&ncari=$ncari&page=$_GET[page]&hapus=$dkategori[0]\" target=\"_self\" class=\"sbmerah\" title=\"Untuk merubah data...\">Hapus</a>
				  </td>
				  <td align=\"left\">&nbsp;</td>
				</tr>
			";
		$warna++;
	}
	
	$tombol=($_GET['ubah'])?"Ubah":"Tambah";

	$isi.="</table><br />
			<form action=\"?action=$action\" method=\"post\" name=\"fkategori\" target=\"_self\" id=\"fkategori\">&nbsp;&nbsp;&nbsp;<span class=\"bkuning\">Input :</span>
			  <input name=\"id_kategori\" type=\"hidden\" id=\"id_kategori\" value=\"$_GET[ubah]\" /><input name=\"nama_kategori\" type=\"text\" id=\"nama_kategori\" size=\"40\" maxlength=\"40\" value=\"$_GET[nama]\"/>
			  <input name=\"$tombol\" type=\"submit\" class=\"bhitam\" id=\"cari\" value=\"$tombol\" />
				</form>";	
				
	require "include/menukategori.php";
?>