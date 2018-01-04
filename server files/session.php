<?php
// bcs350_session - Start/Resume Session and Restore Session Variables
// Written by: Charles Kaplan, November 2015

	session_start();
	
	if (isset($_SESSION['role'])) {
		$role =	$_SESSION['role'];
		$name = $_SESSION['name'];
		$logon = TRUE;
		}
	else {
		$role = NULL;
		$name = NULL;
		$logon = FALSE;
		}
			
?>