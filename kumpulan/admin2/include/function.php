<?php
	//========================= PENAMBAHAN HARI "$date = date() + day()" =======================//
	// 																							//
	// 				$date adalah data tanggal yang akan ditambah $int_day.						//
	// 		dengan hasil dalam format date sebagai data tanggal setelah ditambah jumlah hari.	//
	// 																							//
	//==========================================================================================//
	function plusDay($date,$int_day)
	{
		$day = substr($date,8,2);
		$month = substr($date,5,2);
		$year = substr($date,0,4);
		
		for($i=0;$i<$int_day;$i++)
		{
			if($month==2)
			{
				if($year%4==0)
				{
					if($day==29)
					{
						$day=1;
						$month=3;
					}
					else $day+=1;
				}
				else if($year%4!=0)
				{
					if($day==28)
					{
						$day=1;
						$month=3;
					}
					else $day+=1;
				}
			}
			else if(($month==1)||($month==3)||($month==5)||($month==7)||($month==8)||($month==10)||($month==12))
			{
				if($day==31)
				{
					$day=1;
					if($month==12)
					{
						$month=1;
						$year+=1;
					}
					else $month+=1;
				}
				else $day+=1;
			}
			else if(($month==4)||($month==6)||($month==9)||($month==11))
			{
				if($day==30)
				{
					$day=1;
					$month+=1;
				}
				else $day+=1;
			}
		}
		
		if(strlen($day)==1) $day = "0".$day;
		if(strlen($month)==1) $month = "0".$month;
		$a = $year."-".$month."-".$day;
		return $a;
	}
	//------------------------------------------------------------------------------------------------------------//
	
	
	
	//========================= PENGURANGAN HARI "$date = date() - day()" ======================//
	// 																							//
	// 				$date adalah data tanggal yang akan dikurangi $int_day.						//
	// 		dengan hasil dalam format date sebagai data tanggal setelah dikurangi jumlah hari.	//
	// 																							//
	//==========================================================================================//
	function minusDay($date,$int_day)
	{
		$day = substr($date,8,2);
		$month = substr($date,5,2);
		$year = substr($date,0,4);
		
		for($i=0;$i<$int_day;$i++)
		{
			if($day==1)
			{
				if($month==3)
				{
					if($year%4==0) $day=29;
					else if($year%4!=0) $day=28;
					$month-=1;
				}
				else if(($month==1)||($month==2)||($month==4)||($month==6)||($month==8)||($month==9)||($month==11))
				{
					$day=31;
					if($month==1)
					{
						$month=12;
						$year-=1;
					}
					else $month-=1;
				}
				else if(($month==5)||($month==7)||($month==10)||($month==12))
				{
					if($day==1)
					{
						$day=30;
						$month-=1;
					}
				}
			}
			else $day-=1;
		}
		
		if(strlen($day)==1) $day = "0".$day;
		if(strlen($month)==1) $month = "0".$month;
		$a = $year."-".$month."-".$day;
		return $a;
	}
	//------------------------------------------------------------------------------------------------------------//
	
	
	
	//====================== PENJUMLAHAN TANGGAL "$day = date() - date()" ======================//
	// 																							//
	// 				$date1 adalah data tanggal yang akan dikurangi $date2.						//
	// 		dengan hasil integer sebagai jumlah hari / jarak hari antara $date2 dan $date1.		//
	// 																							//
	//==========================================================================================//
	function calculateDate($date1,$date2)
	{
		$day1 = substr($date1,8,2)+subcalculateDate(substr($date1,5,2),substr($date1,0,4));
		$day2 = substr($date2,8,2)+subcalculateDate(substr($date2,5,2),substr($date2,0,4));
		
		$a = $day1-$day2;
		return $a;	
	}
	
	function subcalculateDate($month,$year)
	{
		$a = 0;
		for($i=1;$i<$month;$i++)
		{
			if($i==2)
			{
				if($year%4==0) $a+=29;
				else if($year%4!=0) $a+=28;
			}
			else if(($i==1)||($i==3)||($i==5)||($i==7)||($i==8)||($i==10)||($i==12)) $a+=31;
			else if(($i==4)||($i==6)||($i==9)||($i==11)) $a+=30;
		}
		
		for($i=1900;$i<$year;$i++)
		{
			if($i%4==0) $a+=366;
			else if($i%4!=0) $a+=365;
		}
		return $a;
	}
	//---------------------------------------------------------------------------------------------------------//
	
	// Untuk menampilkan data dalam bentuk rupiah.
	function showRupiah($nilai) {
		$panjang=strlen($nilai);
		$sisa=$panjang%3;
		$ulang=($panjang-$sisa)/3;
		$hasil="Rp ".substr($nilai,0,$sisa);
		for($i=0;$i<$ulang;$i++) {
			$hasil.=".".substr($nilai,(3*$i)+$sisa,3);		
		}
		
		return $hasil.".-";	
	}
	//------------------------------------------------------------------------------------------------------------//
	
	// Mengkonversi string menjadi hexadesimal
	function convertPass($param) {
		$len=strlen($param);
		$hasil="";
		for($i=0;$i<$len;$i++) {
			$hasil.=bin2hex(substr($param,$i,1));
		}
		
		return $hasil;
	}
	//----------------------------------------------------------------------------------------------------------//
	
	// Untuk merubah / resize ukuran image Jpg
	function imageResize($FILESRC,$FILETHUMBS,$wm=95,$hws=95) 
	{
		if (file_exists($FILESRC)) 
		{
			list($imagewidth,$imageheight)=getimagesize($FILESRC);
			$mw=$imagewidth;
			$hw=$imageheight;
			if ($imagewidth > $wm) 
			{
				$imageheight=round(($wm/$imagewidth)*$imageheight,0);
				$imagewidth=$wm;
			}
			if ($imageheight >= $hws) 
			{
				$imagewidth=round(($hws/$imageheight)*$imagewidth,0);
				$imageheight=$hws;
			}
			$cc=floor(($hws-$imageheight)/2);
			$ch=floor(($wm-$imagewidth)/2);
			$img_src=imagecreatetruecolor($imagewidth,$imageheight);
			$red01=imagecolorallocate($img_src,48,0,0);
			$red=imagecolorallocate($img_src,0,0,0);
			$wred= imagecolorallocate($img_src,255,255,0);
			$des_src=imagecreatefromjpeg($FILESRC);
			imagecopyresized($img_src,$des_src,0,0,0,0,$imagewidth,$imageheight,$mw,$hw);
			@imagejpeg($img_src,$FILETHUMBS);
			@imagedestroy($img_src);
		}
	}
?>