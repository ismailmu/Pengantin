<?php	
	if(ereg("berita.php", $PHP_SELF))
	{
		header("location:../index.php");
		die;
	}	
		
	$ubah=($_GET['ubah'])?$_GET['ubah']:$ubah;
	if($_GET['ubah']) {
		if($qubah=new query("select judul,isi from berita where id_berita='$ubah'")) {
			if($qubah->rs_count) {
				$qubah->fetch();
				$judul=$qubah->row['judul'];
				$isi=$qubah->row['isi'];
			}
		}		
	}
	$tombol=($ubah)?"  Ubah  ":" Simpan ";
	$body.="		
		<form action=\"user.php?act=berita\" method=\"post\" name=\"formbutik\" target=\"_self\" id=\"formbutik\">
		  <table width=\"455\" border=\"0\" align=\"center\" cellpadding=\"3\" cellspacing=\"1\" style=\"border:1px solid #4682b4;\">
			<tr>
			  <td height=\"26\" colspan=\"5\" align=\"right\" bgcolor=\"#4682b4\" class=\"bputih\">FORM BERITA &nbsp;&nbsp;</td>
			</tr>
			<tr>
			  <td width=\"24\">&nbsp;</td>
			  <td width=\"81\"><input type=\"hidden\" name=\"ubah\" value=\"$ubah\" /></td>
			  <td width=\"11\">&nbsp;</td>
			  <td width=\"276\">&nbsp;</td>
			  <td width=\"25\">&nbsp;</td>
			</tr>
			<tr>
			  <td>&nbsp;</td>
			  <td align=\"left\" valign=\"top\" style=\"border-top:1px solid #4682b4\">Judul * </td>
			  <td align=\"left\" valign=\"top\" style=\"border-top:1px solid #4682b4\">:</td>
			  <td align=\"left\" valign=\"top\" style=\"border-top:1px solid #4682b4\"><input name=\"judul\" type=\"text\" id=\"judul\" value=\"$judul\" size=\"60\" maxlength=\"150\" />
				<div id=\"errjudul\" class=\"merah\">$errjudul</div></td>
			  <td>&nbsp;</td>
			</tr>
			<tr>
			  <td>&nbsp;</td>
			  <td align=\"left\" valign=\"top\" style=\"border-top:1px solid #4682b4\">Isi * </td>
			  <td align=\"left\" valign=\"top\" style=\"border-top:1px solid #4682b4\">:</td>
			  <td align=\"left\" valign=\"top\" style=\"border-top:1px solid #4682b4\"><textarea name=\"isi\" cols=\"50\" rows=\"10\" id=\"isi\">$isi</textarea>
			  <div id=\"errisi\" class=\"merah\">$errisi</div></td>
			  <td>&nbsp;</td>
			</tr>
			<tr>
			  <td>&nbsp;</td>
			  <td colspan=\"3\" style=\"border-top:1px solid #4682b4\">&nbsp;</td>
			  <td>&nbsp;</td>
			</tr>
			<tr>
			  <td colspan=\"5\" align=\"right\" bgcolor=\"#dbeaf5\"><input name=\"reset\" type=\"reset\" id=\"reset\" value=\"   Reset   \" style=\"background:#FFFFFF\" />
				&nbsp;
				<input name=\"Simpan\" type=\"submit\" id=\"Simpan\" value=\"$tombol\" style=\"background:#FFFFFF\" />          </td>
			</tr>
		  </table>
		</form>
		";
?>