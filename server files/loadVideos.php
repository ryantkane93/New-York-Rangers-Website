<?PHP

/*$mysqli = new mysqli('localhost', 'root','', 'address book'); //Create a new mysqli object that will connect to the database.

//Query the database to retrieve the car database.
$getCarInfo = 
		"SELECT 'make', 'model', 'year' 
		FROM `cars` 
		WHERE userId = $currentUser";
		
$result = $mysqli->query($getCarInfo); //Execute the car query.

list($make, $model, $year)= $result->fetch_row()) //Store the make model and year into PHP variables using fetch_row()
*/
$make = "Dodge";
$model = "Charger";
$year = "2015";
?>

<script src="http://www.yvoschaap.com/ytpage/ytembed.js">;
</script>
<div id="ytThumbs"></div>

<script>
	var make = <?php echo json_encode("$make "); ?>; //Assign the PHP variables to javascript variables so that they can be used in the search results.
	var model = <?php echo json_encode("$model "); ?>;
	var year = <?php echo json_encode("$year "); ?>;
	var str = make + model + year;
	ytEmbed.init({'block':'ytThumbs','key':'AIzaSyBSiTxvMngXt_U1TeiH09nwAQlvvMKaxJ0 ','q':str.valueOf(),'type':'search','results':3,
	'meta':true,'player':'embed','layout':'full'});
</script>;
