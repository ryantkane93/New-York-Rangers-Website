<!DOCTYPE html>
<html>
  <head>

<title>NYR Advanced Statistics Log-in</title>
<link href="styles.css" type="text/css" rel="stylesheet"/>
</head>

<style type="text/css">

/* header */
header{
	background-color: black;
	border: 3px solid blue;
}

header h1{
	font-family: "Arial Black",Gadget,sans-serif;
	color: blue;
	font-size: 2.3em;
}


aside {    
	width: 210px;	
	padding: 10px;
	color: red;
    background-color: blue;
    float: right;
}


#main h2 {
    border-bottom: thick solid blue;
    padding-bottom: 10px;
	text-align: center;
	font-weight: bold;
	font-variant: small-caps;
	color: red;
}	
	
</style>

<body>

<section id="container">
<div id = "header" class = "center">
<header>
<p><img src="images/hockey_rink.jpg" alt="hockey rink" title = "Hockey Rink Diagram" width="700" height="254" /></p>
<h1>New York Rangers Advanced Statistics Log-in</h1>
</header>
</div>

<div id = "nav" class ="nav">   
   <p>
	<a href = "#Introduction">Introduction</a>
	| <a href = "#Reasons">Prevalence of Advanced Statistics</a>
	| <a href = "#Overview">Website Overview</a>
   </p>
</div>
   
<article id="main">
<div id = "header" class = "center">

<?PHP
// BCS350_logon.php - Logon to BCS350 Website
// Written by:  Charles Kaplan, May 2015
// Modified by: Ryan Kane, December 2015 
 include('session.php'); //Open a session
 
 if($logon) //If the user is already logged on.
 {
	 header('Location: table_update.php'); //Send them to the table update page.
 }
 else { //Allow the user to log in.
 
// Variables  
  $msg = NULL;			// Error Message
  
// Get Form Input  
  if(isset($_POST['logon'])) {
    $userid = trim($_POST['userid']);
    $pword = trim($_POST['password']);
	if ($userid == NULL) 			$msg = "USERID is missing";
    if ($pword == NULL) 			$msg = "PASSWORD is missing";
    if (($userid == NULL) AND ($pword == NULL)) $msg = "USERID & PASSWORD are missing";
	if ($msg == NULL) {
      include('mysql_connect.php');
	  $query = "SELECT rowid, firstname, lastname, role, password, status FROM users WHERE userid='$userid'";
      $result = $mysqli->query($query);
	  if (!$result) $msg = "Error accessing the Users Table " . mysql_error;
	  if ($result->num_rows > 0) {
	    list($student, $firstname, $lastname, $role, $password, $status) = $result->fetch_row();
	    if ($pword == $password)
	      if ($status) {
		    $_SESSION['userid'] = $userid;
		    $_SESSION['role'] = $role;
		    $_SESSION['name'] = $name = "$firstname $lastname";
			$_SESSION['student'] = $student;
		    $logon = TRUE;
			$location = "location: table_update.php"; //Where the web page redirects to after log in successful
			$msg = "<font color='green'><b>$name Logon Successful</b></font>"; 
			header($location);
			exit; 
		    }
		  else $msg = "Your LOGON ID is inactive";
		else $msg = "Invalid Password";
	    }
	  else $msg = "USERID is invalid";
	  }
	}
  
// Logon Screen
  $td = "width='20%' align='right'";
  $tf = "width='80%' align='left'";
  $width = NULL;
  if ($msg == NULL)  	$msg = "Please enter your Username and Password";
	else if ($logon == FALSE) $msg = "<font color='blue'>$msg, please try again</font>";  
  echo "<form action='logon.php' enctype='multipart/form-data' method='post'>\n
		<table width='$width' cellspacing='10' class='text'>\n
		<tr><td $td>&nbsp;</td><td $td>&nbsp;</td></tr>
		<tr><td $td>&nbsp;</td><td style= '$tf'><b><font size = '+2'><font color = 'red'><center>Admin Log-in</center></b></td></tr>
		<tr><td $td>&nbsp;</td><td $td>&nbsp;</td></tr>
		<tr><td $td>Username</td>	<td $tf><input type='text' name='userid' size='60' maxlength='80' value=''></td></tr>\n
		<tr><td $td>Password</td>	<td $tf><input type='password' name='password' size='12' maxlength='12' value=''></td></tr>\n
		<tr><td $td>&nbsp;</td>		<td $tf>&nbsp;</td></tr>\n
		<tr><td $td>&nbsp;</td>		<td $tf><input type='submit' name='logon' value='LOGON' style='background-color:white;color:red; font-weight:bold'></td></tr>\n
		<tr><td $td>&nbsp;</td>		<td $tf>&nbsp;</td></tr>\n
		<tr><td $td>Message</td>	<td $tf><b>$msg<b></td></tr>\n
		</table>\n
		</form>\n";
 }
?>
</div>
</article> <!-- end main -->

</body>
</html>
<div id = "aside" class = "center">
<aside>
<h3>Website Navigation</h3>
<p>
<a href="index.htm">Website Home Page</a>
</p>
<p>
<p>
<a href="possession.htm">Corsi and Fenwick</a>
</p>
<p>
<a href="other_stats.htm">Overview of Other Statistics</a>
</p>

<h3>Statistics Websites</h3>
<p>
<a href="http://war-on-ice.com/">War On Ice</a>
</p>

<p>
<a href="http://stats.hockeyanalysis.com/">Hockey Analysis</a>
</p>

<p>
<a href="http://www.behindthenet.ca/">Behind the Net</a>
</p>

<p>
<a href="http://www.puckalytics.com/">Puck Analytics</a>
</p>

<p>
<a href="http://www.hockeydb.com/">Hockey Database</a>
</p>

<p>
<a href="http://www.hockey-reference.com/">Hockey Reference</a>
</p>

<p>
<a href="http://www.nhl.com/stats/?navid=nav-sts-main#">NHL Website's Stats</a>
</p>

<p>
<a href="http://somekindofninja.com/nhl/">SomeKindofNinja Chart Generator</a>
</p>

<p>
<a href="http://www.sportingcharts.com/nhl/">NHL SportingCharts</a>
</p>
</aside> <!-- end sidebar -->
</div>
   </p>
<footer>
<p>New York Rangers Advanced Statistics &bull; Written by: Ryan Kane &bull; Created December 2015

</section> <!-- end container -->
