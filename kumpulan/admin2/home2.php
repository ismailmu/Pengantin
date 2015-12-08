<?php
	// ***************************************************
	// File home.php
	// File ini akan diperlukan oleh file-file php lainnya
	// ***************************************************
	
	if(ereg("home.php", $PHP_SELF))
	{
			header("location:../index.php");
			die;
	}

	$dhome=mysql_fetch_array(mysql_query("select judul,isi from home"));
	
	$isi="
			<form action=\"?action=home\" method=\"post\" name=\"form1\" target=\"_self\" id=\"form1\">
			  <table width=\"80%\" border=\"0\" cellspacing=\"1\" cellpadding=\"4\" class=\"kuning\">
				<tr bgcolor=\"#ffcc66\" class=\"bbiru\">
				  <td colspan=\"4\" align=\"right\">FORM UPDATE HOME &nbsp;</td>
				</tr>
				<tr>
				  <td width=\"4%\">&nbsp;</td>
				  <td width=\"13%\">&nbsp;</td>
				  <td width=\"79%\">&nbsp;</td>
				  <td width=\"4%\">&nbsp;</td>
				</tr>
				<tr bgcolor=\"#eeeeee\">
				  <td>&nbsp;</td>
				  <td align=\"left\" valign=\"top\">Judul</td>
				  <td align=\"left\" valign=\"top\"><input name=\"judul\" type=\"text\" size=\"100\" maxlength=\"200\" value=\"$dhome[judul]\" /></td>
				  <td>&nbsp;</td>
				</tr>
				<tr>
				  <td>&nbsp;</td>
				  <td align=\"left\" valign=\"top\">Isi</td>
				  <td align=\"left\" valign=\"top\"><textarea name=\"isi\" cols=\"90\" rows=\"7\" id=\"isi\">$dhome[isi]</textarea></td>
				  <td>&nbsp;</td>
				</tr>
				<tr bgcolor=\"#eeeeee\">
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				</tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td><input type=\"submit\" name=\"simpan\" value=\" Simpan \" /></td>
				  <td>&nbsp;</td>
				</tr>
				<tr bgcolor=\"#eeeeee\">
				  <td colspan=\"4\">&nbsp;</td>
				</tr>
			  </table>
			</form>
		";
	
	require "include/menukategori.php";
?>