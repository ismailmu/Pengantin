<?php
	// ***************************************************
	// File config_db.php
	// File ini akan diperlukan oleh file-file php lainnya
	// ***************************************************
	
	if(ereg("config_db.php", $PHP_SELF))
	{
		header("location:../index.php");
		die;
	}

	$conn=mysql_connect(DB_HOST,DB_USER,DB_PASSWORD);
	mysql_select_db(DB_DATABASE,$conn);
	
	class query{
		var $rs_count;			// recordset result count
		var $rs;				// recordset
		var $row;				// one row data of result

		function query($query){
			$this->rs=mysql_query("$query");
			$this->rs_count=@mysql_num_rows($this->rs);
			if($this->rs_count>0) return true;
			else return false;
		}
	
		function fetch($row_num=0){
			if($row_num>$this->rs_count){
				echo "Data tidak ditemukan dalam recordset<br>";
				return FALSE;
			}
			
			$exec=mysql_data_seek($this->rs, $row_num) or die("kosong"); 
			if($exec){
				$this->row = mysql_fetch_array($this->rs);
		//		$this->row = mysql_fetch_object($this->rs);		if using object, then refer to fields like $this->row->field_name
			}
		}
	}
?>