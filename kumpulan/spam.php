<?php
	include"include/function.php";
	
	$product = "";
	echo "<div align=\"center\">";
	$no=86;
	$direktori=opendir("Thumb2");
	while($dir=readdir($direktori))
	{
		if(is_dir( $dir) || $dir=='Thumbs.db' ) continue;
		echo"$no<br />";
		$array=explode(".",$dir);
		rename("Thumb2/$dir","Thumb2/1h$no.jpg");
		rename("Thumb2/$dir","Thumb2/1h$no.jpg");
		//imageResize("gallery2/$dir","detail/1h$no.$array[1]",600,600);
		//imageResize("gallery2/$dir","gallery/1h$no.$array[1]",200,200);
		$no++;
	}
	echo "</div>";
?>