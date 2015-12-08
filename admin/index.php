<?php
	// *********************************************
	// File index.php
	// *********************************************
	
	session_start();
	
	require "../include/config_session.php";
	
	if($_POST['login'])
	{  	 
		$user=$_POST['user'];
		$pass=convertPass('$_POST[pass]');
		if($one=new query("select * from user where user='$user' and pass='$pass'")) {
			if($one->rs_count<1)
			{	
				session_unregister(user);
				session_unregister(waktu);
				header("location:index.php");
				exit();
			}
			else
			{
				session_register(user);
				session_register(waktu);
				
				header("location:user.php");
				exit();
			}
		}
	}
	else
	{
		require "../include/config_functionclass.php";			//Pemanggilan fungsi class templete.
		
		session_unregister(user);
		session_unregister(waktu);
		//------------------------------------------------------------------------------------------------------------------------------------------------------
		include("login.php");
		
		//----------------------------------------------------------Penjabaran Class Templete.
		$tpl = new template;
		$tpl->define_theme("layout.html");
		$tpl->define_tag("{BODY}",$body);
		$tpl->define_tag("{LEFT}",$left);
		$tpl->parse();
		$tpl->printproses();
		//------------------------------------------------------------------------------------------------------------------------------------------------------
	
	}
?>