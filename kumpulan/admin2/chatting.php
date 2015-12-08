<?php
	// ***************************************************
	// File chatting.php
	// File ini akan diperlukan oleh file-file php lainnya
	// ***************************************************
	
	if(ereg("chatting.php", $PHP_SELF))
	{
			header("location:../index.php");
			die;
	}
	
	$script="
		<link href=\"chat/chat.css\" rel=\"stylesheet\" type=\"text/css\" />
		<script type=\"text/javascript\" src=\"chat/chat.js\" ></script>
	  ";
	
	$onload="onload=\"init();\"";
	
	$isi="
		  <noscript>
		  Your browser does not support JavaScript!!
		</noscript>
		<table id=\"content\">
		  <tr>
			<td>
			  <div id=\"scroll\">
			  </div>
			</td>
			<td id=\"colorpicker\">
			  <img src=\"chat/palette.png\" id=\"palette\" alt=\"Color 
				   Palette\" border=\"1\" onclick=\"getColor(event);\"/>
			  <br />
			  <input id=\"color\" type=\"hidden\" readonly=\"true\" value=\"#000000\" />
			  <span id=\"sampleText\" class=\"bhitam\">
				( Pilihlah warna pada Text anda )
			  </span>
			</td>
		  </tr>
		</table>
		<div>
		  <input type=\"text\" value=\"Administrator\"  id=\"userName\" maxlength=\"15\" size=\"15\" onblur=\"checkUsername();\"/>
		  <input type=\"text\" id=\"messageBox\" maxlength=\"2000\" size=\"50\" 
				 onkeydown=\"handleKey(event)\"/>
		  <input type=\"button\" value=\"Send\" onclick=\"sendMessage();\" />
		  <input type=\"button\" value=\"Delete All\" onclick=\"deleteMessages();\" />
		</div>
		";
	
	require "include/menukategori.php";
?>