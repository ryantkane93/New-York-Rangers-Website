<?PHP
//Created by: Ryan Kane, December 2015
//Convert the user's choice from the position drop down menu to create dynamic video content. 
  switch($position){
	  case "Forwards": $player ="Rick Nash";	break; //Display a video of Rick Nash if the user selects forwards as the position.
	  case "Defensemen": $player = "Ryan McDonagh";	break; //Display a video of Ryan McDonagh if the user selects defensemen as the position.
	  case "Right Wingers": $player = "Mats Zuccarello";	break; //Display a video of Mats Zuccarello if the user selects right wingers as the position.
	  case "Left Wingers": $player = "Chris Kreider";	break; //Display a video of Chris Kreider if the user selects left wingers as the position.
	  case "Centers": $player = "Derek Stepan"; break; //Display a video of Derek Stepan if the user selects centers as the position.
	  default: $player="New York Rangers 2015";	break; //Display last season's highlights if the user selects all.
  }

?>

<script src="videoBackUp.js"></script>
<div id="ytThumbs"></div>
<div class="youtube-container">
<script type="text/javascript">
	var player = <?php echo json_encode("$player "); ?>; //Assign the PHP variables to javascript variables so that they can be used in the search results.
	var str = player + "highlights";
	ytEmbed.init({'block':'ytThumbs','key':'AIzaSyBSiTxvMngXt_U1TeiH09nwAQlvvMKaxJ0 ','q':str.valueOf(),'type':'search','results':2,
	'meta':true,'player':'embed','layout':'full'});
</script>
</div>