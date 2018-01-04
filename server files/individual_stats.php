<!DOCTYPE html>

<html>
  <head>

<title>New York Rangers Skater Statistics</title>

<!--
	Final Project
	Ryan Kane
	December 1st, 2015
-->

<link href="stylesQuery.css" type="text/css" rel="stylesheet"/>
</head>

<style type="text/css">

/* header */
header{
	text-align: center;
	background-color: black;
	border: 3px dashed red;
}

header h1{
	font-family: "Arial Black",Gadget,sans-serif;
	color: red;
	font-size: 2.3em;
}

#main h3{
	color: red;
	bottom-border: 2px dashed blue;
	text-decoration: underline;
	font-size: 1.3em;
}

ol{
	text-indent: 0em;
	font-style:italic;
	line-height: 2em;
	font-size: 1em;
}

aside {    
	width: 200px;	
	padding: 10px;
	color: black;
    background-color: red;
    float: right;
}

aside h3{
	color: black;
}

#main h2 {
    border-bottom: 2px dashed red;
    padding-bottom: 10px;
	text-align: center;
	font-weight: bold;
	font-variant: small-caps;
	color: blue;
}	

table, td{
	border: .25px solid blue;
}

</style>

</head>
  
<body>

<section id="container">
<header>
<p><img src="images/hockey_rink.jpg" alt="hockey rink" title = "Hockey Rink Diagram" width="700" height="254" /></p>
<h1>New York Rangers Skater Statistics</h1>
</header>
<div id = "nav" class="nav">   
   <p>
	<a href = "#Introduction">Introduction to Possession</a>
	| <a href = "#Stats">Corsi and Fenwick</a>
	| <a href = "#Variations">Variations</a>
   </p>
</div>
   
<article id="main">
<div id = "header">
<?PHP
// Phonebook Listing - phonebook.php
// Written by:  Charles Kaplan, October 2014
// Modified by: Ryan Kane, December 2015

include('session.php');
// Variables
  $positions = array("Forwards", "Defensemen", "Right Wingers", "Left Wingers", "Centers"); //This will be stored in a dropdown menus so that queries can be customized by position.
  $statistics = array("Traditional Only", "Advanced Only", "Posession Only"); //This will be stored in a dropdown menu so that queries can be cuztomized by statistic type.
  $sortby = array("Name", "Jersey #", "Games Played", "Position");
  $pgm = "individual_stats.php";

// Get Input
  if (isset($_POST['position']))	$position = ucwords($_POST['position']);	else $position = "All";
  if (isset($_POST['statistic']))	$statistic = ucwords($_POST['statistic']);	else $statistic = "All";
  if (isset($_POST['sort']))	 $sort = $_POST['sort'];	else $sort = NULL;

  
 

// Connect to MySQL and the Database
   include('mysql_connect.php'); 
  
// Set-up the Query 

//This switch will determine the WHERE statement in the query.

  switch($position) {
	  case "Forwards": $where =" 'RW' or Position= 'LW' OR Position='C'";	break; //Put all forward positions in the WHERE statement
	  case "Defensemen": $where = "'D'";	break; //Put all defensemen in the WHERE statement
	  case "Right Wingers": $where = "'RW'";	break; //Put all right wingers in the WHERE statement
	  case "Left Wingers": $where = "'LW'";	break; //Put all left wingers in the WHERE statement
	  case "Centers": $where = "'C'"; break; //Put all centers in the WHERE statement
	  default: $where="'RW' OR Position= 'LW' OR Position= 'C' OR Position= 'D'";	break; //Select all skaters
  }
  //This switch will determine the SELECT statement in the query.
   switch($statistic) {
	  case "Traditional Only": $select = 'Jersey, First, Last, Position,Gm, G, A, P';	break; //Show traditional statistics only
	  case "Advanced Only": $select = "`Jersey`, `First`, `Last`, `Position`, `Gm`, `P60`, `CF%`, `CF%Rel`, `CF60`, `CA60`, `PDO`, `ZSO%Rel`, `TOI/Gm`";	break; //Show all advanced statistics
	  case "Posession Only": $select = "`Jersey`, `First`, `Last`, `Position`, `Gm`, `CF%`, `CF%Rel`, `CF60`, `CA60`";	break; //Show posession numbers only
	  default: $select='*';	break; //Select all statistics types
  }
  
  //This switch will set the ORDER BY statement in the query.
  switch($sort) {
	case "Name":	$orderby = "Last, First";				break;
	case "Jersey #":	$orderby = "Jersey";					break;
	case "Position":	$orderby = "Position"; 			break;
	case "Games Played":	$orderby = "Gm"; break;	
/*	case "Goals":	$orderby = "G"; break;
	case "Assists":	$orderby = "A"; break;
	case "Points":	$orderby = "P"; break;
	case "PointsPer60":	$orderby = "P60"; break;
	case "CorsiForPer":	$orderby = "`CF%`"; break;
	case "RelCorsiForPer":	$orderby = "`CF%Rel`"; break;
	case "CorsiForPer60":	$orderby = "CF60"; break;
	case "CorsiAgainstPer60":	$orderby = "CA60"; break;
	case "PDO":		$orderby = "PDO"; break;
	case "ZoneStartPer":	$orderby = "`ZSO%Rel`"; break;
	case "TimeOnIcePerGame":	$orderby = "`TOI/Gm`"; break;*/
	default:	$orderby = "Last, First";	break;
	}

  $query = "SELECT $select
			FROM players
			WHERE  Position=$where
			ORDER BY $orderby;";		

// Execute the Query
  $result = $mysqli -> query($query);
  
  
  //Create a positions dropdown menu and retrieve the user's selection
  echo "<center> 
		<form action='$pgm?s=$sort' name='sort' method='post'>
		<FONT COLOR = 'RED'>Select Position</FONT> <select name='position'>
		<option>All Skaters</option>";
  foreach($positions as $pos) {
    if ($pos == $position)
	  $se = "SELECTED";
	  else $se = NULL;
	echo "<option $se>$pos</option>";
	}
  echo "</select>
		</center>
		<br>";	
  
  //Create stats type dropdown menu and retrieve the user's selection
   echo "<center> 
		Select Stat Type <select name='statistic'>
		<option>All Statistics</option>";
  foreach($statistics as $stat) {
    if ($stat == $statistic)
	  $se = "SELECTED";
	  else $se = NULL;
	echo "<option $se>$stat</option>";
	}
  echo "</select>
		</center>
		<br>";	
		
  //Create a "Sort By" menu. Since the user customizes each query, we can only offer the columns that appear in every result.
  echo "<center> 
		<FONT COLOR = 'blue'>Sort By</FONT> <select name='sort'>";
   foreach($sortby as $sortb) {
    if ($sortb == $sort)
	  $se = "SELECTED";
	  else $se = NULL;
	echo "<option $se>$sortb</option>";
	}
  echo "</select>
	<br><br>
		&nbsp;&nbsp;<input type='submit'>
		</center>
		</form>
		<br>";
  
  //Format tables and query elements if 'All Statistics' are selected
  if($statistic=='All Statistics'){ //Only output this table and variables if all statistic types are selected.
  echo "<table align='center' width='700'>
		<tr>
		<td width='6.66%'><b><u>Name</u></b></td>
		<td width='6.66%'><b><u>#</u></b></td>
		<td width='6.66%'><b><u>POS</u></b></td>		
		<td width='6.66%'><b><u>GP</u></b></td>		
		<td width='6.66%'><b><u>G</u></b></td>	
		<td width='6.66%'><b><u>A</u></b></td>
		<td width='6.66%'><b><u>P</u></b></td>
		<td width='6.66%'><b><u>P/60</u></b></td>
		<td width='6.66%'><b><u>CF%</u></b></td>
		<td width='6.66%'><b><u>Rel. CF%</u></b></td>
		<td width='6.66%'><b><u>CF/60</u></b></td>
		<td width='6.66%'><b><u>CA/60</u></b></td>
		<td width='6.66%'><b><u>PDO</u></b></td>
		<td width='6.66%'><b><u>Rel. ZS%</u></b></td>
		<td width='6.66%'><b><u>TOI/GM</u></b></td>
		</tr>\n";
  if ($result->num_rows < 1) 
    echo "<tr><td><font color='red'>None Found</font></td></tr>";
  while(list($Jersey, $First, $Last, $Position, $Gm, $G, $A, $P, $P60, $CFPer, $RelCFPer, $CF60, $CA60, $PDO, $RelZSPer,$TOI) = $result->fetch_row()) {
    echo "<tr>
		  <td>$First $Last</td>
		  <td>$Jersey</td>
		  <td>$Position</td>
		  <td>$Gm</td>
		  <td>$G</td>
		  <td>$A</td>
		  <td>$P</td>
		  <td>$P60</td>
		  <td>$CFPer</td>
		  <td>$RelCFPer</td>
		  <td>$CF60</td>
		  <td>$CA60</td>
		  <td>$PDO</td>
		  <td>$RelZSPer</td>
		  <td>$TOI</td>";
	}
  echo "</table>\n"; 
  } 
  
  //Format the table and query elements if 'Tradtional Statistics' is selected
  elseif($statistic=='Traditional Only'){ //Only output this table and variables if traditional statistic types are selected.
  echo "<table align='center' width='700'>
		<tr>
		<td width='20%'><b><u>Name</u></b></td>
		<td width='13%'><b><u>#</u></b></td>
		<td width='13%'><b><u>POS</u></b></td>		
		<td width='13%'><b><u>GP</u></b></td>		
		<td width='13%'><b><u>G</u></b></td>	
		<td width='13%'><b><u>A</u></b></td>
		<td width='13%'><b><u>P</u></b></td>
		</tr>\n";
  if ($result->num_rows < 1) 
    echo "<tr><td><font color='red'>None Found</font></td></tr>";
  while(list($Jersey, $First, $Last, $Position, $Gm, $G, $A, $P) = $result->fetch_row()) {
    echo "<tr>
		  <td>$First $Last</td>
		  <td>$Jersey</td>
		  <td>$Position</td>
		  <td>$Gm</td>
		  <td>$G</td>
		  <td>$A</td>
		  <td>$P</td>"; 
	
	}
  echo "</table>\n"; 
  } 
  
  //Format tables and query elements if 'Posession Statistics' are selected
  elseif($statistic=='Advanced Only'){ //Only output this table and variables if advanced statistic types are selected.
  echo "<table align='center' width='700'>
		<tr>
		<td width='19.7%'><b><u>Name</u></b></td>
		<td width='7.3%'><b><u>#</u></b></td>
		<td width='7.3%'><b><u>POS</u></b></td>		
		<td width='7.3%'><b><u>GP</u></b></td>		
		<td width='7.3%'><b><u>P/60</u></b></td>
		<td width='7.3%'><b><u>CF%</u></b></td>
		<td width='7.3%'><b><u>Rel. CF%</u></b></td>
		<td width='7.3%'><b><u>CF/60</u></b></td>
		<td width='7.3%'><b><u>CA/60</u></b></td>
		<td width='7.3%'><b><u>PDO</u></b></td>
		<td width='7.3%'><b><u>Rel. ZS%</u></b></td>
		<td width='7.3%'><b><u>TOI/GM</u></b></td>
		</tr>\n";
  if ($result->num_rows < 1) 
    echo "<tr><td><font color='red'>None Found</font></td></tr>";
  while(list($Jersey, $First, $Last, $Position, $Gm, $P60, $CFPer, $RelCFPer, $CF60, $CA60, $PDO, $RelZSPer,$TOI) = $result->fetch_row()) {
    echo "<tr>
		  <td>$First $Last</td>
		  <td>$Jersey</td>
		  <td>$Position</td>
		  <td>$Gm</td>
		  <td>$P60</td>
		  <td>$CFPer</td>
		  <td>$RelCFPer</td>
		  <td>$CF60</td>
		  <td>$CA60</td>
		  <td>$PDO</td>
		  <td>$RelZSPer</td>
		  <td>$TOI</td>";
	}
  echo "</table>\n"; 
  } 
elseif($statistic == 'Posession Only'){ //Only output this table and variables if posession statistic types are selected.
  echo "<table align='center' width='700'>
		<tr>
		<td width='19.5%'><b><u>Name</u></b></td>
		<td width='11.5%'><b><u>#</u></b></td>
		<td width='11.5%'><b><u>POS</u></b></td>		
		<td width='11.5%'><b><u>GP</u></b></td>		
		<td width='11.5%'><b><u>CF%</u></b></td>
		<td width='11.5%'><b><u>Rel. CF%</u></b></td>
		<td width='11.5%'><b><u>CF/60</u></b></td>
		<td width='11.5%'><b><u>CA/60</u></b></td>
		</tr>\n";
  if ($result->num_rows < 1) 
    echo "<tr><td><font color='red'>None Found</font></td></tr>";
  while(list($Jersey, $First, $Last, $Position, $Gm, $CFPer, $RelCFPer, $CF60, $CA60) = $result->fetch_row()) {
    echo "<tr>
		  <td>$First $Last</td>
		  <td>$Jersey</td>
		  <td>$Position</td>
		  <td>$Gm</td>
		  <td>$CFPer</td>
		  <td>$RelCFPer</td>
		  <td>$CF60</td>
		  <td>$CA60</td>";
	}
  echo "</table>\n"; 
  
  //Convert the user's choice from the position drop down menu to create dynamic video content. 
 /* switch($position){
	  case "Forwards": $player ="Rick Nash";	break; //Display a video of Rick Nash if the user selects forwards as the position.
	  case "Defensemen": $player = "Ryan McDonagh";	break; //Display a video of Ryan McDonagh if the user selects defensemen as the position.
	  case "Right Wingers": $player = "Mats Zuccarello";	break; //Display a video of Mats Zuccarello if the user selects right wingers as the position.
	  case "Left Wingers": $player = "Chris Kreider";	break; //Display a video of Chris Kreider if the user selects left wingers as the position.
	  case "Centers": $player = "Derek Stepan"; break; //Display a video of Derek Stepan if the user selects centers as the position.
	  default: $player="New York Rangers 2015";	break; //Display last season's highlights if the user selects all.*/
  }


include('rangerVid.php'); //Include this script to dynamically show the user's a video based on their query choice.
?>


</div>
</article> <!-- end main -->
<div id = "aside" class = "center">
<aside>
<h3>Website Navigation</h3>
<p>
<a href="index.htm">Website Home Page</a>
</p>
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
<footer>
<p>New York Rangers Advanced Statistics &bull; Written by: Ryan Kane &bull; Created December 2015
</section> <!-- end container -->
</body>
</html>


