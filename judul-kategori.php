<?php
	$judul_kategori="";
	if($qkategori=new query("select id_kategori,nama from kategori")) {
		for($i=0;$i<$qkategori->rs_count;$i++) {
			$qkategori->fetch($i);
			$judul_kategori.="<li><a href=\"index.php?act=product&kategori=".$qkategori->row['id_kategori']."\" target=\"_self\">&gt;&gt;&nbsp; ".$qkategori->row['nama']."</a></li>";
		}
	}
?>