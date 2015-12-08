<?php
	// ***************************************************
	// File product.php
	// File ini akan diperlukan oleh file-file php lainnya
	// ***************************************************

	if(ereg("product.php", $PHP_SELF))
	{
		header("location:../index.php");
		die;
	}
	
	require "include/pencarian.php";
	
	$ncari=$_POST['ncari'].$_GET['ncari'];
	$kcari=$_POST['kcari'].$_GET['kcari'];
	
	$batas=15;
	$limit=($_GET['page'])?($_GET['page']-1)*$batas:0;
	
	if($_GET['posting']) {
		$qposting=" and p.tanggal>='".TGLPOSTING."'";
		$dposting="<p class=\"bbiru\">Product Posting terbaru</p>";
	}
	

//===================================================== PERINTAH INSERT UPDATE DELETE ====================================================================================================================================================================	
	
	if($_POST['jkirim']) {
		
		$erjnama=($_POST['jnama']=="")?"<br /><blink style=\"background-color:#DBD9F9\" class=\"smerah\">&nbsp;Nama Product masih kosong&nbsp;</blink>":"";
		
		$counter_kategori=0;
		for($i=1;$i<=10;$i++) {
			if(($_POST['jkategori'.$i]!="") && ($_POST['jskategori'.$i]!="")) $counter_kategori++;
		}
		$erjkategori=($counter_kategori<1)?"<blink style=\"background-color:#DBD9F9\" class=\"smerah\">&nbsp;Kategori atau sub Kategori masih kosong&nbsp;</blink>":"";
		$erjharga=(empty($_POST['jharga']) || !is_numeric($_POST['jharga']))?"<br /><blink style=\"background-color:#DBD9F9\" class=\"smerah\">&nbsp;Harga masih salah / kosong&nbsp;</blink>":"";
		$erjketerangan=(empty($_POST['jketerangan']))?"<br /><blink style=\"background-color:#DBD9F9\" class=\"smerah\">&nbsp;Keterangan masih kosong&nbsp;</blink>":"";
		
		$file_name1=$HTTP_POST_FILES["jgambar1"]["name"];
		$file_size1=$HTTP_POST_FILES["jgambar1"]["size"];
		$file_tmp1=$HTTP_POST_FILES["jgambar1"]["tmp_name"];
		$file_type1=$HTTP_POST_FILES["jgambar1"]["type"];
		
		$erjgambar1="";
		$erjgambar1.=($file_name1!="" and $file_size1>1000000)?"<br /><blink  style=\"background-color:#DBD9F9\" class=\"smerah\">&nbsp;Ukuran foto terlalu besar&nbsp;</blink>":"";
		$erjgambar1.=( $file_name1!="" and $file_type1 != "image/pjpeg" and $file_type1 != "image/jpg" and $file_type1 != "image/jpeg" and $file_type1 != "image/pjpg")?"<br /><blink style=\"background-color:#DBD9F9\" class=\"smerah\">&nbsp;Format gambar 1 harus jpeg&nbsp;</blink>":"";

		$file_name2=$HTTP_POST_FILES["jgambar2"]["name"];
		$file_size2=$HTTP_POST_FILES["jgambar2"]["size"];
		$file_tmp2=$HTTP_POST_FILES["jgambar2"]["tmp_name"];
		$file_type2=$HTTP_POST_FILES["jgambar2"]["type"];
	
		$erjgambar2="";
		$erjgambar2.=($file_name2!="" and $file_size2>1000000)?"<br /><blink  style=\"background-color:#DBD9F9\" class=\"smerah\">&nbsp;Ukuran foto terlalu besar&nbsp;</blink>":"";
		$erjgambar2.=( $file_name2!="" and $file_type2 != "image/pjpeg" and $file_type2 != "image/jpg" and $file_type2 != "image/jpeg" and $file_type2 != "image/pjpg")?"<br /><blink style=\"background-color:#DBD9F9\" class=\"smerah\">&nbsp;Format gambar 2 harus jpeg&nbsp;</blink>":"";

		$file_name3=$HTTP_POST_FILES["jgambar3"]["name"];
		$file_size3=$HTTP_POST_FILES["jgambar3"]["size"];
		$file_tmp3=$HTTP_POST_FILES["jgambar3"]["tmp_name"];
		$file_type3=$HTTP_POST_FILES["jgambar3"]["type"];
		
		$erjgambar3="";
		$erjgambar3.=($file_name3!="" and $file_size3>1000000)?"<br /><blink  style=\"background-color:#DBD9F9\" class=\"smerah\">&nbsp;Ukuran foto terlalu besar&nbsp;</blink>":"";
		$erjgambar3.=( $file_name3!="" and $file_type3 != "image/pjpeg" and $file_type3 != "image/jpg" and $file_type3 != "image/jpeg" and $file_type3 != "image/pjpg")?"<br /><blink style=\"background-color:#DBD9F9\" class=\"smerah\">&nbsp;Format gambar 3 harus jpeg&nbsp;</blink>":"";
		
		if($erjnama=='' && $erjkategori=='' && $erjharga=='' && $erjketerangan=='' && $erjgambar1=='' && $erjgambar2=='' && $erjgambar3=='') {
			if($_GET['tambah']) {
				$qproduct=mysql_query("select id_product from product order by id_product desc limit 0,1");
				$dproduct=mysql_fetch_array($qproduct);
								
				$no=$dproduct[0]+1;
				if($file_name1!="") {
					$type1=substr($file_type1,6,strlen($file_type1)-6);
					@move_uploaded_file($file_tmp1,"../product/1h$no.$type1");
					imageResize("../product/1h$no.$type1","../product/1h$no.$type1",600,600);
					imageResize("../product/1h$no.$type1","../thumb/1h$no.$type1",100,100);
				}
				if($file_name2!="") {
					$type2=substr($file_type2,6,strlen($file_type2)-6);
					@move_uploaded_file($file_tmp2,"../product/2h$no.$type2");
					imageResize("../product/2h$no.$type2","../product/2h$no.$type2",600,600);
					imageResize("../product/2h$no.$type2","../thumb/2h$no.$type2",100,100);
				}
				if($file_name3!="") {
					$type3=substr($file_type3,6,strlen($file_type3)-6);
					@move_uploaded_file($file_tmp3,"../product/3h$no.$type3");
					imageResize("../product/3h$no.$type3","../product/3h$no.$type3",600,600);
					imageResize("../product/3h$no.$type3","../thumb/3h$no.$type3",100,100);
				}
				
				$qmemail=mysql_query("select email from member");
				while($dmemail=mysql_fetch_array($qmemail)) {
					@mail($dmemail[0],"Posting Product baru."," $_POST[jnama]. \n $_POST[jketerangan]. \n Harga : ".showRupiah($_POST['jharga']).". \n Beli sekarang dan lihat productnya di http://www.solobursasecond.com/?action=product&ncari=$_POST[jnama] ","From: admin@solobursasecond.com \r\n");
				}
				mysql_query("insert into product values('$no','$_POST[jnama]','$_POST[jketerangan]','$type1','$type2','$type3','$_POST[jharga]','".TANGGAL."','1','1')");
				for($i=1;$i<=10;$i++) {
					if(($_POST['jkategori'.$i]!="") && ($_POST['jskategori'.$i]!="")) mysql_query("insert into qproduct values('$no','".$_POST['jskategori'.$i]."')");
				}
				
				$informasi="Data $_POST[jnama] telah berhasil disimpan.<br />";
			}
			else if($_GET['ubah']) {
				if($file_name1!="") {
					$type1=substr($file_type1,6,strlen($file_type1)-6);
					@move_uploaded_file($file_tmp1,"../product/1h$_GET[ubah].$type1");
					imageResize("../product/1h$_GET[ubah].$type1","../product/1h$_GET[ubah].$type1",600,600);
					if(file_exists("../thumb/1h$_GET[ubah].$type1")) unlink("../thumb/1h$_GET[ubah].$type1");
					imageResize("../product/1h$_GET[ubah].$type1","../thumb/1h$_GET[ubah].$type1",100,100);
					
					$foto_1="foto_1='$type1',";
				}
				if($file_name2!="") {
					$type2=substr($file_type2,6,strlen($file_type2)-6);
					@move_uploaded_file($file_tmp2,"../product/2h$_GET[ubah].$type2");
					imageResize("../product/2h$_GET[ubah].$type2","../product/2h$_GET[ubah].$type2",600,600);
					if(file_exists("../thumb/2h$_GET[ubah].$type2")) unlink("../thumb/2h$_GET[ubah].$type2");
					imageResize("../product/2h$_GET[ubah].$type2","../thumb/2h$_GET[ubah].$type2",100,100);
					
					$foto_2="foto_2='$type2',";
				}
				if($file_name3!="") {
					$type3=substr($file_type3,6,strlen($file_type3)-6);
					@move_uploaded_file($file_tmp3,"../product/3h$_GET[ubah].$type3");
					imageResize("../product/3h$_GET[ubah].$type3","../product/3h$_GET[ubah].$type3",600,600);
					if(file_exists("../thumb/3h$_GET[ubah].$type3")) unlink("../thumb/3h$_GET[ubah].$type3");
					imageResize("../product/3h$_GET[ubah].$type3","../thumb/3h$_GET[ubah].$type3",100,100);
					
					$foto_3="foto_3='$type3',";
				}
				
				$qmemail=mysql_query("select email from member");
				while($dmemail=mysql_fetch_array($qmemail)) {
					@mail($dmemail[0],"Posting Product baru."," $_POST[jnama]. \n $_POST[jketerangan]. \n Harga : ".showRupiah($_POST['jharga']).". \n Beli sekarang dan lihat productnya di http://www.solobursasecond.com/?action=product&ncari=$_POST[jnama] ","From: admin@solobursasecond.com \r\n");
				}
				
				mysql_query("update product set nama_product='$_POST[jnama]',ket_product='$_POST[jketerangan]', $foto_1 $foto_2 $foto_3 harga='$_POST[jharga]',tanggal='".TANGGAL."' where id_product='$_GET[ubah]'");
				mysql_query("delete from qproduct where id_product='$_GET[ubah]'");
				for($i=1;$i<=10;$i++) {
					if($_POST['jskategori'.$i]!=""){
						$informasi="Data telah berhasil diubah.<br />";
						mysql_query("insert into qproduct(id_product,id_skategori) values('$_GET[ubah]','".$_POST['jskategori'.$i]."')");
					}
				}
				
			}
		}
		else {
			require "include/jual.php";
			$jual=formJual();
		}
	}
	else if($_GET['tambah']) {
		require "include/jual.php";
		$jual=formJual();
	}
	else if( $_GET['ubah'] || $_GET['hapus']) {
		$qcontent=mysql_query("select distinct p.nama_product,p.ket_product,p.foto_1,p.foto_2,p.foto_3,p.harga from product as p where p.id_product='$_GET[ubah]$_GET[hapus]' and p.status_tampil='1'");
		$dcontent=mysql_fetch_array($qcontent);
		
		if($_GET['hapus']) {
			$informasi=(mysql_query("delete from product where id_product='$_GET[hapus]'"))?"Data telah terhapus!!!<br />":"Data gagal terhapus!!!<br />";
			mysql_query("delete from qproduct where id_product='$_GET[hapus]'");
			if(file_exists("../thumb/1h".$_GET['hapus'].".".$dcontent[2])) unlink("../thumb/1h".$_GET['hapus'].".".$dcontent[2]);
			if(file_exists("../product/1h".$_GET['hapus'].".".$dcontent[2])) unlink("../product/1h".$_GET['hapus'].".".$dcontent[2]);
			if(file_exists("../thumb/2h".$_GET['hapus'].".".$dcontent[3])) unlink("../thumb/2h".$_GET['hapus'].".".$dcontent[3]);
			if(file_exists("../product/2h".$_GET['hapus'].".".$dcontent[3])) unlink("../product/2h".$_GET['hapus'].".".$dcontent[3]);
			if(file_exists("../thumb/3h".$_GET['hapus'].".".$dcontent[4])) unlink("../thumb/3h".$_GET['hapus'].".".$dcontent[4]);
			if(file_exists("../product/3h".$_GET['hapus'].".".$dcontent[4])) unlink("../product/3h".$_GET['hapus'].".".$dcontent[4]);
		}
		else if($_GET['ubah']) {
			require "include/jual.php";
			$jual=formJual();
		}
	}
	
	
	
//=============================================================================================================================================================================================================================================================
	
	$ltambah="<tr><td colspan=\"2\" align=\"left\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"?action=$action&ncari=$ncari&kcari=$kcari&page=$_GET[page]&posting=$_GET[posting]&tambah=1\" target=\"_self\" class=\"bkuning\" style=\"border:1px solid\">&nbsp;Tambah Baru&nbsp;</a></td>";
	
	$qjproduct=mysql_query("select distinct p.id_product from product as p,qproduct as q where p.nama_product like '%$ncari%' and q.id_skategori like '$kcari' and p.id_product=q.id_product and p.status_tampil='1' $qposting");
	$jproduct=mysql_num_rows($qjproduct);
	$hal=ceil($jproduct/$batas);
	
	$paging="";
	
	for($i=1;$i<=$hal;$i++)
	{
		if($hal>1) {
			if($i!=1) $paging.=" || ";
			if($_GET['page']==$i)$paging.="$i";
			else if(($i==1)&&(!$_GET['page']))$paging.="$i";
			else $paging.="<a href=\"?action=$action&ncari=$ncari&kcari=$kcari&page=$i&posting=$_GET[posting]\" class=\"bmerah\">$i</a>";
		}
	}
	
	$qproduct=mysql_query("select distinct p.id_product,p.nama_product,p.ket_product,p.harga,p.foto_1,p.foto_2,p.foto_3 from product as p,qproduct as q where p.nama_product like '%$ncari%' and q.id_skategori like '$kcari' and p.id_product=q.id_product and p.status_tampil='1' $qposting order by tanggal desc limit $limit,$batas");
	
	$product="";
	while($dproduct=mysql_fetch_array($qproduct)) {
		$foto_1=(file_exists("../thumb/1h".$dproduct[0].".".$dproduct[4].""))? "1h".$dproduct[0].".".$dproduct[4]:"blank.png";
		$foto_2=(file_exists("../thumb/2h".$dproduct[0].".".$dproduct[5].""))? "2h".$dproduct[0].".".$dproduct[5]:"blank.png";
		$foto_3=(file_exists("../thumb/3h".$dproduct[0].".".$dproduct[6].""))? "3h".$dproduct[0].".".$dproduct[6]:"blank.png";
	
		$product.="
			<tr bgcolor=\"#ffffff\">
				<td align=\"center\" width=\"350\" style=\"border-bottom:1px solid #333333;border-top:1px solid #333333;border-left:1px solid #333333;\">
					<a href=\"?action=$action&ncari=$ncari&kcari=$kcari&page=$_GET[page]&posting=$_GET[posting]&show=$foto_1\" target=\"_self\" class=\"sbmerah\" title=\"Lihat detailnya...\">
						<img src=\"../thumb/".$foto_1."\"  style=\"border:1px #FF1F22 solid\" \>&nbsp;
					</a>
					<a href=\"?action=$action&ncari=$ncari&kcari=$kcari&page=$_GET[page]&posting=$_GET[posting]&show=$foto_2\" target=\"_self\" class=\"sbmerah\" title=\"Lihat detailnya...\">	
						<img src=\"../thumb/".$foto_2."\"  style=\"border:1px #FF1F22 solid\" \>&nbsp;
					</a>
					<a href=\"?action=$action&ncari=$ncari&kcari=$kcari&page=$_GET[page]&posting=$_GET[posting]&show=$foto_3\" target=\"_self\" class=\"sbmerah\" title=\"Lihat detailnya...\">	
						<img src=\"../thumb/".$foto_3."\"  style=\"border:1px #FF1F22 solid\" \>
					</a>
				</td>
				<td align=\"left\" class=\"skuning\" style=\"border-bottom:1px solid #333333;border-top:1px solid #333333;border-right:1px solid #333333;\"><span  class=\"gbbiru\">$dproduct[1]</span><br />$dproduct[2]<br />Harga : ".showRupiah($dproduct[3])."<br /><a href=\"?action=$action&ncari=$ncari&kcari=$kcari&page=$_GET[page]&posting=$_GET[posting]&ubah=$dproduct[0]\" target=\"_self\" class=\"bmerah\">Ubah</a> || <a href=\"?action=$action&ncari=$ncari&kcari=$kcari&page=$_GET[page]&posting=$_GET[posting]&hapus=$dproduct[0]\" target=\"_self\" class=\"bmerah\">Hapus</a></td>
			</tr>
			<tr><td colspan=\"2\"></td></tr>
			";
	}
	
	$isi="";
	if($_GET['show'] && $_GET['show']!='blank.png') $isi.="<table width=\"100%\" border=\"0\" cellspacing=\"10\" cellpadding=\"3\"><tr><td align=\"center\"><img src=\"../product/$_GET[show]\"   style=\"border:1px #fCaD2F solid\" /></td></tr></table>";
	
	$isi.="<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"3\">$ltambah</tr><tr><td colspan=\"2\" align=\"left\">$informasi $dposting $paging</td></tr>$product<tr><td colspan=\"2\">$paging</td></tr></table>";
?>