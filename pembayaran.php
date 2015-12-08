<?php
	if($_POST['konfirm'] || $_POST['batal']) {
		if($_POST['batal']) {
			session_unregister(id_product);
			session_unregister(waktu);
		}
		else {
			$nama=$_POST['nama'];
			$email=$_POST['email'];
			$phone=$_POST['phone'];
			$alamat=$_POST['alamat'];
			$kota=$_POST['kota'];
			$kodepos=$_POST['kodepos'];
			$pesan=$_POST['pesan'];
			$jaddcart=$_POST['jaddcart'];
			$group_product="";
			for($i=0;$i<$jaddcart;$i++) {
				$group_product.="&".$_POST['product'.$i];
			}
			
			$errnama=($nama=="")?"<blink>Nama masih kosong</blink>":"";
			$erremail=($email!="" && !eregi(VALEMAIL,$email))?"<blink>Format Email salah</blink>":"";
			$errphone=($phone!="" && !is_numeric($phone))?"<blink>Phone harus angka</blink>":"";
			$erralamat=($alamat=="")?"<blink>Alamat masih kosong</blink>":"";
			$errkota=($kota=="")?"<blink>Kota masih kosong":"";
			$errkodepos=($kodepos!="" && !is_numeric($kodepos))?"<blink>Kodepos harus angka</blink>":"";
			
			
			if( $errnama=="" && $erremail=="" && $errphone=="" && $erralamat=="" && $errkota=="" && $errkodepos=="" && $group_product!="" ) {
				if($qsandi=new query("select distinct id_transaksi from transaksi where status='1' order by id_transaksi desc limit 0,1")) {
					if($qsandi->rs_count) {
						$qsandi->fetch();
						$sandi=$qsandi->row['id_transaksi']+1;
					}
					else $sandi=100;
				}
				
				if($qpelanggan=new query("select id_pelanggan from pelanggan order by id_pelanggan desc limit 0,1")) {
					if($qpelanggan->rs_count) {
						$qpelanggan->fetch();
						$id_pelanggan=$qpelanggan->row['id_pelanggan']+1;
					}
					else $id_pelanggan=100;
					
					mysql_query("insert into pelanggan(id_pelanggan,nama,email,phone,alamat,kota,kodepos,pesan) values('$id_pelanggan','$nama','$email','$phone','$alamat','$kota','$kodepos','$pesan')");
				}
				
				$array_product=explode("&",$group_product);
				foreach($array_product as $value) {
					mysql_query("insert into transaksi(id_transaksi,id_product,id_pelanggan,status,tanggal) values('$sandi','$value','$id_pelanggan','1','".TANGGAL."')");
				}
				session_unregister(id_product);
				session_unregister(waktu);	
			}
			else $isi.="<p align=\"center\" class=\"merah\"><blink>Data isian anda kurang lengkap, mohon periksa kembali data isian anda !!!</blink></p>";
		}		 
	}
	if($_SESSION['id_product']) {
		$where_product=" and ( p.id_product='".str_replace("&","' or p.id_product='",$_SESSION['id_product'])."')";
		
		$isi.="
				<div class=\"judul\"> Tahap Pembayaran </div>
				<div style=\"padding-top:8px;\">
				    <p class=\"merah\"><b>Barang yang telah anda pesan telah terinci disini : </b></p>
				    <form action=\"index.php?act=$_GET[act]\" method=\"post\" name=\"pesan\" target=\"_self\">
				";
		if($product=new query("select distinct p.id_product as id_product,p.nama as nama,p.harga as harga,s.nama as nama_satuan,p.keterangan as keterangan from product as p,satuan as s where p.id_satuan=s.id_satuan $where_product ")) {
			for($i=0;$i<$product->rs_count;$i++) {
				$product->fetch($i);
				
				$harga=$harga+$product->row['harga'];
				$value_keterangan="";
				$array_isi=explode("\n",$product->row['keterangan']);
				foreach($array_isi as $value) {
					$value_keterangan.="<li>$value <br /></li>";
				}
				
				$isi.="
						<table width=\"532\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
						  <tr>
							<td width=\"132\" align=\"left\" valign=\"top\" class=\"dimage\"><a href=\"index.php?act=$_GET[act]&view=".$product->row['id_product']."\" onclick=\"document.getElementById('tview').style.display='block'; return getData('view.php?id_product=".$product->row['id_product']."','view');\" target=\"_self\"><img src=\"gallery/".$product->row['id_product'].".jpg\" class=\"image\" /></a><br />
							&nbsp;&nbsp;&nbsp;<a href=\"index.php?act=$_GET[act]&view=".$product->row['id_product']."\" onclick=\"document.getElementById('tview').style.display='block'; return getData('view.php?id_product=".$product->row['id_product']."','view');\" class=\"kuning\" target=\"_self\"><b>View Detail</b></a></td>
							<td width=\"400\" align=\"left\" valign=\"top\" class=\"bborder\"><br />
								<b class=\"bmerah\">".$product->row['nama']."</b><br />
								<b>".showRupiah($product->row['harga'])." / ".$product->row['nama_satuan']."</b>
								<ul>$value_keterangan</ul>
								<input type=\"checkbox\" name=\"product$i\" id=\"product$i\" value=\"".$product->row['id_product']."\" checked=\"checked\" /> Pilihan barang pesanan anda.<br />&nbsp;
							</td>
						  </tr>
						</table>
					";
			}
		}
		
		$isi.="
					<input name=\"jaddcart\" id=\"jaddcart\" type=\"hidden\" value=\"$i\" />
					  <table width=\"422\" border=\"0\" cellspacing=\"0\" cellpadding=\"3\">
                        <tr>
                          <td colspan=\"3\" class=\"bborder\" align=\"center\">
						  <table width=\"282\" border=\"0\" cellspacing=\"0\" cellpadding=\"5\" style=\"font-weight:bold\">
                            <tr>
                              <td colspan=\"5\" align=\"left\" valign=\"top\">&nbsp;</td>
                            </tr>
                            <tr>
                              <td width=\"5\" align=\"left\" valign=\"top\">&nbsp;</td>
                              <td width=\"98\" align=\"left\" valign=\"top\">Jumlah Bayar </td>
                              <td width=\"5\" align=\"left\" valign=\"top\">:</td>
                              <td width=\"118\" align=\"right\" valign=\"top\">".showRupiah($harga)."</td>
                              <td width=\"6\" align=\"right\" valign=\"top\">&nbsp;</td>
                            </tr>
				";
		if($qsandi=new query("select distinct id_transaksi from transaksi where status='1' order by id_transaksi desc limit 0,1")) {
			if($qsandi->rs_count) {
				$qsandi->fetch();
				$sandi=$qsandi->row['id_transaksi']+1;
			}
			else $sandi=100;
			
			$isi.="
								<tr>
								  <td align=\"center\" valign=\"top\">&nbsp;</td>
								  <td align=\"left\" valign=\"top\">Sandi Belanja </td>
								  <td align=\"left\" valign=\"top\">:</td>
								  <td align=\"right\" valign=\"top\">$sandi &nbsp;&nbsp;</td>
								  <td align=\"right\" valign=\"top\">&nbsp;</td>
								</tr>
				";
		}
        $isi.="
					 <tr class=\"merah\">
                              <td align=\"center\" valign=\"top\">&nbsp;</td>
                              <td align=\"left\" valign=\"top\" style=\"border-top:1px solid #888888\">Total</td>
                              <td align=\"left\" valign=\"top\" style=\"border-top:1px solid #888888\">:</td>
                              <td align=\"right\" valign=\"top\" style=\"border-top:1px solid #888888\">".showRupiah($harga+$sandi)."</td>
                              <td align=\"right\" valign=\"top\">&nbsp;</td>
                            </tr>
                            <tr>
                              <td colspan=\"5\" align=\"center\" valign=\"top\">&nbsp;</td>
                            </tr>
                          </table>
						  </td>
                        </tr>
                        <tr>
                          <td colspan=\"3\">&nbsp;</td>
                        </tr>
                        <tr>
                          <td colspan=\"3\">Sebagai data kelengkapan pembelanjaan anda, Isilah form dibawah ini dengan benar<span class=\"merah\"> ( digunakan sebagai Data Pembeli serta Alamat pengiriman Barang ).</span></td>
                        </tr>
                        <tr>
                          <td colspan=\"3\">&nbsp;</td>
                        </tr>
                        <tr>

                          <td width=\"67\" align=\"left\" valign=\"top\" bgcolor=\"#f5f5f5\">Nama</td>
                          <td width=\"5\" valign=\"top\" bgcolor=\"#f5f5f5\">:</td>
                          <td width=\"332\" align=\"left\" valign=\"top\" bgcolor=\"#f5f5f5\"><input name=\"nama\" type=\"text\" id=\"nama\" size=\"30\" maxlength=\"50\" value=\"$nama\" /> <span class=\"merah\">*</span>
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
                          <td align=\"left\" valign=\"top\"><input name=\"alamat\" type=\"text\" id=\"alamat\" size=\"40\" maxlength=\"70\" value=\"$alamat\" /> <span class=\"merah\">*</span>
                          <div id=\"erralamat\" class=\"merah\">$erralamat</div></td>
                        </tr>
                        <tr>
                          <td align=\"left\" valign=\"top\" bgcolor=\"#f5f5f5\">Kota</td>

                          <td valign=\"top\" bgcolor=\"#f5f5f5\">:</td>
                          <td align=\"left\" valign=\"top\" bgcolor=\"#f5f5f5\"><input name=\"kota\" type=\"text\" id=\"kota\" size=\"20\" maxlength=\"50\" value=\"$kota\" /> <span class=\"merah\">*</span>
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
                          <td colspan=\"3\" align=\"center\" bgcolor=\"#f5f5f5\"><input name=\"batal\" type=\"submit\" id=\"batal\" style=\"border:groove 2px #CCFFCC\" value=\"Pembatalan Belanja\">
                            &nbsp;
                            <input name=\"konfirm\" type=\"submit\" id=\"konfirm\" style=\"border:groove 2px #CCFFCC\" value=\" Konfirmasi Belanja \"></td>
                        </tr>
                        <tr>
                          <td colspan=\"3\">&nbsp;</td>
                        </tr>
                        <tr>
                          <td colspan=\"3\" align=\"left\" bgcolor=\"#f5f5f5\"><span class=\"merah\">*</span> ( Data yang harus anda isi )</td>
                        </tr>
                      </table>
			        </form>
			      </div>
			";
	}
	else {
		if( $_POST['konfirm'] ) { 
			if($qharga=new query("select sum(p.harga) as harga from product as p,transaksi as t where p.id_product=t.id_product and t.status='1' and t.id_transaksi='$sandi' group by t.id_transaksi")) {
				if($qharga->rs_count) {
					$qharga->fetch();
					$harga=$qharga->row['harga'];
				}
			}
			
			$isi.="
				<p align=\"center\" class=\"merah\"><blink>Data Belanja anda telah terproses, Terima kasih telah mengunjungi Website kami !!!</blink></p>
				<div id=\"isi\">
					<div class=\"judul\"> Tahap Pembayaran </div>
					  <div style=\"padding-top:8px;\">
						  <p class=\"kuning\"><b>Konfirmasi belanja  anda telah selesai: </b></p>
						  <table width=\"282\" border=\"0\" cellspacing=\"0\" cellpadding=\"5\" style=\"font-weight:bold\" align=\"center\">
							<tr>
							  <td colspan=\"5\" align=\"left\" valign=\"top\">&nbsp;</td>
							</tr>
							<tr>
							  <td width=\"5\" align=\"left\" valign=\"top\">&nbsp;</td>
							  <td width=\"98\" align=\"left\" valign=\"top\">Jumlah Bayar </td>
							  <td width=\"5\" align=\"left\" valign=\"top\">:</td>
							  <td width=\"118\" align=\"right\" valign=\"top\">".showRupiah($harga)."</td>
							  <td width=\"6\" align=\"right\" valign=\"top\">&nbsp;</td>
							</tr>
							<tr>
							  <td align=\"center\" valign=\"top\">&nbsp;</td>
							  <td align=\"left\" valign=\"top\">Sandi Belanja </td>
							  <td align=\"left\" valign=\"top\">:</td>
							  <td align=\"right\" valign=\"top\">$sandi&nbsp;&nbsp;</td>
							  <td align=\"right\" valign=\"top\">&nbsp;</td>
							</tr>
							<tr>
							  <td align=\"center\" valign=\"top\">&nbsp;</td>
							  <td align=\"left\" valign=\"top\" style=\"border-top:1px solid #888888\">Total</td>
							  <td align=\"left\" valign=\"top\" style=\"border-top:1px solid #888888\">:</td>
							  <td align=\"right\" valign=\"top\" class=\"merah\" style=\"border-top:1px solid #888888\">".showRupiah($harga+$sandi)."</td>
							  <td align=\"right\" valign=\"top\">&nbsp;</td>
							</tr>
							<tr>
							  <td colspan=\"5\" align=\"center\" valign=\"top\">&nbsp;</td>
							</tr>
						  </table>
						  <p>Setelah proses ini, maka segeralah melakukan pembayaran yaitu dengan mentransfer ke <strong>No Rekening kami : 1530268540 Bank BCA</strong>, maka barang akan segera kami kirimkan ( <strong>proses max 24jam </strong>) yaitu setelah anda melakukan konfirmasi pembayaran ke pada kami bisa melalui Yahoo Messanger, SMS atau via Telefon ke showroom kami dengan melaporkan <strong>3 digit</strong> dari Nominal Harga yang harus anda bayar sebagai kode Sandi barang belanjaan anda. </p>
						  <p><strong>Catatan :
						  </strong></p>
						  <p>Untuk batas akhir pembayaran belanjaan anda maksimal 7 Hari, apabila lebih dari dari itu maka data perbelanjaan anda secara otomatis akan terhapus.</p>
	
						  <p>Pastikan pelayanan kami akan selalu memuaskan anda.</p>
						  <p class=\"bmerah\">Terima kasih telah mengunjungi Website kami . </p>
					  </div>
					</div>
				";
		}
		else if( $_POST['batal'] ) {
			 $isi.="<p align=\"center\" class=\"merah\"><blink>Data Belanja anda telah dihapus, Terima kasih telah mengunjungi Website kami !!!</blink></p>";
			 include("product.php");
		}
		else {
			 $isi.="<p align=\"center\" class=\"merah\"><blink>Keranjang belanja anda masih kosong, lakukan pembelanjaan dengan mengklik AddToCart pada product yang ingin anda miliki !!!</blink></p>";
			 include("product.php");
		}
		
	}
?>