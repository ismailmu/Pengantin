<?php
	if(ereg("left.php", $PHP_SELF))
	{
		header("location:index.php");
		die;
	}	
	
	$left.="
			<table width=\"100%\" border=\"0\" cellpadding=\"4\" cellspacing=\"1\">
			  <tbody><tr>
				<td width=\"100%\" bgcolor=\"#dbeaf5\" height=\"27\"><a href=\"user.php?act=product\" target=\"_self\" class=\"bbiru\" title=\"Management Product\">&nbsp; &gt;&gt; Product </a></td>

			  </tr>
			  <tr>
				<td class=\"bhitam\" bgcolor=\"#dbeaf5\" height=\"27\"><a href=\"user.php?act=kategori\" target=\"_self\" title=\"Management Kategori\">&nbsp; &gt;&gt; Kategori</a></td>
			  </tr>
			  <tr>
				<td class=\"bhitam\" bgcolor=\"#dbeaf5\" height=\"27\">&nbsp;<a href=\"user.php?act=satuan\" target=\"_self\" title=\"Management Satuan\">&nbsp;&gt;&gt; Satuan</a></td>
			  </tr>
			  <tr>
				<td class=\"bhitam\" bgcolor=\"#dbeaf5\" height=\"27\">&nbsp; &gt;&gt; <a href=\"user.php?act=berita\" target=\"_self\" title=\"Management Berita\">Berita</a></td>
			  </tr>"./*
			  <tr>
                <td class=\"bhitam\" bgcolor=\"#dbeaf5\" height=\"27\">&nbsp;&nbsp;&gt;&gt; Pembayaran</td>
			    </tr>
			  <tr>
                <td class=\"bhitam\" bgcolor=\"#dbeaf5\" height=\"27\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"user.php?act=bayar_pending\" target=\"_self\" title=\"Management Pembayaran\">&nbsp;&gt;&gt; Pending</a></td>
			    </tr>
			  <tr>
				<td class=\"bhitam\" bgcolor=\"#dbeaf5\" height=\"27\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"user.php?act=bayar_sukses\" target=\"_self\" title=\"Management Pembayaran\">&nbsp;&gt;&gt; Sukses</a></td>
			  </tr>
			  <tr>
				<td class=\"bhitam\" bgcolor=\"#dbeaf5\" height=\"27\">&nbsp;<a href=\"user.php?act=pelanggan\" target=\"_self\" title=\"Management Pelanggan\">&nbsp;&gt;&gt; Pelanggan</a></td>
			  </tr>
			  <tr>
				<td class=\"bhitam\" bgcolor=\"#dbeaf5\" height=\"27\">&nbsp; <a href=\"user.php?act=pengunjung\" target=\"_self\" title=\"Management Pengunjung\">&gt;&gt; Pengunjung</a></td>
			  </tr>.*/"
			  <tr>
				<td class=\"bhitam\" bgcolor=\"#dbeaf5\" height=\"27\">&nbsp; <a href=\"user.php?act=logout\" target=\"_self\" class=\"bmerah\" title=\"Keluar\">&gt;&gt; Logout</a></td>
			  </tr>
			</tbody></table>
			

		";
?>