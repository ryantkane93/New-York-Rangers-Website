<?PHP
// BCS350_10_logoff.php - Logoff
// Written by:  Charles Kaplan, May 2015
include('session.php');
// Logoff by unsetting session variables  
  if (!$logon) $name = "USER";  
  session_unset();
  
  $logon = FALSE;
 
// LOGOFF SCREEN
  echo "<table width='700' align='center' bgcolor='white' cellspacing='10' class='text'>
		<tr><td>&nbsp;</td></tr>
		<tr><td align='center'><b><font size='+2'>$name Logged Off</font></b></td></tr>
		<tr><td>&nbsp;</td></tr>
		</table>\n";
?>