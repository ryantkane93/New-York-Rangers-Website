<?php
// phone_book_verify_input.php - Verify Form Input for Phone Book Update Program
// called by table_update2.php
// Written by: Charles Kaplan, October 2014
// Modified by: Ryan Kane, December 2015

// POST Fields to Verify
// Rowid 		Integer > 0
// Games        Cannot be NULL and cannot contain non-digit characters.
// Team         Check to make sure that the value is in the category array.
// PDO          Cannot be NULL and can only contain digits and a decimal point.
// Goals for    Cannot be NULL and can only contain positive digits.
// Goals against Cannot be NULL and can only contain positive digits. 
// Goal +/-      Cannot be NULL and can only contain positive or negative numbers.
// Corsi for %  Cannot be NULL and can only contain digits and a decimal point.
// Fenwick for %  Cannot be NULL and can only contain digits and a decimal point.
// Corsi Events per 60  Cannot be NULL and can only contain digits and a decimal point.
// Shot Percentage Cannot be NULL and can only contain digits and a decimal point.
// Save Percentage Cannot be NULL and can only contain digits and a decimal point.
// Zone Start Percentage Cannot be NULL and can only contain digits and a decimal point.

// When to verify (which tasks)
// ROWID		All tasks, except add
// ALL Others	Only add or change

// ROWID
  if ($task != "add")
    if ($rowid < 1)	$msg .= "Rowid invalid. There can only be eight teams in the division.<br>";
  
  

  if (($task == "add") OR ($task == "change")) {
// GAMES
    if ($games == NULL)	$msg .= "Number of games is missing<br>";
	if (preg_match("/\D/", $games)) $msg .= "The number of games can only contain digits.<br>";

// TEAM
    $category = ucwords($team);
    if (!in_array($team, $categories))	$msg .= "Invalid Team<br>";  
	
// PDO
    if ($pdo == NULL)	$msg .= "PDO is missing<br>";
	if (preg_match("/[^0-9.]/", $pdo)) $msg .= "PDO can only contain digits and a decimal point.<br>";

// GOALS FOR
    if ($gf == NULL)	$msg .= "Goals for is missing<br>";
	if (preg_match("/\D/", $gf)) $msg .= "Goals for can only contain positive digits.<br>";

// GOALS AGAINST
    if ($ga == NULL)	$msg .= "Goals against is missing<br>";
	if (preg_match("/\D/", $ga)) $msg .= "Goals against can only contain positive digits.<br>";

// GOAL DIFFERENTIAL
    if ($goaldifferential == NULL)	$msg .= "Goal differential is missing<br>";
	if (preg_match("/[^0-9-]/", $goaldifferential)) $msg .= "Goal differential can only contain positive and negative numbers.<br>";

//CORSI FOR %	
	if ($corsiforper == NULL)	$msg .= "Corsi for % is missing<br>";
	if (preg_match("/[^0-9.]/", $corsiforper)) $msg .= "Corsi for % can only contain digits and a decimal point.<br>";
	
//FENWICK FOR %	
	if ($fenwickforper == NULL)	$msg .= "Fenwick for % is missing<br>";
	if (preg_match("/[^0-9.]/", $fenwickforper)) $msg .= "Fenwick for % can only contain digits and a decimal point.<br>";

//CORSI EVENTS PER 60
	if ($corsieventsper60 == NULL)	$msg .= "Corsi events per 60 is missing<br>";
	if (preg_match("/[^0-9.]/", $corsieventsper60)) $msg .= "Corsi events per 60 can only contain digits and a decimal point.<br>";

//SHOT PERCENTAGE
	if ($shotper == NULL)	$msg .= "Shot percentage is missing<br>";
	if (preg_match("/[^0-9.]/", $shotper)) $msg .= "Shot percentage can only contain digits and a decimal point.<br>";

//SAVE PERCENTAGE
	if ($saveper == NULL)	$msg .= "Save percentage is missing<br>";
	if (preg_match("/[^0-9.]/", $saveper)) $msg .= "Save percentage can only contain digits and a decimal point.<br>";

//ZONE START PERCENTAGE
	if ($zonestartper == NULL)	$msg .= "Zone start percentage is missing<br>";
	if (preg_match("/[^0-9.]/", $zonestartper)) $msg .= "Zone start percentage can only contain digits and a decimal point.<br>";
 
	}	
?>