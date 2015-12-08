<?php
	if(ereg("login.php", $PHP_SELF))
	{
		header("location:index.php");
		die;
	}	
	
	$body.="
		<br /><br /><br /><br /><br /><br /><br /><br /><br />
		<form id=\"flogin\" name=\"flogin\" method=\"post\" action=\"index.php\">
		  <table width=\"300\" border=\"0\" cellspacing=\"2\" cellpadding=\"4\" style=\"border:1px solid #4682b4\">
			<tr>
			  <td colspan=\"5\" bgcolor=\"#4682b4\" class=\"bputih\" align=\"right\">&nbsp;Login FORM </td>
			</tr>
			<tr>
			  <td colspan=\"5\">&nbsp;</td>
			</tr>
			<tr>
			  <td width=\"10%\">&nbsp;</td>
			  <td width=\"35%\" style=\"border-top:1px solid #4682b4\">&nbsp;User Admin</td>
			  <td width=\"2%\" style=\"border-top:1px solid #4682b4\">:</td>
			  <td width=\"43%\" style=\"border-top:1px solid #4682b4\"><input name=\"user\" type=\"text\" size=\"22\" maxlength=\"25\" /></td>
			  <td width=\"10%\">&nbsp;</td>
			</tr>
			<tr>
			  <td>&nbsp;</td>
			  <td style=\"border-top:1px solid #4682b4\">&nbsp;Password</td>
			  <td style=\"border-top:1px solid #4682b4\">:</td>
			  <td style=\"border-top:1px solid #4682b4\"><input name=\"pass\" type=\"password\" size=\"22\" maxlength=\"25\" /></td>
			  <td>&nbsp;</td>
			</tr>
			<tr>
			  <td>&nbsp;</td>
			  <td colspan=\"3\" style=\"border-top:1px solid #4682b4\">&nbsp;</td>
			  <td>&nbsp;</td>
			</tr>
			<tr>
			  <td colspan=\"5\" bgcolor=\"#dbeaf5\" align=\"right\">
			  	<input name=\"reset\" type=\"reset\" id=\"reset\" value=\" Reset\" />&nbsp;<input type=\"submit\" name=\"login\" value=\" Login \" /></td>
			</tr>
		  </table>
		</form>
		<br /><br /><br /><br /><br /><br /><br /><br /><br />
		";
?>
