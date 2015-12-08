<?php
	if(ereg("product.php", $PHP_SELF))
	{
		header("location:../index.php");
		die;
	}
	
	function listKategori($namaList,$value) {
		$hasil="<select name=\"$namaList\"><option value=\"\">-Pilih salah satu-</option>";
		
		if($listKategori=new query("select id_kategori,nama from kategori")) {
			for($i=0;$i<$listKategori->rs_count;$i++) {
				$listKategori->fetch($i);
				
				$id_kategori=$listKategori->row['id_kategori'];
				$nama=$listKategori->row['nama'];
				
				$selected=($id_kategori==$value)?"selected=\"selected\"":"";
				
				$hasil.="<option value=\"$id_kategori\" $selected>$nama</option>";
			}
		}
		$hasil.="</select>";
		
		return $hasil;
	}
	
	function listSatuan($value) {
		$hasil="<select name=\"satuan\" id=\"satuan\"><option value=\"0\">- Pilih salah satu -</option>";
		
		if($listSatuan=new query("select id_satuan,nama from satuan")) {
			for($i=0;$i<$listSatuan->rs_count;$i++) {
				$listSatuan->fetch($i);
				$selected=($listSatuan->row['id_satuan']==$value)?"selected=\"selected\"":"";
				$hasil.="<option value=\"".$listSatuan->row['id_satuan']."\" $selected>".$listSatuan->row['nama']."</option>";
			}
		}
		$hasil.="</select>";
		
		return $hasil;
	}
	
	$ubah=($_GET['ubah'])?$_GET['ubah']:$ubah;
	if($_GET['ubah']) {
		$image="<img src=\"../gallery/$ubah.jpg\" class=\"image\" />";
		if($qubah=new query("select distinct nama,harga,id_satuan,keterangan from product where id_product='$ubah'")) {
			if($qubah->rs_count) {
				$qubah->fetch();
				$nama=$qubah->row['nama'];
				$harga=$qubah->row['harga'];
				$id_satuan=$qubah->row['id_satuan'];
				$keterangan=$qubah->row['keterangan'];
			}
		}
		
		if($listProductKategori=new query("select id_kategori from qproduct where id_product='$ubah'")) {
			for($i=0;$i<$listProductKategori->rs_count;$i++) {
				$listProductKategori->fetch($i);
				$kategori[$i]=$listProductKategori->row["id_kategori"];
			}
			$kategori0=$kategori[0];
			$kategori1=$kategori[1];
			$kategori2=$kategori[2];
		}
		
		$satuan=$id_satuan;
	}
	$tombol=($ubah)?"  Ubah  ":" Simpan ";
	$body.="
		<form action=\"user.php?act=product\" method=\"post\" name=\"formbutik\" target=\"_self\" id=\"formbutik\" enctype=\"multipart/form-data\" >
		  <table width=\"520\" border=\"0\" align=\"center\" cellpadding=\"3\" cellspacing=\"1\" style=\"border:1px solid #4682b4;\">
			<tr>
			  <td height=\"26\" colspan=\"5\" align=\"right\" bgcolor=\"#4682b4\" class=\"bputih\">FORM PRODUCT&nbsp;&nbsp;</td>
			</tr>
			<tr>
			  <td width=\"24\">&nbsp;</td>
			  <td width=\"146\"><input type=\"hidden\" name=\"ubah\" value=\"$ubah\" /></td>
			  <td width=\"11\">&nbsp;</td>
			  <td width=\"276\">&nbsp;</td>
			  <td width=\"25\">&nbsp;</td>
			</tr>
			<tr>
			  <td>&nbsp;</td>
			  <td align=\"left\" valign=\"top\" style=\"border-top:1px solid #4682b4\">Nama * </td>
			  <td align=\"left\" valign=\"top\" style=\"border-top:1px solid #4682b4\">:</td>
			  <td align=\"left\" valign=\"top\" style=\"border-top:1px solid #4682b4\"><input name=\"nama\" type=\"text\" id=\"nama\" value=\"$nama\" size=\"60\" maxlength=\"100\" />
				  <div id=\"errnama\" class=\"merah\">$errnama</div></td>
			  <td>&nbsp;</td>
			</tr>
			<tr>
			  <td rowspan=\"3\">&nbsp;</td>
			  <td rowspan=\"3\" align=\"left\" valign=\"top\" style=\"border-top:1px solid #4682b4\">Kategori * </td>
			  <td rowspan=\"3\" align=\"left\" valign=\"top\" style=\"border-top:1px solid #4682b4\">:</td>
			  <td align=\"left\" valign=\"top\" style=\"border-top:1px solid #4682b4\">".listKategori(kategori0,$kategori0)."</td>
			  <td rowspan=\"3\">&nbsp;</td>
			</tr>
			<tr>
			  <td align=\"left\" valign=\"top\" style=\"border-top:1px solid #4682b4\">".listKategori(kategori1,$kategori1)."</td>
			</tr>
			<tr>
			  <td align=\"left\" valign=\"top\" style=\"border-top:1px solid #4682b4\">".listKategori(kategori2,$kategori2)."<div id=\"errkategori\" class=\"merah\">$errkategori</div></td>
			</tr>
			<tr>
			  <td>&nbsp;</td>
			  <td align=\"left\" valign=\"top\" style=\"border-top:1px solid #4682b4\">Harga * </td>
			  <td align=\"left\" valign=\"top\" style=\"border-top:1px solid #4682b4\">:</td>
			  <td align=\"left\" valign=\"top\" style=\"border-top:1px solid #4682b4\"><input name=\"harga\" type=\"text\" id=\"harga\" value=\"$harga\" size=\"20\" maxlength=\"16\" />
				  <div id=\"errharga\" class=\"merah\">$errharga</div></td>
			  <td>&nbsp;</td>
			</tr>
			<tr>
			  <td>&nbsp;</td>
			  <td align=\"left\" valign=\"top\" style=\"border-top:1px solid #4682b4\">Satuan * </td>
			  <td align=\"left\" valign=\"top\" style=\"border-top:1px solid #4682b4\">:</td>
			  <td align=\"left\" valign=\"top\" style=\"border-top:1px solid #4682b4\">".listSatuan($satuan)."<div id=\"errsatuan\" class=\"merah\">$errsatuan</div></td>
			  <td>&nbsp;</td>
			</tr>
			<tr>
			  <td>&nbsp;</td>
			  <td align=\"left\" valign=\"top\" style=\"border-top:1px solid #4682b4\">Foto * </td>
			  <td align=\"left\" valign=\"top\" style=\"border-top:1px solid #4682b4\">:</td>
			  <td align=\"left\" valign=\"top\" style=\"border-top:1px solid #4682b4\"><input name=\"foto\" type=\"file\" id=\"foto\" size=\"50\" maxlength=\"100\" />
				  <div id=\"errfoto\" class=\"merah\">$errfoto</div></td>
			  <td>&nbsp;</td>
			</tr>
			<tr>
			  <td>&nbsp;</td>
			  <td align=\"left\" valign=\"top\" style=\"border-top:1px solid #4682b4\">Keterangan * </td>
			  <td align=\"left\" valign=\"top\" style=\"border-top:1px solid #4682b4\">:</td>
			  <td align=\"left\" valign=\"top\" style=\"border-top:1px solid #4682b4\"><textarea name=\"keterangan\" cols=\"60\" rows=\"5\" id=\"keterangan\">$keterangan</textarea>
				  <div id=\"errketerangan\" class=\"merah\">$errketerangan</div></td>
			  <td>&nbsp;</td>
			</tr>
			<tr>
			  <td>&nbsp;</td>
			  <td colspan=\"3\" style=\"border-top:1px solid #4682b4\" align=\"center\">&nbsp;$image&nbsp;</td>
			  <td>&nbsp;</td>
			</tr>
			<tr>
			  <td colspan=\"5\" align=\"right\" bgcolor=\"#dbeaf5\"><input name=\"reset\" type=\"reset\" id=\"reset\" value=\"   Reset   \" style=\"background:#FFFFFF\" />
				&nbsp;
				<input name=\"Simpan\" type=\"submit\" id=\"Simpan\" value=\"$tombol\" style=\"background:#FFFFFF\" /></td>
			</tr>
		  </table>
		</form>
		";
?>
