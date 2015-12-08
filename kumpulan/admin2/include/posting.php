<?php
	// ***************************************************
	// File posting.php
	// File ini akan diperlukan oleh file-file php lainnya
	// ***************************************************
	
	if(ereg("posting.php", $PHP_SELF))
	{
			header("location:../../index.php");
			die;
	}
	
	
	$isiposting="";
	
	$qpkategori=mysql_query("select distinct k.id_kategori,k.nama_kategori from product as p,qproduct as q,skategori as s,kategori as k where q.id_skategori=s.id_skategori and q.id_product=p.id_product and s.id_kategori=k.id_kategori and p.tanggal>='".TGLPOSTING."' and p.status_tampil='1' order by k.id_kategori");
	$jpkategori=mysql_num_rows($qpkategori);
	while($dpkategori=mysql_fetch_array($qpkategori)) {
		$noskategori=1;
		$isiposting.="<p class=\"kuning\"><span class=\"bbiru\">$dpkategori[1]</span><br />";
		
		$qpskategori=mysql_query("select distinct q.id_skategori,s.nama_skategori from product as p,qproduct as q,skategori as s where q.id_skategori=s.id_skategori and q.id_product=p.id_product and s.id_kategori='$dpkategori[0]' and p.tanggal>='".TGLPOSTING."' and p.status_tampil='1' order by q.id_skategori");
	
		while($dpskategori=mysql_fetch_array($qpskategori)) {
			if($noskategori==1) $isiposting.="<a href=\"?action=product&kcari=$dpskategori[0]&posting=1\" class=\"kuning\">$dpskategori[1]</a>";
			else $isiposting.=", <a href=\"?action=product&kcari=$dpskategori[0]&posting=1\" class=\"kuning\">$dpskategori[1]</a>";
			$noskategori++;
		}
		$isiposting.="</p>";
	}
	
	if($jpkategori>0) $posting.="<table width=\"100%\" border=\"0\" cellspacing=\"10\" cellpadding=\"3\"><tr><td style=\"border-bottom:3px #999999 dotted\"><p class=\"gbmerah\">Posting baru!</p>$isiposting</td></tr></table>";
?>