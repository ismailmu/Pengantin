<?php
	$posting_baru="<div class=\"judul\">Posting Product TERBARU </div><table width=\"760\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";

	if($product=new query("select distinct p.id_product as id_product,p.nama as nama,p.harga as harga,s.nama as nama_satuan,p.keterangan as keterangan from product as p,qproduct as q,satuan as s where p.id_product=q.id_product and p.id_satuan=s.id_satuan order by p.tanggal desc limit 0,10")) {
		for($i=0;$i<$product->rs_count;$i++) {
			$product->fetch($i);
			
			$value_keterangan="";
			$array_isi=explode("\n",$product->row['keterangan']);
			foreach($array_isi as $value) {
				$value_keterangan.="<li>$value <br /></li>";
			}
			
			if($i%2==0) {
				$posting_baru.="
						  <tr>
							<td width=\"126\" align=\"left\" valign=\"top\" class=\"dimage\"><a href=\"index.php?page=$_GET[page]&act=$_GET[act]&kategori=$kategori&nama=$nama&keterangan=$keterangan&view=".$product->row['id_product']."\" onclick=\"document.getElementById('tview').style.display='block'; return getData('view.php?id_product=".$product->row['id_product']."','view');\" target=\"_self\"><img src=\"gallery/".$product->row['id_product'].".jpg\" class=\"image\" /></a><br />
							  &nbsp;&nbsp;&nbsp;<a href=\"index.php?page=$_GET[page]&act=$_GET[act]&kategori=$kategori&nama=$nama&keterangan=$keterangan&view=".$product->row['id_product']."\" onclick=\"document.getElementById('tview').style.display='block'; return getData('view.php?id_product=".$product->row['id_product']."','view');\" class=\"kuning\" target=\"_self\"><b>View</b></a></td>
							<td width=\"253\" align=\"left\" valign=\"top\" class=\"bborder\"><br />
								<b class=\"bmerah\">".$product->row['nama']./*"</b> <br />
								<b>".showRupiah($product->row['harga'])." / ".$product->row['nama_satuan'].*/"</b>
								<ul>$value_keterangan</ul>
							  <div align=\"left\"><a href=\"index.php?page=$_GET[page]&act=$_GET[act]&kategori=$kategori&nama=$nama&keterangan=$keterangan&addcart=".$product->row['id_product']."\" onclick=\"if(confirm('Yakin anda ingin memasukkan ke keranjang belanja !!!')) { document.getElementById('taddcart').style.display='block'; return getData('addcart.php?id_product=".$product->row['id_product']."','addcart'); } else return false;\" target=\"_self\"><img src=\"images/cart.png\" border=\"0\" /></a></div>
							</td>
					";
			}
			else {
				$posting_baru.="
							<td width=\"127\" align=\"left\" valign=\"top\" class=\"dimage\"><a href=\"index.php?page=$_GET[page]&act=$_GET[act]&kategori=$kategori&nama=$nama&keterangan=$keterangan&view=".$product->row['id_product']."\" onclick=\"document.getElementById('tview').style.display='block'; return getData('view.php?id_product=".$product->row['id_product']."','view');\" target=\"_self\"><img src=\"gallery/".$product->row['id_product'].".jpg\" class=\"image\" /></a><br />
							  &nbsp;&nbsp;&nbsp;<a href=\"index.php?page=$_GET[page]&act=$_GET[act]&kategori=$kategori&nama=$nama&keterangan=$keterangan&view=".$product->row['id_product']."\" onclick=\"document.getElementById('tview').style.display='block'; return getData('view.php?id_product=".$product->row['id_product']."','view');\" class=\"kuning\" target=\"_self\"><b>View</b></a></td>
							<td width=\"254\" align=\"left\" valign=\"top\" class=\"bborder\"><br />
								<b class=\"bmerah\">".$product->row['nama']./*"</b> <br />
								<b>".showRupiah($product->row['harga'])." / ".$product->row['nama_satuan'].*/"</b>
								<ul>$value_keterangan</ul>
							  <div align=\"left\"><a href=\"index.php?page=$_GET[page]&act=$_GET[act]&kategori=$kategori&nama=$nama&keterangan=$keterangan&addcart=".$product->row['id_product']."\" onclick=\"if(confirm('Yakin anda ingin memasukkan ke keranjang belanja !!!')) { document.getElementById('taddcart').style.display='block'; return getData('addcart.php?id_product=".$product->row['id_product']."','addcart'); } else return false;\" target=\"_self\"><img src=\"images/cart.png\" border=\"0\" /></a></div>
							</td>
						  </tr>
					";
			}
		}
		
		if($i%2==1) {
			$posting_baru.="
						<td align=\"left\" valign=\"top\">&nbsp;</td>
						<td width=\"254\" align=\"left\" valign=\"top\" class=\"bborder\">&nbsp;</td>
					  </tr>
				";
		}
	}
	
	$posting_baru.="</table>";
?>