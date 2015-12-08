<?php
	if($_POST['kirim']) {
		$nama=$_POST['nama'];
		$email=$_POST['email'];
		$phone=$_POST['phone'];
		$alamat=$_POST['alamat'];
		$kota=$_POST['kota'];
		$kodepos=$_POST['kodepos'];
		$pesan=$_POST['pesan'];
		
		$errnama=($nama=="")?"<blink>Nama masih kosong</blink>":"";
		$erremail=($email=="" || !eregi(VALEMAIL,$email))?"<blink>Email masih kosong atau Format salah</blink>":"";
		$errphone=($phone=="" || !is_numeric($phone))?"<blink>Phone masih kosong atau bukan angka</blink>":"";
		$erralamat=($alamat=="")?"<blink>Alamat masih kosong</blink>":"";
		$errkota=($kota=="")?"<blink>Kota masih kosong":"";
		$errkodepos=($kodepos=="" || !is_numeric($kodepos))?"<blink>Kodepos masih kosong atau bukan angka</blink>":"";
		$errpesan=($pesan=="")?"<blink>Pesan masih kosong</blink>":"";
		
		
		if( $errnama=="" && $erremail=="" && $errphone=="" && $erralamat=="" && $errkota=="" && $errkodepos=="" && $errpesan=="" ) {
			if($qpengunjung=new query("select id_pengunjung from pengunjung order by id_pengunjung desc limit 0,1")) {
				if($qpengunjung->rs_count) {
					$qpengunjung->fetch();
					$id_pengunjung=$qpengunjung->row['id_pengunjung']+1;
				}
				else $id_pengunjung=1;
				
				mysql_query("insert into pengunjung(id_pengunjung,nama,email,phone,alamat,kota,kodepos,pesan) values('$id_pengunjung','$nama','$email','$phone','$alamat','$kota','$kodepos','$pesan')");
				
				$nama="";
				$email="";
				$phone="";
				$alamat="";
				$kota="";
				$kodepos="";
				$pesan="";
				
				$errnama="<blink>Pesan anda telah tersimpan,<br />Terima kasih telah mengunjungi Website kami.</blink>";
			}			
		}
	}
	
	$isi.="
				<div class=\"judul\"> Anda dapat menghubungi kami disini </div>
			      <div style=\"padding-top:8px;\">
				    <p class=\"merah\"><b>Selamat datang di Show Room kami : </b></p>
			        <form action=\"index.php?act=$_GET[act]\" method=\"post\" name=\"pesan\" target=\"_self\">
					  <table width=\"422\" border=\"0\" cellspacing=\"0\" cellpadding=\"3\">
                        <tr>
                          <td colspan=\"3\" align=\"left\"><strong>Jl Kebangkitan Nasional no 24</strong></td>
                        </tr>
                        <tr>
                          <td colspan=\"3\" align=\"left\"><strong>Surakarta.</strong></td>
                        </tr>
                        <tr>
                          <td width=\"67\" align=\"left\">Telepon</td>
                          <td width=\"5\">:</td>
                          <td width=\"332\" align=\"left\">0271 719632</td>
                        </tr>
                        <tr>
                          <td align=\"left\">Flexy </td>
                          <td>:</td>
                          <td align=\"left\">0271 5838561</td>
                        </tr>
                        <tr>
                          <td colspan=\"3\" class=\"bborder\">&nbsp;</td>
                        </tr>
                        <tr>
                          <td colspan=\"3\">&nbsp;</td>
                        </tr>
                        <tr>
                          <td colspan=\"3\" align=\"left\"><strong>Jl Kh Samanhudi no 50</strong></td>
                        </tr>
                        <tr>
                          <td colspan=\"3\" align=\"left\"><strong>Surakarta.</strong></td>
                        </tr>
                        <tr>
                          <td align=\"left\">Telepon</td>
                          <td>:</td>
                          <td align=\"left\">0271 722232</td>
                        </tr>
                        <tr>
                          <td align=\"left\">SMS</td>
                          <td>:</td>
                          <td align=\"left\">085725657264</td>
                        </tr>
                        <tr>
                          <td colspan=\"3\" class=\"bborder\">&nbsp;</td>
                        </tr>
                        <tr>
                          <td colspan=\"3\">&nbsp;</td>
                        </tr>
                        <tr>
                          <td align=\"left\">Email</td>
                          <td>:</td>
                          <td align=\"left\"><strong>info@agusbridal.com</strong></td>
                        </tr>
                        <tr>
                          <td colspan=\"3\" class=\"bborder\">&nbsp;</td>
                        </tr>
                        <tr>
                          <td colspan=\"3\">&nbsp;</td>
                        </tr>
                        <tr>
                          <td colspan=\"3\" class=\"merah\">Silahkan untuk mengisi form dibawah ini,  secepatnya kami akan merespon pesan anda.</td>
                        </tr>
                        <tr>
                          <td colspan=\"3\">&nbsp;</td>
                        </tr>
                          <tr>
							<td width=\"67\" align=\"left\" valign=\"top\" bgcolor=\"#f5f5f5\">Nama</td>
							<td width=\"5\" valign=\"top\" bgcolor=\"#f5f5f5\">:</td>
							<td width=\"332\" align=\"left\" valign=\"top\" bgcolor=\"#f5f5f5\"><input name=\"nama\" type=\"text\" id=\"nama\" size=\"30\" maxlength=\"50\" value=\"$nama\" />
								<div id=\"errnama\" class=\"merah\">$errnama</div></td>
						  </tr>
						  <tr>
							<td align=\"left\" valign=\"top\">Email</td>
							<td valign=\"top\">:</td>
							<td align=\"left\" valign=\"top\"><input name=\"email\" type=\"text\" id=\"email\" size=\"30\" maxlength=\"50\" onblur=\"validasi(this,'email')\" value=\"$email\" />
								<div id=\"erremail\" class=\"merah\">$erremail</div></td>
						  </tr>
						  <tr>
							<td align=\"left\" valign=\"top\" bgcolor=\"#f5f5f5\">Phone</td>
							<td valign=\"top\" bgcolor=\"#f5f5f5\">:</td>
							<td align=\"left\" valign=\"top\" bgcolor=\"#f5f5f5\"><input name=\"phone\" type=\"text\" id=\"phone\" size=\"15\" maxlength=\"15\" onkeyup=\"valnumber(this)\" value=\"$phone\" />
								<div id=\"errphone\" class=\"merah\">$errphone</div></td>
						  </tr>
						  <tr>
							<td align=\"left\" valign=\"top\">Alamat</td>
							<td valign=\"top\">:</td>
							<td align=\"left\" valign=\"top\"><input name=\"alamat\" type=\"text\" id=\"alamat\" size=\"40\" maxlength=\"70\" value=\"$alamat\" />
								<div id=\"erralamat\" class=\"merah\">$erralamat</div></td>
						  </tr>
						  <tr>
							<td align=\"left\" valign=\"top\" bgcolor=\"#f5f5f5\">Kota</td>
							<td valign=\"top\" bgcolor=\"#f5f5f5\">:</td>
							<td align=\"left\" valign=\"top\" bgcolor=\"#f5f5f5\"><input name=\"kota\" type=\"text\" id=\"kota\" size=\"20\" maxlength=\"50\" value=\"$kota\" />
								<div id=\"errkota\" class=\"merah\">$errkota</div></td>
						  </tr>
						  <tr>
							<td align=\"left\" valign=\"top\">Kode pos </td>
							<td valign=\"top\">:</td>
							<td align=\"left\" valign=\"top\"><input name=\"kodepos\" type=\"text\" id=\"kodepos\" size=\"6\" maxlength=\"6\" onkeyup=\"valnumber(this)\" value=\"$kodepos\" />
								<div id=\"errkodepos\" class=\"merah\">$errkodepos</div></td>
						  </tr>
						  <tr>
							<td align=\"left\" valign=\"top\" bgcolor=\"#f5f5f5\">Pesan</td>
							<td valign=\"top\" bgcolor=\"#f5f5f5\">:</td>
							<td align=\"left\" valign=\"top\" bgcolor=\"#f5f5f5\"><textarea name=\"pesan\" cols=\"30\" rows=\"3\" id=\"pesan\">$pesan</textarea>
								<div id=\"errpesan\" class=\"merah\">$errpesan</div></td>
						  </tr>
                        <tr>
                          <td colspan=\"3\">&nbsp;</td>
                        </tr>
                        <tr>
                          <td colspan=\"3\" align=\"center\" bgcolor=\"#f5f5f5\"><input type=\"reset\" name=\"Reset\" value=\"Reset\" style=\"border:groove 2px #CCFFCC\">
                            &nbsp;
                            <input type=\"submit\" name=\"kirim\" value=\"Kirim\" style=\"border:groove 2px #CCFFCC\"></td>
                        </tr>
                      </table>
			        </form>
			      </div>
		";
		
	include("posting-laris.php");
	include("posting-baru.php");
?>