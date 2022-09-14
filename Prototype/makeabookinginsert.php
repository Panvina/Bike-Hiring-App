<?php
session_start();
date_default_timezone_set('Australia/Melbourne');
include_once("php-scripts/backend-connection.php");
//Linking utility functions associated with inventory
include("php-scripts/utils.php");
	//Establishing database connection using mysqli()
$conn = new mysqli("localhost", "root", "", "bike_hiring_system");
?>

<?php
    // Fetching all column data from the bike type table
    $bikeType = $conn->query("SELECT * FROM bike_type_table");
    //make array of bike types
    $bikeTypeArray = array();
    //loop through bike types
    while ($row = $bikeType->fetch_assoc()) {
        $bikeTypeId = $row["bike_type_id"];
        //$bikeTypeArrayItem = "bike" . $bikeTypeId;
        //array_push($bikeTypeArray, $bikeTypeArrayItem);
        //add each bike type to array + "bike" ie bike40 for example
        array_push($bikeTypeArray, $bikeTypeId);
    }
    //make array of bike value variables from form
   	$bikeVariableArray = array();
    foreach($bikeTypeArray as $bikeTypeArray){
    	//loop through all avaialble bike types
		    if (isset($_REQUEST[$bikeTypeArray])){
		    	//check if form has submitted bike type
			array_push($bikeVariableArray, $bikeTypeArray);
			//add bike value to bike value variable array
		    }
	}
	/*
	foreach($bikeVariableArray as $bikeVariableArray){
		//loop through array of submitted bike variables
		$quantityGet = $bikeVariableArray . "quantity";
		//get quanitity per bike from form
		$bikeQuantity =  $_REQUEST[$quantityGet];
		//dislay results
		echo "<p><strong>Bike:" . $bikeVariableArray . "</strong></p>";
		echo "<p><strong>Quantity:" . $bikeQuantity . "</strong></p>";
	}	
	*/



    // Fetching all column data from the accessory type table
    $accessoryType = $conn->query("SELECT * FROM accessory_type_table");
    //make array of accessory types
    $accessoryTypeArray = array();
    while ($row = $accessoryType->fetch_assoc()) {
    	$accessoryTypeId = $row["accessory_type_id"];
    	//$accessoryTypeArrayItem = "accessory" . $accessoryTypeId;
    	//add all available accessories to type array
        array_push($accessoryTypeArray, $accessoryTypeId);
    }
    //make array of accessorry  values from form
    $accessoryVariableArray = array();
    foreach($accessoryTypeArray as $accessoryTypeArray){
    	//loop through available accessory types
		    if (isset($_REQUEST[$accessoryTypeArray])){
		    	//if accessory submitted in form add to accessory value array
			array_push($accessoryVariableArray, $accessoryTypeArray);
		    }
	}
	foreach($accessoryVariableArray as $accessoryVariableArray){
		//loop through submitted accessories and display
		//echo "<p><strong>Accessory:" . $accessoryVariableArray . "</strong></p>";
	}	


	$ret = false;


			//get form data
	/*
			$userName =  $_REQUEST['userName'];
			$startDateValue = $_REQUEST['startDateValue'];
			$endDateValue = $_REQUEST['endDateValue'];
			$startTimeValue =  $_REQUEST['pickupTimeValue'];
			$endTimeValue =  $_REQUEST['dropoffTimeValue'];
			$durationValue = 0; //will make function to calculate
			$pickupLocationValue = $_REQUEST['pickupLocationValue'];
			$dropoffLocationValue = $_REQUEST['dropoffLocationValue'];
			$totalPriceInput = 0.0;// will make function to calculate
			*/

			// initialise local variables (purely for readability/semantic reasons)
			$user_name = $_REQUEST['userName'];
			$start_date = $_REQUEST['startDateValue'];
			$start_time = $_REQUEST['pickupTimeValue'];
			$end_date = $_REQUEST['endDateValue'];
			$end_time = $_REQUEST['dropoffTimeValue'];
			$booking_duration = 0;
			$pick_up_location = $_REQUEST['pickupLocationValue'];
			$drop_off_location = $_REQUEST['dropoffLocationValue'];
			$booking_fee = 0.0;

			// Get data for transactions into single strings
			// Booking data
			$bookingData = "'$user_name', '$start_date', '$start_time', '$end_date', '$end_time', $booking_duration, $pick_up_location, $drop_off_location, $booking_fee";

			// construct booking table query
			$bookingTableQuery = "INSERT INTO booking_table (user_name, start_date, start_time, end_date, expected_end_time, duration_of_booking, pick_up_location, drop_off_location, booking_fee) VALUES ($bookingData); ";

			// query to save last insert id (from booking) as booking id
			$getLastBookingIdQuery = "SET @booking_id=LAST_INSERT_ID(); ";

			// construct booking bike table query
			// need to repeat for count(explode(",", $bike_id))
			$bookingBikeTableQuery = "INSERT INTO booking_bike_table (booking_id, bike_id) VALUES";
			for($i = 0; $i < count($bikeVariableArray); $i++)
			{
				$bikeId = $bikeVariableArray[$i];
				$bookingBikeTableQuery .= "(@booking_id, $bikeId)";
				if ($i < count($bikeVariableArray) - 1)
				{
					$bookingBikeTableQuery .= ',';
				}
				else
				{
					$bookingBikeTableQuery .= ';';
				}
			}

			// construct booking bike table query
			// need to repeat for count(explode(",", $bike_id)) accessoryVariableArray
			$bookingAccessoryTableQuery = "";
			if (count($accessoryVariableArray) > 0)
			{
				$bookingAccessoryTableQuery = "INSERT INTO booking_accessory_table (booking_id, accessory_id) VALUES ";
				for($i = 0; $i < count($accessoryVariableArray); $i++)
				{
					$accessoryId = $accessoryVariableArray[$i];
					$bookingAccessoryTableQuery .= "(@booking_id, $accessoryId) ";

					if ($i < count($accessoryVariableArray) - 1)
					{
						$bookingAccessoryTableQuery .= ',';
					}
					else
					{
						$bookingAccessoryTableQuery .= ';';
					}
				}
			}

			// NOTE: Multiple queries used, as according to https://stackoverflow.com/a/1307645
			// PHP's MySQL module does not allow multiple queries. Testing supports this.

			// Begin transaction
			if ($conn->query("START TRANSACTION;") == TRUE)
			{
				$ret = TRUE;
			}

			// execute booking_table query
			echo "<br>$bookingTableQuery<br>";
			if ($conn->query($bookingTableQuery) == TRUE)
			{
				$ret = TRUE;
			}

			// retrieve primary key of previously executed query
			if ($conn->query($getLastBookingIdQuery) == TRUE)
			{
				$ret = TRUE;
			}

			// execute booking_bike_table query
			if ($conn->query($bookingBikeTableQuery) == TRUE)
			{
				$ret = TRUE;
			}

			// execute booking_accessory_table query
			echo $bookingAccessoryTableQuery;
			if ($bookingAccessoryTableQuery != "")
			{
				if ($conn->query($bookingAccessoryTableQuery) == TRUE)
				{
					$ret = TRUE;
				}
			}

			// commit changes to database
			if ($conn->query("COMMIT;") == TRUE)
			{
				$ret = TRUE;
			}

			return $ret;

	?>





<!DOCTYPE html>
<html>
<head>
	<title>Make Your Booking</title>
	<meta charset="utf-8" />
    <link rel="stylesheet" href="./style/style.css">
    <link rel="stylesheet" href="https://unpkg.com/flickity@2/dist/flickity.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="style/makeyourbooking.css">
</head>
<body>
	<?php include 'header.php' ?>    
	<div id = "main">
        <div class="banner">
            <div id="bannertext">
                <h1>MAKE A BOOKING</h1>
            </div>
            <div class ="NavContainer">
                    <ul class="Breadcrumbs">
                        <li class="BreadcrumbsItem">
                            <a href="Index.php" class="BreadcrumbsURL">Home</a>
                        </li>
                        <li class="BreadcrumbsItem">
                            <a href="javascript:window.location.href=window.location.href" class="BreadcrumbsURL BreadcrumbsURLactive">Hire</a>
                        </li>
                        <li class="BreadcrumbsItem">
                            <a href="javascript:window.location.href=window.location.href" class="BreadcrumbsURL BreadcrumbsURLactive">Mountain</a>
                        </li>
                        <li class="BreadcrumbsItem">
                            <a href="javascript:window.location.href=window.location.href" class="BreadcrumbsURL BreadcrumbsURLactive">MERIDA Big Seven</a>
                        </li>
                        <li class="BreadcrumbsItem">
                            <a href="javascript:window.location.href=window.location.href" class="BreadcrumbsURL BreadcrumbsURLactive">Book</a>
                        </li>
                    </ul>
            </div>
        </div>
        
        <div class="maincontainer">
        <div id="dualContainer">
            <div id="dualColumn1">
                <h1><strong>Booking Confirmation:</strong></h1>
				<p><strong>Customer ID: <?php echo $userName;?></strong></p>
		        <p><strong>Price: <?php echo("$" . $totalPriceInput . " AUD");?></strong></p>
		        <p><strong>Pick Up Location: <?php echo $pickupLocationValue;?></strong></p>
		        <p><strong>Drop Off Location: <?php echo $dropoffLocationValue;?></strong></p>
		       	<p><strong>Duration: <?php echo $durationValue;?></strong></p>
		       	<p><strong>Start Date: <?php echo $startDateValue;?></strong></p>
		       	<p><strong>End Date: <?php echo $endDateValue;?></strong></p>
		        <p><strong>Pickup Time: <?php echo $startTimeValue;?></strong></p>
		        <p><strong>Dropoff Time: <?php echo $endTimeValue;?></strong></p>
		        <?php
			    // Fetching all column data from the bike type table
			    $bikeType = $conn->query("SELECT * FROM bike_type_table");
			    //make array of bike types
			    $bikeTypeArray = array();
			    //loop through bike types
			    while ($row = $bikeType->fetch_assoc()) {
			        $bikeTypeId = $row["bike_type_id"];
			        $bikeTypeArrayItem = "bike" . $bikeTypeId;
			        //add each bike type to array + "bike" ie bike40 for example
			        array_push($bikeTypeArray, $bikeTypeArrayItem);
			    }
			    //make array of bike value variables from form
			   	$bikeVariableArray = array();
			    foreach($bikeTypeArray as $bikeTypeArray){
			    	//loop through all avaialble bike types
					    if (isset($_REQUEST[$bikeTypeArray])){
					    	//check if form has submitted bike type
						array_push($bikeVariableArray, $bikeTypeArray);
						//add bike value to bike value variable array
					    }
				}
				foreach($bikeVariableArray as $bikeVariableArray){
					//loop through array of submitted bike variables
					$quantityGet = $bikeVariableArray . "quantity";
					//get quanitity per bike from form
					$bikeQuantity =  $_REQUEST[$quantityGet];
					//dislay results
					echo "<p><strong>Bike:" . $bikeVariableArray . "</strong></p>";
					echo "<p><strong>Quantity:" . $bikeQuantity . "</strong></p>";
				}	
			    ?>
			    <?php
			    // Fetching all column data from the accessory type table
			    $accessoryType = $conn->query("SELECT * FROM accessory_type_table");
			    //make array of accessory types
			    $accessoryTypeArray = array();
			    while ($row = $accessoryType->fetch_assoc()) {
			    	$accessoryTypeId = $row["accessory_type_id"];
			    	$accessoryTypeArrayItem = "accessory" . $accessoryTypeId;
			    	//add all available accessories to type array
			        array_push($accessoryTypeArray, $accessoryTypeArrayItem);
			    }
			    //make array of accessorry  values from form
			    $accessoryVariableArray = array();
			    foreach($accessoryTypeArray as $accessoryTypeArray){
			    	//loop through available accessory types
					    if (isset($_REQUEST[$accessoryTypeArray])){
					    	//if accessory submitted in form add to accessory value array
						array_push($accessoryVariableArray, $accessoryTypeArray);
					    }
				}
				foreach($accessoryVariableArray as $accessoryVariableArray){
					//loop through submitted accessories and display
		    		echo "<p><strong>Accessory:" . $accessoryVariableArray . "</strong></p>";
				}	
			    ?>
		       	<h2><strong>Enjoy the ride!</strong></h2>
		       	<br>

            </div>
            <div id="dualColumn2">
		        
		    </div>
		</div>
	</div>
	<script src="https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js"></script>
        <script type = "text/javascript">
        $('.main-carousel').flickity({
        cellAlign: 'left',
        wrapAround:true,
        freeScroll:true
        });</script>
	<?php include 'footer.php' ?>
<script type="text/javascript">
</script>	



</body>
</html>