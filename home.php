<?php
	//----------------------------------- Paging Baru ----------------------------------------------------------------------------------------
	
	$recordBaris=10;
	$recordHalaman=10;
	$array_paging=explode("&&",paging($recordBaris,$recordHalaman,"select id_berita from berita",$_GET['page'],"act=$_GET[act]&id_berita=$_GET[id_berita]"));
	
	//----------------------------------------------------------------------------------------------------------------------------------------
	
	$isi.="
				<div class=\"judul\"> Selamat datang di Salon Agus, Bridal dan Tailor</div>
				  <div style=\"padding-top:8px;\">
					  <p class=\"kuning\"><b>Salon Agus &amp; Galeri Pengantin Ekslusif                 untuk Raja Sehari.</b> </p>
						<p align=\"justify\"><b>Kami</b>                 hanya menawarkan pelayanan yang terbaik kepada para mempelai                 yang inginkan Resepsi Penikahan yang indah dan gemilang dengan                 harga yang pantas. Pengalaman kami yang                 sangatlah luas dalam bidang  perkawinan dengan menghasilkan kualitas                 hasil kerja yang pasti mempesona. </p>
						<p align=\"justify\"><b>Kami</b> menyediakan berbagai pilihan fashion                 pakaian pengantin dan pakaian pertunangan yang terkini dan pilihan                 pelaminan yang terbaru serta memberi hak kepada pelanggan untuk memilih                 sendiri sesuai citarasa dengan harga yang pantas. Paket kami                 juga lengkap dengan  fotographer professional dalam pengabadian                detik-detik bersejarah anda.</p>
						<p align=\"justify\">Selain daripada paket busana                 dan pelaminan, kami juga menyediakan Perawatan Tubuh, muka                 dan SPA bagi para mempelai menyediakan diri untuk Perkawinan yang                 akan berlangsung. </p>
						<div class=\"judul\">Berita Terkini</div>
						<table><tr>
                            <td colspan=\"2\" align=\"center\" valign=\"top\"><div style=\"padding:10px\">$array_paging[1]</div></td>
					      </tr>
		";
		
	if($dberita=new query("select id_berita,judul,isi,tanggal from berita order by tanggal desc limit $array_paging[0],$recordBaris")) {
		for($i=0;$i<$dberita->rs_count;$i++) {
			$dberita->fetch($i);
			$tanggal=substr($dberita->row['tanggal'],8,2)." ".$array_bln[substr($dberita->row['tanggal'],5,2)-1]." ".substr($dberita->row['tanggal'],0,4);
			$isi.="
						  <tr>
                              <td colspan=\"2\" valign=\"top\"><a href=\"index.php?act=berita&id_berita=".$dberita->row['id_berita']."&page_berita=$_GET[page_berita]\" title=\"".$dberita->row['judul']."\" target=\"_self\" class=\"bkuning\">".$dberita->row['judul']."</a></td>
                            </tr>
                            <tr>
                              <td colspan=\"2\" valign=\"top\"> <b>".$array_hari[date("w", mktime(0, 0, 0, substr($dberita->row['tanggal'],5,2), substr($dberita->row['tanggal'],8,2), substr($dberita->row['tanggal'],0,4)))].", $tanggal</b></td>
                            </tr>
                            <tr>
                              <td colspan=\"2\" valign=\"top\" class=\"bborder\"> ".substr($dberita->row['isi'],0,150)."....<a href=\"index.php?act=berita&id_berita=".$dberita->row['id_berita']."&page_berita=$_GET[page_berita]\" title=\"".$dberita->row['judul']."\" target=\"_self\">View Detail</a></td>
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