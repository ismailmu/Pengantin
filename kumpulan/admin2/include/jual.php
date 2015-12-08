<?php
	// ***************************************************
	// File jual.php
	// File ini akan diperlukan oleh file-file php lainnya
	// ***************************************************
	
	if(ereg("jual.php", $PHP_SELF))
	{
			header("location:../../index.php");
			die;
	}
	
	//=====================================================dari query product.php untuk menampilkan gambar.====================================
	$foto_1=(file_exists("../thumb/1h".$_GET['ubah'].".".$dcontent[2].$_POST['file_type1'].""))? "1h".$_GET['ubah'].".".$dcontent[2].$_POST['file_type1']:"blank.png";
	$foto_2=(file_exists("../thumb/2h".$_GET['ubah'].".".$dcontent[3].$_POST['file_type2'].""))? "2h".$_GET['ubah'].".".$dcontent[3].$_POST['file_type2']:"blank.png";
	$foto_3=(file_exists("../thumb/3h".$_GET['ubah'].".".$dcontent[4].$_POST['file_type3'].""))? "3h".$_GET['ubah'].".".$dcontent[4].$_POST['file_type3']:"blank.png";
	
	//====================================untuk membuat array bertingkat yang berisi seluruh kategori dan subkategori==========================
	$array_script="function selectKategori(kategori,div) { \n var array_kategori=new Array(); \n switch(kategori) { \n";
	
	$qkategori=mysql_query("select id_kategori,nama_kategori from kategori");
	while($dkategori=mysql_fetch_array($qkategori)) {
		$i=0;
		$array_script.="case '$dkategori[0]': \n";
		
		$qskategori=mysql_query("select id_skategori,nama_skategori from skategori where id_kategori='$dkategori[0]'");
		while($dskategori=mysql_fetch_array($qskategori)) {
			$array_kategori["$dkategori[0]&&$dkategori[1]"]["$dskategori[0]"]=$dskategori[1];
			$array_script.=" array_kategori[$i]=\"$dskategori[0]&&$dskategori[1]\"; \n";
			$i++;
		}
		$array_script.="break \n";
	}
	$array_script.=" default:; \n } \n document.getElementById(div).length=array_kategori.length+1; for(i=0;i<array_kategori.length;i++){ \n 
		var match=array_kategori[i].split('&&');
		document.getElementById(div).options[i+1].value = match[0];
		document.getElementById(div).options[i+1].text = match[1];
	}  \n } \n";
	
	//=====================================fungsi untuk membuat select option==================================================
	function selectOption($name,$param1,$param2,$array_kategori) {
		$select_kategori="<select name=\"j$name\" id=\"j$name\" onchange=\"return selectKategori(this.value,'js$name')\"><option value=\"\">-Pilih salah satu-</option>";
		$select_skategori="<select name=\"js$name\" id=\"js$name\"><option value=\"\">-Pilih salah satu-</option>";
		
		while(list($key,$value)=each($array_kategori)) {
			$kategori=explode('&&',$key);
			$selected1=($param1==$kategori[0])?"selected=\"selected\"":"";
			
			$select_kategori.="<option value=\"$kategori[0]\" $selected1>$kategori[1]</option>";
			
			if($selected1!="") {
				while(list($key2,$value2)=each($value))
				{
					$selected2=($param2==$key2)?"selected=\"selected\"":"";
					$select_skategori.="<option value=\"$key2\" $selected2>$value2</option>";
				}
			}
		}
		
		return "<tr><td width=\"40%\" align=\"left\" valign=\"top\">".$select_kategori."</select></td><td align=\"left\" valign=\"top\">".$select_skategori."</select></td></tr>";
	}
	
	//===========================================untuk menampilkan data pada tabel qproduct dalam link ubah dilanjutkan memanggil fungsi selectOption===========================================
	$jumlah=1;
	$show_kategori="";
	
	$qqproduct=mysql_query("select distinct q.id_skategori,s.id_kategori from qproduct as q,skategori as s where q.id_skategori=s.id_skategori and q.id_product='$_GET[ubah]'");
	while($dqproduct=mysql_fetch_array($qqproduct)) {
		$show_kategori.=selectOption("kategori$jumlah","$dqproduct[1]","$dqproduct[0]",$array_kategori);
		$jumlah++;
	}

	//============================================perulangan untuk memanggil fungsi selectOption========================================================================
	for($i=$jumlah;$i<=10;$i++) {
		$show_kategori.=selectOption("kategori$i",$_POST['jkategori'.$i],$_POST['jskategori'.$i],$array_kategori);
	}
	
	function formJual() {
		global $dcontent,$foto_1,$foto_2,$foto_3,$action,$ncari,$kcari,$show_kategori,$erjnama,$erjkategori,$erjharga,$erjgambar1,$erjgambar2,$erjgambar3,$erjketerangan;
	
		$value.="
			<form action=\"?action=$action&posting=$_GET[posting]&ubah=$_GET[ubah]&tambah=$_GET[tambah]&kcari=%%\" method=\"post\" name=\"jual\" target=\"_self\" id=\"jual\" enctype=\"multipart/form-data\" >
			  <table width=\"600\" border=\"0\" cellspacing=\"0\" cellpadding=\"10\">
				<tr bgcolor=\"#CDCDCD\">
				  <td width=\"183\" align=\"center\" valign=\"top\" bgcolor=\"#f5f5f5\"><span class=\"gbkuning\">Administrator Panel</span><br />
					  <span class=\"sbbiru\">Isikan data dengan benar.</span> </td>
				  <td align=\"right\" valign=\"top\" bgcolor=\"#e9e9e9\" class=\"sbhitam\">* sediakan foto lebih dari satu sudut<br />
					( apabila tersedia )</td>
				</tr>
			  </table>
			  <table width=\"600\" border=\"0\" cellspacing=\"0\" cellpadding=\"5\">
				<tr bgcolor=\"#CDCDCD\">
				  <td width=\"1\" align=\"left\" bgcolor=\"#e9e9e9\">&nbsp;</td>
				  <td width=\"110\" align=\"left\" valign=\"top\" bgcolor=\"#e9e9e9\" class=\"bkuning\">Nama Product</td>
				  <td  width=\"7\" align=\"left\" valign=\"top\" bgcolor=\"#e9e9e9\" class=\"bkuning\">:</td>
				  <td align=\"left\" bgcolor=\"#e9e9e9\"><span class=\"bkuning\">
					<input name=\"jnama\" type=\"text\" id=\"jnama\" size=\"40\" maxlength=\"100\" value=\"$dcontent[0]$_POST[jnama]\" />$erjnama
				  </span></td>
					<td rowspan=\"100\" align=\"center\" valign=\"middle\" bgcolor=\"#e9e9e9\">
						<a href=\"?action=$action&ncari=$ncari&kcari=$kcari&page=$_GET[page]&posting=$_GET[posting]&show=$foto_1&ubah=$_GET[ubah]\" target=\"_self\" class=\"sbmerah\" title=\"Lihat detailnya...\">
							<img src=\"../thumb/".$foto_1."\"  style=\"border:1px #FF1F22 solid\" \>
						</a><input type=\"hidden\" name=\"file_type1\" id=\"file_type1\" value=\"$dcontent[2]$_POST[file_type1]\" /><br />
						<a href=\"?action=$action&ncari=$ncari&kcari=$kcari&page=$_GET[page]&posting=$_GET[posting]&show=$foto_2&ubah=$_GET[ubah]\" target=\"_self\" class=\"sbmerah\" title=\"Lihat detailnya...\">
							<img src=\"../thumb/".$foto_2."\"  style=\"border:1px #FF1F22 solid\" \>
						</a><input type=\"hidden\" name=\"file_type2\" id=\"file_type2\" value=\"$dcontent[3]$_POST[file_type2]\" /><br />
						<a href=\"?action=$action&ncari=$ncari&kcari=$kcari&page=$_GET[page]&posting=$_GET[posting]&show=$foto_3&ubah=$_GET[ubah]\" target=\"_self\" class=\"sbmerah\" title=\"Lihat detailnya...\">
							<img src=\"../thumb/".$foto_3."\"  style=\"border:1px #FF1F22 solid\" \>
						</a><input type=\"hidden\" name=\"file_type3\" id=\"file_type3\" value=\"$dcontent[4]$_POST[file_type3]\" />
					</td>
				  <td align=\"left\" bgcolor=\"#e9e9e9\">&nbsp;</td>
				</tr>
				<tr bgcolor=\"#CDCDCD\">
				  <td bgcolor=\"#e9e9e9\">&nbsp;</td>
				  <td align=\"left\" valign=\"top\" bgcolor=\"#e9e9e9\" class=\"bkuning\">Kategori</td>
				  <td align=\"left\" valign=\"top\" bgcolor=\"#e9e9e9\" class=\"bkuning\">:				</td>
				  <td bgcolor=\"#e9e9e9\" class=\"bkuning\">
					  <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"3\">
						$show_kategori
					  </table>$erjkategori</td>
				  <td bgcolor=\"#e9e9e9\">&nbsp;</td>
				</tr>
				<tr bgcolor=\"#CDCDCD\">
				  <td align=\"left\" bgcolor=\"#e9e9e9\">&nbsp;</td>
				  <td align=\"left\" valign=\"top\" bgcolor=\"#e9e9e9\" class=\"bkuning\">Harga</td>
				  <td align=\"left\" valign=\"top\" bgcolor=\"#e9e9e9\" class=\"bkuning\">: </td>
				  <td align=\"left\" bgcolor=\"#e9e9e9\"><span class=\"bkuning\">
					<input name=\"jharga\" type=\"text\" id=\"jharga\" size=\"10\" maxlength=\"10\" onkeyup=\"valnominal(this)\"  value=\"$dcontent[5]$_POST[jharga]\" />$erjharga
				  </span></td>
				  <td align=\"left\" bgcolor=\"#e9e9e9\">&nbsp;</td>
				</tr>
				<tr bgcolor=\"#CDCDCD\">
				  <td align=\"left\" bgcolor=\"#e9e9e9\">&nbsp;</td>
				  <td align=\"left\" valign=\"top\" bgcolor=\"#e9e9e9\" class=\"bkuning\">File Gambar 1 </td>
				  <td align=\"left\" valign=\"top\" bgcolor=\"#e9e9e9\" class=\"bkuning\">:				</td>
				  <td align=\"left\" bgcolor=\"#e9e9e9\"><span class=\"sbbiru\">
					<input name=\"jgambar1\" type=\"file\" id=\"jgambar1\" size=\"35\" maxlength=\"150\" />
					<br />File support jpg/jpeg. Size max 1Mb $erjgambar1
				  </span></td>
				  <td align=\"left\" bgcolor=\"#e9e9e9\">&nbsp;</td>
				</tr>
				<tr bgcolor=\"#CDCDCD\">
				  <td align=\"left\" bgcolor=\"#e9e9e9\">&nbsp;</td>
				  <td align=\"left\" valign=\"top\" bgcolor=\"#e9e9e9\" class=\"bkuning\">File Gambar 2 </td>
				  <td align=\"left\" valign=\"top\" bgcolor=\"#e9e9e9\" class=\"bkuning\">:				</td>
				  <td align=\"left\" bgcolor=\"#e9e9e9\"><span class=\"sbbiru\">
					<input name=\"jgambar2\" type=\"file\" id=\"jgambar2\" size=\"35\" maxlength=\"150\" />
					<br />File support jpg/jpeg. Size max 1Mb $erjgambar2
				  </span></td>
				  <td align=\"left\" bgcolor=\"#e9e9e9\">&nbsp;</td>
				</tr>
				<tr bgcolor=\"#CDCDCD\">
				  <td align=\"left\" bgcolor=\"#e9e9e9\">&nbsp;</td>
				  <td align=\"left\" valign=\"top\" bgcolor=\"#e9e9e9\" class=\"bkuning\">File Gambar 3 </td>
				  <td align=\"left\" valign=\"top\" bgcolor=\"#e9e9e9\" class=\"bkuning\">:				</td>
				  <td align=\"left\" bgcolor=\"#e9e9e9\"><span class=\"sbbiru\">
					<input name=\"jgambar3\" type=\"file\" id=\"jgambar3\" size=\"35\" maxlength=\"150\" />
					<br />File support jpg/jpeg. Size max 1Mb $erjgambar3
				  </span></td>
				  <td align=\"left\" bgcolor=\"#e9e9e9\">&nbsp;</td>
				</tr>
				<tr bgcolor=\"#CDCDCD\">
				  <td align=\"left\" bgcolor=\"#e9e9e9\">&nbsp;</td>
				  <td align=\"left\" valign=\"top\" bgcolor=\"#e9e9e9\" class=\"bkuning\">Keterangan</td>
				  <td align=\"left\" valign=\"top\" bgcolor=\"#e9e9e9\" class=\"bkuning\">:				</td>
				  <td align=\"left\" bgcolor=\"#e9e9e9\"><span class=\"bkuning\">
					<textarea name=\"jketerangan\" cols=\"30\" rows=\"4\" id=\"jketerangan\">$dcontent[1]$_POST[jketerangan]</textarea>$erjketerangan
				 </span></td>
				  <td align=\"left\" bgcolor=\"#e9e9e9\">&nbsp;</td>
				</tr>
				<tr bgcolor=\"#CDCDCD\">
				  <td colspan=\"4\" align=\"center\" valign=\"top\" bgcolor=\"#e9e9e9\"><input name=\"reset\" type=\"reset\" id=\"reset\" value=\"Reset\" />
				  <input name=\"jkirim\" type=\"submit\" id=\"jkirim\" value=\"Kirim\" /></td>
				  <td align=\"left\" bgcolor=\"#e9e9e9\">&nbsp;</td>
				</tr>
			  </table>
			</form>
			";
				
		return $value;
	}
	
	$script="
			<script language=\"javascript\" type=\"text/javascript\">
				$array_script
			</script>
			";

?>