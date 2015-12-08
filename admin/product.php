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

//================================================================================================ QUERY DATABASES
	if($_POST['Simpan']) { //=================================================================== jika submit Simpan
		$ubah=$_POST['ubah'];
		$nama=$_POST['nama'];
		$kategori0=$_POST['kategori0'];
		$kategori1=$_POST['kategori1'];
		$kategori2=$_POST['kategori2'];
		$harga=$_POST['harga'];
		$satuan=$_POST['satuan'];
		$keterangan=$_POST['keterangan'];
		$file_name=$HTTP_POST_FILES["foto"]["name"];
		$file_size=$HTTP_POST_FILES["foto"]["size"];
		$file_tmp=$HTTP_POST_FILES["foto"]["tmp_name"];
		$file_type=$HTTP_POST_FILES["foto"]["type"];
		
		$errnama=($nama=="")?"Nama masih kosongs $file_name":"";
		$errkategori=($kategori0=="" && $kategori1=="" && $kategori2=="")?"Kategori masih kosong":"";
		$errharga=($harga=="" || !is_numeric($harga))?"Harga masih kosong atau bukan angka":"";
		$errsatuan=($satuan=="")?"Satuan masih kosong":"";
		$errketerangan=($keterangan=="")?"Keterangan masih kosong":"";
		$errfoto="";
		$errfoto.=($file_name!="" and $file_size>1000000)?"<br />Ukuran foto terlalu besar":"";
		$errfoto.=($file_name!="" and $file_type!="image/jpg" and $file_type!="image/jpeg" and $file_type!="image/pjpg" and $file_type!="image/pjpeg")?"<br />Format Foto harus JPG":"";
		
		
		if($errnama=="" && $errkategori=="" && $errharga=="" && $errsatuan=="" && $errketerangan=="" && $errfoto=="") {
			if($ubah) { //====================================================================== jika Text Hidden Ubah
				if(mysql_query("update product set nama='$nama',harga='$harga',id_satuan='$satuan',keterangan='$keterangan',tanggal='".TANGGAL."' where id_product='$ubah'")) {
					$id_product=$ubah;
					$errnama="Data telah berhasil diubah.";
				}
				else $errnama.="Data telah gagal diubah.";
			}
			else { //============================================================================ Else  input Product
				if($query=new query("select id_product from product order by id_product desc limit 0,1")) {
					if($query->rs_count) {
						$query->fetch();
						$id_product=$query->row['id_product']+1;
					}
					else $id_product=1;
				}
				if(mysql_query("insert into product(id_product,nama,harga,id_satuan,keterangan,tanggal,statistik) values('$id_product','$nama','$harga','$satuan','$keterangan','".TANGGAL."','0')")) {
					$errnama="Data telah berhasil disimpan.";
				}
				else $errnama.="Data telah gagal disimpan.";
			}
			
			if($file_name!="") {
				$type="jpg";
				
				if(file_exists("../gallery/$id_product.$type")) unlink("../gallery/$id_product.$type");
				if(file_exists("../detail/$id_product.$type")) unlink("../detail/$id_product.$type");
			
				@move_uploaded_file($file_tmp,"../detail/$id_product.$type");
				imageResize("../detail/$id_product.$type","../gallery/$id_product.$type",110,200);
				imageResize("../detail/$id_product.$type","../detail/$id_product.$type",500,600);
			}
			
			mysql_query("delete from qproduct where id_product='$id_product'");
			if($kategori0) mysql_query("insert into qproduct(id_product,id_kategori) values('$id_product','$kategori0')");
			if($kategori1) mysql_query("insert into qproduct(id_product,id_kategori) values('$id_product','$kategori1')");
			if($kategori2) mysql_query("insert into qproduct(id_product,id_kategori) values('$id_product','$kategori2')");
					
			$ubah="";
			$nama="";
			$kategori0="";
			$kategori1="";
			$kategori2="";
			$harga="";
			$satuan="";
			$keterangan="";		
		}
	}
	else if($_GET['hapus']) { //=================================================================== Jika GET Hapus
		$type="jpg";
		
		if(file_exists("../gallery/$_GET[hapus].$type")) unlink("../gallery/$_GET[hapus].$type");
		if(file_exists("../detail/$_GET[hapus].$type")) unlink("../detail/$_GET[hapus].$type");
		$errnama=(mysql_query("delete from product where id_product='$_GET[hapus]'"))?((mysql_query("delete from qproduct where id_product='$_GET[hapus]'"))?"Data telah berhasil dihapus.":"Data telah gagal dihapus."):"Data telah gagal dihapus.";
	}
//=====================================================================================================================


//=====================================================================================================================	
	$body.="<br />";
	include("form/product.php"); // =========================================================== Pemanggilan Form
		
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
	$array_paging=explode("&&",paging($baris_paging,10,"select distinct id_product from product where nama like '%$textcari%' or keterangan like '%$textcari%' order by tanggal desc" ,$page,"act=$act&textcari=$textcari"));
	
	$body.="
		<table border=\"0\" cellpadding=\"4\" cellspacing=\"1\" width=\"600\" style=\"border:1px solid #4682b4\">
		  <tbody>
		  	<tr class=\"biru\">
			  <td align=\"left\" colspan=\"4\">".$array_paging[1]."</td>
			</tr>
			<tr class=\"bputih\">
			  <td width=\"20\" align=\"left\" bgcolor=\"#4682b4\">No</td>
			  <td width=\"175\" align=\"center\" bgcolor=\"#4682b4\">Nama Product </td>
			  <td width=\"280\" align=\"center\" bgcolor=\"#4682b4\">Keterangan </td>
			  <td align=\"left\" bgcolor=\"#4682b4\">&nbsp;</td>
			</tr>"
		;
	
	if($tabel=new query("select id_product,nama,substring(keterangan,1,47) as keterangan from product where nama like '%$textcari%' or keterangan like '%$textcari%' order by tanggal desc limit $array_paging[0],$baris_paging")) {
		for($i=0;$i<$tabel->rs_count;$i++) {
			$tabel->fetch($i);
			
			$no=(($page-1)*$baris_paging)+$i+1;
			$bgcolor=($i%2==0)?"bgcolor=\"#f1f1f1\"":"";
			$body.="
					<tr class=\"kuning\">
					  <td align=\"left\" $bgcolor>$no</td>
					  <td align=\"left\" $bgcolor>".$tabel->row['nama']."</td>
					  <td align=\"left\" $bgcolor>".$tabel->row['keterangan']."...</td>
					  <td align=\"center\" $bgcolor>
						<a href=\"?act=$act&textcari=$textcari&page=$page&ubah=".$tabel->row['id_product']."\" target=\"_self\" class=\"merah\" title=\"Untuk Merubah data...\">Ubah</a> || 
						<a href=\"?act=$act&textcari=$textcari&page=$page&hapus=".$tabel->row['id_product']."\" target=\"_self\" class=\"merah\" title=\"Untuk Menghapus data...\">Hapus</a>
					  </td>
					</tr>
				";
		}
	}

	$body.="</table>";
	$body.="<br />";
//=====================================================================================================================
?>