<?php
	// ***************************************************
	// File konsultasi.php
	// File ini akan diperlukan oleh file-file php lainnya
	// ***************************************************
	
	session_start();
	
	if(!session_is_registered(user)){
		header("location:../index.php");
	}
	
	if(ereg("konsultasi.php", $PHP_SELF))
	{
		header("location:../index.php");
		die;
	}
	
	if($_POST['hapus']) {
		for($i=1;$i<=$_POST['jumlah'];$i++) {
			$pilih="pilih$i";
			if($_POST[$pilih]!="") {
				$qckonsultasi=mysql_query("select file from konsultasi where id_konsultasi='$_POST[$pilih]'");
				$dckonsultasi=mysql_fetch_array($qckonsultasi);
				if($dckonsultasi['file']) unlink("../file/$dckonsultasi[file]");
				
				mysql_query("delete from konsultasi where id_konsultasi='$_POST[$pilih]'");
				$body="Pesan sukses dihapus!!!";
			}
		}
	}
	
	if($_POST['kirim']) {
		$isi=$_POST['isi'];
		$untuk=$_POST['nim'];
		
		$file_name=$HTTP_POST_FILES["file"]["name"];
		$file_size=$HTTP_POST_FILES["file"]["size"];
		$file_tmp=$HTTP_POST_FILES["file"]["tmp_name"];
		$file_type=$HTTP_POST_FILES["file"]["type"];
		
		$id_skonsultasi=$_POST['id_konsultasi'];
		$qckonsultasi=mysql_query("select id_konsultasi from konsultasi order by id_konsultasi desc limit 0,1");
		$dckonsultasi=mysql_fetch_array($qckonsultasi);
		$id_konsultasi=$dckonsultasi['id_konsultasi']+1;
		
		$body.="Pesan sukses dikirim!!!";
		$file=($file_name)?$id_konsultasi.$file_name:"";
		@move_uploaded_file($file_tmp,"../file/$file");
		mysql_query("insert into konsultasi(id_konsultasi,isi,dari,untuk,tanggal,file,id_skonsultasi,status)
					values('$id_konsultasi','$isi','$_SESSION[user]','$untuk','".TANGGAL."','$file','$id_skonsultasi','1')");
	}
	
	$body.="<form id=\"form2\" name=\"form2\" method=\"post\" action=\"?action=konsultasi\" enctype=\"multipart/form-data\">";
	
	if($_POST['tambah'] or $_GET['detail']) {
		$id_konsultasi=$_GET['detail'];
		if($_GET['detail']) mysql_query("update konsultasi set status='0' where id_konsultasi='$id_konsultasi'"); // merubah status pesan konsultasi
		
		function showKonsultasi($id_konsultasi) {
			$return="";
			$array_bulan=array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
			
			$qdkonsultasi=mysql_query("select dari,isi,tanggal,id_skonsultasi,file from konsultasi where id_konsultasi='$id_konsultasi'");
			$ddkonsultasi=mysql_fetch_array($qdkonsultasi);
			//--------------------------------------------------------------------------------------------------------
			if($ddkonsultasi['dari']!=$_SESSION['user'] ) { // menampilkan pengirim bila pengirim bukan orang lain
				$qmahasiswa=mysql_query("select nama from mahasiswa where nim='$ddkonsultasi[dari]'");
				$dmahasiswa=mysql_fetch_array($qmahasiswa);
				
				$dari="<span class=\"bhitam\">".$ddkonsultasi['dari']." - ".$dmahasiswa['nama']."</span><br />";
				$bgcolor="";
			}
			else {
				$dari="<span class=\"bhitam\">==== Replay-ku ====</span><br />";
				$bgcolor="#e5e5e5";
			}
			//--------------------------------------------------------------------------------------------------------
			if($ddkonsultasi['file']) { // menampilkan file bila terdapat file
				$file="<br />File : <a href=\"../file/".$ddkonsultasi['file']."\" class=\"bmerah\" target=\"_blank\">".$ddkonsultasi['file']." <img src=\"images/file.gif\" style=\"border:none\" /></a>";
			}
			else $file="";
			//--------------------------------------------------------------------------------------------------------
			if($ddkonsultasi['dari']) { // data ditampilkan bila record pada tabel konsultasi ada
				$return.="
					<tr>
					  <td>&nbsp;</td>
					  <td colspan=\"3\" bgcolor=\"$bgcolor\" style=\"border-top: 1px solid rgb(70, 130, 180);\">$dari<em class=\"biru\">Posting at ".substr($ddkonsultasi['tanggal'],8,2)." ".$array_bulan[substr($ddkonsultasi['tanggal'],5,2)-1]." ".substr($ddkonsultasi['tanggal'],0,4)."</em><br />$ddkonsultasi[isi] $file</td>
					  <td>&nbsp;</td>
					  </tr>
					";
				$return.=showKonsultasi($ddkonsultasi['id_skonsultasi']);
			}
			//--------------------------------------------------------------------------------------------------------
			
			return $return;
		}
		
		$body.=" <br>
				  <table style=\"border: 1px solid rgb(70, 130, 180);\" align=\"center\" border=\"0\" cellpadding=\"3\" cellspacing=\"1\" width=\"90%\">
					<tbody>
					  <tr>
						<td colspan=\"5\" class=\"gputih\" align=\"right\" bgcolor=\"#4682b4\"><input name=\"id_konsultasi\" value=\"$id_konsultasi\" type=\"hidden\"> FORM KONSULTASI </td>
					  </tr>

					  <tr>
						<td width=\"3%\">&nbsp;</td>
						<td colspan=\"3\" align=\"left\">&nbsp;</td>
						<td width=\"3%\">&nbsp;</td>
					  </tr>				
				<tr>
                  <td>&nbsp;</td>
				  <td width=\"11%\" style=\"border-top: 1px solid rgb(70, 130, 180);\">Kirim ke </td>
				  <td width=\"2%\" style=\"border-top: 1px solid rgb(70, 130, 180);\">:</td>
				  <td width=\"85%\" style=\"border-top: 1px solid rgb(70, 130, 180);\"><input name=\"nim\" type=\"text\" id=\"nim\" size=\"15\" maxlength=\"15\" /></td>
				  <td>&nbsp;</td>
				  </tr>
				<tr>
				  <td>&nbsp;</td>
				  <td style=\"border-top: 1px solid rgb(70, 130, 180);\">Attach File</td>
				  <td style=\"border-top: 1px solid rgb(70, 130, 180);\">:</td>
				  <td style=\"border-top: 1px solid rgb(70, 130, 180);\"><input type=\"file\" name=\"file\" size=\"45\" maxlength=\"45\" /></td>
				  <td>&nbsp;</td>
				</tr>
				<tr>

				  <td>&nbsp;</td>
				  <td colspan=\"3\" style=\"border-top: 1px solid rgb(70, 130, 180);\">Isi Konsultasi </td>
				  <td>&nbsp;</td>
				</tr>
				<tr>
				  <td>&nbsp;</td>
				  <td colspan=\"3\"><textarea name=\"isi\" cols=\"105\" rows=\"7\" id=\"isi\"></textarea><br></td>
				  <td>&nbsp;</td>
				</tr>
				<tr>
                  <td>&nbsp;</td>
				  <td colspan=\"3\" style=\"border-top: 1px solid rgb(70, 130, 180);\">&nbsp;</td>
				  <td>&nbsp;</td>
				  </tr>";
		$body.= showKonsultasi($id_konsultasi);
		$body.="	<tr>
					  <td>&nbsp;</td>
					  <td colspan=\"3\" style=\"border-top: 1px solid rgb(70, 130, 180);\">&nbsp;</td>
					  <td>&nbsp;</td>
					 </tr>
					 <tr>
						<td colspan=\"5\" align=\"right\" bgcolor=\"#dbeaf5\"><input name=\"reset\" id=\"reset\" value=\" Reset \" style=\"background: rgb(255, 255, 255) none repeat scroll 0%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial;\" type=\"reset\">
							<input name=\"kirim\" id=\"kirim\" value=\" Kirim\" style=\"background: rgb(255, 255, 255) none repeat scroll 0%; -moz-background-clip: -moz-initial; -moz-background-origin: -moz-initial; -moz-background-inline-policy: -moz-initial;\" type=\"submit\"></td>
					  </tr>
					</tbody>
				  </table>";
	}
			
	$tcari=$_POST['tcari'].$_GET['tcari'];
	$kcari=$_POST['kcari'].$_GET['kcari'];
	if($kcari=="0" || $kcari=="") $where="";
	else $where="and $kcari like '%$tcari%'";
	
	$batas=20;
	$limit=($_GET['page'])?($_GET['page']-1)*$batas:0;
	
	$qjkonsultasi=mysql_query("select distinct k.id_konsultasi from konsultasi as k,mahasiswa as m where k.dari=m.nim and k.untuk='$_SESSION[user]' $where");
	$jkonsultasi=mysql_num_rows($qjkonsultasi);
	$hal=ceil($jkonsultasi/$batas);
	
	$paging="";
	
	for($i=1;$i<=$hal;$i++)
	{
		if($hal>1) {
			if($i!=1) $paging.=" || ";
			if($_GET['page']==$i)$paging.="$i";
			else if(($i==1)&&(!$_GET['page']))$paging.="$i";
			else $paging.="<a href=\"?action=$_GET[action]&tcari=$tcari&kcari=$kcari&page=$i\" class=\"bmerah\">$i</a>";
		}
	}		
	
	$array_kcari=array('k.isi'=>'Isi','k.dari'=>'NIM Pengirim','m.nama'=>'Nama Pengirim');
	
	$body.="<br />
			<table width=\"95%\" border=\"0\" align=\"center\" cellpadding=\"3\" cellspacing=\"1\" style=\"border:1px solid #4682b4;\">
			  <tr class=\"bhitam\">
				<td colspan=\"5\" align=\"left\">
				    Cari :  <input name=\"tcari\" type=\"text\" id=\"tcari\" size=\"20\" maxlength=\"20\" value=\"$tcari\" />
						<select name=\"kcari\" id=\"kcari\">
						  <option value=\"0\">- Pilih Salah Satu -</option>";
						  
	while(list($list,$key)=each($array_kcari)) {
		$selected=($list==$kcari)?"selected=\"selected\"":"";
		$body.="<option value=\"$list\" $selected>$key</option>";
		$i++;
	}
						  
	$body.="			</select>
						 <input name=\"cari\" type=\"submit\" id=\"cari\" value=\" Cari \" />
				</td>
				<td colspan=\"3\" align=\"right\"><input type=\"submit\" name=\"tambah\" value=\" Tambah \" /> <input type=\"submit\" name=\"hapus\" value=\" Hapus \" /></td>
				</tr>
			  <tr>
				<td class=\"bputih\" align=\"center\" bgcolor=\"#4682b4\" width=\"2%\">No</td>
				<td class=\"bputih\" align=\"center\" bgcolor=\"#4682b4\" width=\"10%\">NIK</td>
				<td class=\"bputih\" align=\"center\" bgcolor=\"#4682b4\" width=\"18%\">Nama</td>
				<td class=\"bputih\" align=\"center\" bgcolor=\"#4682b4\" width=\"36%\">Isi Konsultasi </td>
				<td class=\"bputih\" align=\"center\" bgcolor=\"#4682b4\" width=\"2%\">&nbsp;</td>
				<td class=\"bputih\" align=\"center\" bgcolor=\"#4682b4\" width=\"19%\">Tanggal</td>
				<td align=\"center\" bgcolor=\"#4682b4\" width=\"2%\">&nbsp;</td>
			    <td align=\"center\" bgcolor=\"#4682b4\" width=\"10%\">&nbsp;</td>
			  </tr>";
	$qkonsultasi=mysql_query("select distinct k.dari as dari,m.nama as nama,substr(k.isi,1,30) as isi,k.tanggal as tanggal,k.id_konsultasi as id_konsultasi,k.file as file,k.status as status from konsultasi as k,mahasiswa as m where k.dari=m.nim and k.untuk='$_SESSION[user]' $where order by k.tanggal desc limit $limit,$batas");
	
	$no=$limit+1;
	$loop=1;
	while($dkonsultasi=mysql_fetch_array($qkonsultasi)) {
		$bgcolor=($no%2==0)?"bgcolor=\"#f5f5f5\"":"";
		$bold=($dkonsultasi['status']=="1")?"style=\"font-weight:bold\"":"";
		
		$file=($dkonsultasi['file']!="")?"<img src=\"images/file.gif\" style=\"border:none\" />":"";
		$body.="
			  <tr $bgcolor $bold>
				<td align=\"center\">$no</td>
				<td align=\"left\">$dkonsultasi[dari]</td>
				<td align=\"left\">$dkonsultasi[nama]</td>
				<td align=\"left\">$dkonsultasi[isi].....</td>
				<td align=\"left\">$file</td>
				<td align=\"left\">".substr($dkonsultasi['tanggal'],8,2)." ".$array_bln[substr($dkonsultasi['tanggal'],5,2)-1]." ".substr($dkonsultasi['tanggal'],0,4)." ".substr($dkonsultasi['tanggal'],11,8)."</td>
			    <td align=\"center\"><input type=\"checkbox\" name=\"pilih$loop\" value=\"$dkonsultasi[id_konsultasi]\" /></td>
				<td align=\"center\">
				 	<a href=\"?action=$_GET[action]&tcari=$tcari&kcari=$kcari&page=$_GET[page]&detail=$dkonsultasi[id_konsultasi]\" target=\"_self\" class=\"merah\" title=\"Untuk Menampilkan data... \">Show Detail</a>
				</td>
			  </tr>";
		$no++;
		$loop++;
	}
	
	$body.="  <tr>
				<td colspan=\"8\" align=\"right\" bgcolor=\"#dbeaf5\"><input type=\"hidden\" name=\"jumlah\" value=\"".($loop-1)."\" />$paging</td>
				</tr>
			</table></form><br />";
?>