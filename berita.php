<?php		
	//----------------------------------- Paging Baru ----------------------------------------------------------------------------------------
	
	$recordBaris=10;
	$recordHalaman=10;
	$array_paging=explode("&&",paging($recordBaris,$recordHalaman,"select id_berita from berita",$_GET['page'],"act=$_GET[act]&id_berita=$_GET[id_berita]"));
	
	//----------------------------------------------------------------------------------------------------------------------------------------
	
	if($berita=new query("select judul,isi,tanggal from berita where id_berita='$_GET[id_berita]'")) {
		if($berita->rs_count) {
			$berita->fetch();
			$tanggal=substr($berita->row['tanggal'],8,2)." ".$array_bln[substr($berita->row['tanggal'],5,2)-1]." ".substr($berita->row['tanggal'],0,4);
			$array_isi=explode("\n",$berita->row['isi']);
						
			$isi.="
					<div class=\"judul\"> ".$berita->row['judul']."</div>
					  <div style=\"padding-top:8px;\">
						  <p class=\"kuning\"><b>".$array_hari[date("w", mktime(0, 0, 0, substr($berita->row['tanggal'],5,2), substr($berita->row['tanggal'],8,2), substr($berita->row['tanggal'],0,4)))]." $tanggal</b> </p>
				";
			foreach($array_isi as $value) {
				$isi.="<p align=\"justify\">$value</p>";
			}		
			$isi.="
							<div class=\"judul\">Berita Terkini</div>
							<table><tr>
								<td colspan=\"2\" align=\"center\" valign=\"top\"><div style=\"padding:10px\">$array_paging[1]</div></td>
							  </tr>
				";
		}
	}
		
	if($dberita=new query("select id_berita,judul,isi,tanggal from berita order by tanggal desc limit $array_paging[0],$recordBaris")) {
		for($i=0;$i<$dberita->rs_count;$i++) {
			$dberita->fetch($i);
			$tanggal=substr($dberita->row['tanggal'],8,2)." ".$array_bln[substr($dberita->row['tanggal'],5,2)-1]." ".substr($dberita->row['tanggal'],0,4);
			$isi.="
						  <tr>
                              <td colspan=\"2\" valign=\"top\"><a href=\"index.php?act=berita&id_berita=".$dberita->row['id_berita']."&page=$_GET[page]\" title=\"".$dberita->row['judul']."\" target=\"_self\" class=\"bkuning\">".$dberita->row['judul']."</a></td>
                            </tr>
                            <tr>
                              <td colspan=\"2\" valign=\"top\"> <b>".$array_hari[date("w", mktime(0, 0, 0, substr($dberita->row['tanggal'],5,2), substr($dberita->row['tanggal'],8,2), substr($dberita->row['tanggal'],0,4)))].", $tanggal</b></td>
                            </tr>
                            <tr>
                              <td colspan=\"2\" valign=\"top\" class=\"bborder\"> ".substr($dberita->row['isi'],0,150)."....<a href=\"index.php?act=berita&id_berita=".$dberita->row['id_berita']."&page=$_GET[page]\" title=\"".$dberita->row['judul']."\" target=\"_self\">View Detail</a></td>
                            </tr>
				";
		}
	}
	
	$isi.="
					  </table>
					
			      </div>
		";
		
	include("posting-laris.php");
	include("posting-baru.php");
?>