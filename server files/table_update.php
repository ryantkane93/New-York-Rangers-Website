<!DOCTYPE html>
<html>
  <head>

<title>Metropolitan Division Statistics Update</title>

<!--
	Final Project
	Ryan Kane
	December 1st, 2015
-->

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

</head>
  
<body>

<section id="container">
<div id = "header" class = "center">
<header>
<p><img src="images/hockey_rink.jpg" alt="hockey rink" title = "Hockey Rink Diagram" width="700" height="254" /></p>
<h1>Metropolitan Division Statistics Table Update</h1>
</header>
</div>

<div id = "nav" class ="nav">   
   <p>
	<?PHP include('session.php'); if ($logon) echo "<tr><td align='center'><font size='+2'>You are logged in as: $name</font></td></tr>"?>	 
   </p>
</div>
   
<article id="main">
<div id = "header">
<?php
// Table Update Program
// Written by: Charles Kaplan, October 2014
// Modified by: Ryan Kane, December 2015

//include('session.php');

  if (!$logon) { 
	header('Location: logon.php');
	exit;
	}
	else {

// Variables
  $task = "first";
  $pgm = "table_update.php";
  $width = "400";
  $msg = NULL;
  $msg_color = "white";
  $categories	= array("Columbus Blue Jackets", "New York Islanders", "New York Rangers", "Carolina Hurricanes", "New Jersey Devils", "Philadelphia Flyers", "Pittsburgh Penguins", "Washington Capitals");

// Connect to MySQL and the Database
  include('mysql_connect.php');
  
// Get Task Input    
  if (isset($_POST['task']))   $task = strtolower($_POST['task']);
  if (isset($_GET['r']))       $r = $_GET['r'];			else $r = NULL;
  
// Get Field Input  
  if (isset($_POST['rowid']))		$rowid 		= trim($_POST['rowid']);		else $rowid 	= NULL;
  if (isset($_POST['team']))	$team	= trim($_POST['team']);	else $team = NULL;
  if (isset($_POST['games']))	$games	= trim($_POST['games']);		else $games 	= NULL;
  if (isset($_POST['pdo']))		$pdo		= trim($_POST['pdo']);		else $pdo		= NULL;
  if (isset($_POST['gf']))		$gf		= trim($_POST['gf']);		else $gf		= NULL;
  if (isset($_POST['ga']))		$ga	= trim($_POST['ga']);		else $ga	= NULL;
  if (isset($_POST['goaldifferential']))		$goaldifferential		= trim($_POST['goaldifferential']);			else $goaldifferential		= NULL;
  if (isset($_POST['corsiforper']))		$corsiforper		= trim($_POST['corsiforper']);		else $corsiforper		= NULL;
  if (isset($_POST['fenwickforper']))			$fenwickforper		= trim($_POST['fenwickforper']);			else $fenwickforper		= NULL;  
  if (isset($_POST['corsieventsper60']))			$corsieventsper60		= trim($_POST['corsieventsper60']);			else $corsieventsper60		= NULL;  
  if (isset($_POST['shotper']))			$shotper		= trim($_POST['shotper']);			else $shotper		= NULL;
  if (isset($_POST['saveper']))			$saveper		= trim($_POST['saveper']);			else $saveper		= NULL;  
  if (isset($_POST['zonestartper']))			$zonestartper		= trim($_POST['zonestartper']);			else $zonestartper		= NULL;
  if (isset($_POST['last']))		$last		= $_POST['last']; 				else $last 		= NULL;
	
  if ($r != NULL) {
	$rowid = $r;
	$task = "show";
	}

// Verify Input
  if(($task != "first") AND ($task != "clear"))
	include('verify_input.php');

// Process Task
  if ($msg != NULL)
	$msg_color = "red";
	else
  switch($task) {
  
  case "first":  
    $msg = "Enter Information"; 
	break;

  case "clear":
    $rowid = $team = $games = $pdo = $gf = $ga = $goaldifferential = $corsiforper = $fenwickforper = $corsieventsper60 = $shotper = $saveper = $zonestartper = $last = NULL;
	$msg = "Screen cleared";
	break;

  case "previous record":
  case "next record":
  case "show":
    if ($task == "previous record") $rowid = $rowid - 1;
	if ($task == "next record") 	$rowid = $rowid + 1;
	if($rowid < 1) {$msg = "To SHOW a record, enter a rowid"; break;}
	$query = "SELECT team, games, pdo, gf, ga, goaldifferential, corsiforper, fenwickforper, corsieventsper60, shotper, saveper,zonestartper
			  FROM division
			  WHERE rowid='$rowid'";
	$result = $mysqli->query($query);
	if (($result->num_rows) < 1) {
	  $msg = "Team not found at rowid #$rowid. Remember that there are only 8 teams in the division!" . $mysqli->error;
	  $msg_color = "red";
	  $team = $games = $pdo = $gf = $ga = $goaldifferential = $corsiforper = $fenwickforper =$corsieventsper60 = $shotper = $saveper = $zonestartper= $last = NULL;
	  }
	  else {	
		list($team, $games, $pdo, $gf, $ga, $goaldifferential, $corsiforper, $fenwickforper, $corsieventsper60, $shotper, $saveper, $zonestartper) = $result->fetch_row(); 
		$team 	= ucwords($team);
		$msg        = "$team found";
		$last       = $rowid;
		}
    break;
  
  case "change":
    if ($rowid != $last) {
	  $msg = "Show row before updating, ROWID [$rowid], LAST [$last]";
	  $msg_color = "red";
	  break; 
	  }
    $query = "UPDATE division SET
			    pdo			= '$pdo',
			  gf			= '$gf',
			  games		= '$games',
			team		= '$team',
			  ga		= '$ga',
			  goaldifferential			= '$goaldifferential',
			  corsiforper			= '$corsiforper',
			  fenwickforper			= '$fenwickforper',
			  corsieventsper60 = '$corsieventsper60',
			  shotper = '$shotper',
			  saveper = '$saveper',
			  zonestartper = '$zonestartper'
			  WHERE rowid='$rowid'";
	$result = $mysqli->query($query);			  
	if ($mysqli->error != NULL) {
	  $msg = "ROWID $rowid not updated, " . $mysqli->error;
	  $msg_color = "red";
	  }
	  else {			  
		$msg = "ROWID $rowid updated";
		}
	break;
 
  case "delete":
    if ($rowid != $last) {
	  $msg = "Show ROWID before deleting";
	  $msg_color = "red";  
	  break; 
	  }
	$query = "DELETE FROM division WHERE rowid='$rowid'";
	$result = $mysqli->query($query);
	if ($mysqli->error != NULL) {
	  $msg = "ROWID $rowid not deleted, " . $mysqli->error;
	  $msg_color = "red";
	  }
	  else {
	    $last = NULL;
		$msg = "ROWID $rowid deleted";
		}
  break;
  
  case "add":
    $query = "INSERT INTO division SET
			  rowid = '$rowid',
			  team		= '$team',
			  games		= '$games',
			  pdo			= '$pdo',
			  gf			= '$gf',
			  ga		= '$ga',
			  goaldifferential			= '$goaldifferential',
			  corsiforper			= '$corsiforper',
			  fenwickforper			= '$fenwickforper',
			  corsieventsper60 = '$corsieventsper60',
			  shotper = '$shotper',
			  saveper = '$saveper',
			  zonestartper = '$zonestartper'";
	$result = $mysqli->query($query);			  
	if ($mysqli->error != NULL) {
	  $msg = "ROWID $rowid not added, " . $mysqli->error;
	  $msg_color = "red";
	  }
	  else {		
		$last = $rowid;
		$msg = "ROWID $rowid added";
		}
	break;
    
  default:  break; 
  }
// Output Page  
  echo "<html>
		<head>
		<script>
		  function ConfirmDelete() {
			var x = confirm('Are you sure you want to delete?');
			if (x) return true;
			  else return false;
		  }
		</script>		
		</head>
		<body>
		<br>
		<form action='$pgm' method='post'>
		<table align='center' width='$width'>
		<tr><td align='center'><font size='+2'><u>Metropolitan Division Table Update</u></font></td></tr>
		</table>
		<table align='center' width='$width' style='margin-left:120px'>		
		<tr><td>&nbsp;</td></tr>
		<tr><td style ='color:red'>ROWID</td><td><input type='text' name='rowid' size='5' maxlength='5' value='$rowid'>
			<input type='hidden' name='last' value='$last'></td></tr>
		<tr><td>Team</td><td><select name='team'>";
		  foreach($categories as $cat) { //Use this foreach loop to traverse the categories array and print each team into the dropdown menu.
	if ($cat == $team)
	  $se = "SELECTED";
	  else $se = NULL;
	echo "<option $se>$cat</option>";
	}
	echo"</select></td></tr>";
		echo"<tr><td style ='color: blue'>Games Played</td><td><input type='text' name='games'  size='2' maxlength='3' value='$games'></td></tr>
		<tr><td style ='color: red'>PDO</td><td><input type='text' name='pdo'size='6' maxlength='6' value='$pdo'></td></tr>
		<tr><td>Goals For</td><td><input type='text' name='gf' size='5' maxlength='5' value='$gf'></td></tr>
		<tr><td style ='color: blue'>Goals Against</td><td><input type='text' name='ga'size='5' maxlength='5' value='$ga'></td></tr>
		<tr><td style ='color: red'>Goal Differential</td><td><input type='text' name='goaldifferential' size='4' maxlength='4' value='$goaldifferential'></td></tr>
		<tr><td>Corsi For Percentage</td><td><input type='text' name='corsiforper'size='4'  maxlength='4'  value='$corsiforper'></td></tr>
		<tr><td style ='color: blue'>Fenwick For Percentage</td> <td><input type='text' name='fenwickforper'size='4' maxlength='4' value='$fenwickforper'></td></tr>		
		<tr><td style ='color: red'>Corsi Events Per 60</td><td><input type='text' name='corsieventsper60' size='5' maxlength='5' value='$corsieventsper60'></td></tr>;
		<tr><td>Shot Percentage</td><td><input type='text' name='shotper' size='4' maxlength='4' value='$shotper'></td></tr>
		<tr><td style ='color: blue'>Save Percentage</td><td><input type='text' name='saveper' size='4' maxlength='4' value='$saveper'></td></tr>
		<tr><td style ='color: red'>Zone Start Percentage</td><td><input type='text' name='zonestartper' size='4' maxlength='4' value='$zonestartper'></td></tr>";
  echo "</td></tr>
		</table><br>";
		
  echo "<table align='center'>
		<tr>
		<td><input type='submit' name='task'  value='Show'   style='background-color:red; color: white; font-weight:bold'></td>
		<td><input type='submit' name='task'  value='Add'    style='background-color:white; color: red; font-weight:bold'></td>
		<td><input type='submit' name='task'  value='Change' style='background-color:blue; color: white; font-weight:bold'></td>
		<td><input type='submit' name='task'  value='Delete' style='background-color:red; color: white; font-weight:bold' Onclick='return ConfirmDelete();'></td>
		<td><input type='submit' name='task'  value='Clear'  style='background-color:white; color: blue; font-weight:bold'></td>
		<td>&nbsp;</td>
		<td><input type='submit' name='task'  value='Previous Record' style='background-color:blue; color:white; font-weight:bold'></td>
		<td><input type='submit' name='task'  value='Next Record' style='background-color:red; color:white; font-weight:bold'></td>
		</tr>
		</table><br>";

  echo "<table align='center' width='$width'><tr><td><b>Message</b>: <font color='$msg_color'>$msg</font></td></tr></table>";		
 
  echo "</body>
		</html>";
	} #End else
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
<p>
<a href="logon.php">Log-in Page</a>
</p>
<p>
<a href="logoff.php">Log off Page</a>
</p>
<p>
<a href="table_update.php">Admin Division Table Update</a>
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

</body>
</html>

   
