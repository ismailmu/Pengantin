<?php
// ***************************************************
// File left.php
// File ini akan diperlukan oleh file-file php lainnya
// ***************************************************

if(ereg("left.php", $PHP_SELF))
{
        header("location:../../index.php");
        die;
}

$lkategori=($_GET['lkategori'])?"$_GET[lkategori]":"1";

$left="";
$qkategori=mysql_query("select id_kategori,nama_kategori from kategori");
$jkategori=mysql_num_rows($qkategori);

while($dkategori=mysql_fetch_array($qkategori)) {
	$qskategori=mysql_query("select id_skategori,nama_skategori from skategori where id_kategori='$dkategori[0]'");
	$display=($dkategori[0]==$lkategori)?'block':'none';
	$background=($dkategori[0]==$lkategori)?'#FF9103':'#eaeaea';
	$color=($dkategori[0]==$lkategori)?'bputih':'bhitam';
	$left.="
			<tr bgcolor=\"$background\" class=\"bhitam\">
      			<td style=\"cursor:pointer;\" id=\"t$dkategori[0]\" align=\"left\" valign=\"top\" onclick=\"showLeft($dkategori[0],$jkategori);\" class=\"$color\">$dkategori[1]</td>
    		</tr>
			<tr class=\"bhitam\">
				<td align=\"left\" valign=\"top\"><div id=\"$dkategori[0]\" style=\"display:$display\">";
	while($dskategori=mysql_fetch_array($qskategori)) {
		$left.="&nbsp;&nbsp;<a href=\"?action=product&kcari=$dskategori[0]&lkategori=$dkategori[0]\" class=\"sbhitam\">$dskategori[1]</a><br />";
	}
	$left.="</div></td></tr>";
}
?>