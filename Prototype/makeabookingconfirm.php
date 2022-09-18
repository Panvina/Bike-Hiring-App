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

		    function calculateDuration($startDateValue, $endDateValue, $startTimeValue, $endTimeValue){
				$pickUpTimeValue = 0;
			  if ($startTimeValue == "9:00:00"){
			    $pickUpTimeValue = 1;
			  }else if ($startTimeValue == "10:00:00"){
			    $pickUpTimeValue = 2;
			  }else if ($startTimeValue == "11:00:00"){
			    $pickUpTimeValue = 3;
			  }else if ($startTimeValue == "12:00:00"){
			    $pickUpTimeValue = 4;
			  }else if ($startTimeValue == "13:00:00"){
			    $pickUpTimeValue = 5;
			  }else if ($startTimeValue == "14:00:00"){
			    $pickUpTimeValue = 6;
			  }else if ($startTimeValue == "15:00:00"){
			    $pickUpTimeValue = 7;
			  }else if ($startTimeValue == "16:00:00"){
			    $pickUpTimeValue = 8;
			  }
			  $dropOffTimeValue = 0;
			  if ($endTimeValue == "9:00:00"){
			    $dropOffTimeValue = 1;
			  }else if ($endTimeValue == "10:00:00"){
			    $dropOffTimeValue = 2;
			  }else if ($endTimeValue == "11:00:00"){
			    $dropOffTimeValue = 3;
			  }else if ($endTimeValue == "12:00:00"){
			    $dropOffTimeValue = 4;
			  }else if ($endTimeValue == "13:00:00"){
			    $dropOffTimeValue = 5;
			  }else if ($endTimeValue == "14:00:00"){
			    $dropOffTimeValue = 6;
			  }else if ($endTimeValue == "15:00:00"){
			    $dropOffTimeValue = 7;
			  }else if ($endTimeValue == "16:00:00"){
			    $dropOffTimeValue = 8;
			  }
			  $durationValueTimes = $dropOffTimeValue - $pickUpTimeValue;
			  $startDateValueDays = substr($startDateValue, -2);
			  $endDateValueDays = substr($endDateValue, -2);
			  $startDateValueDays = intval($startDateValueDays);
			  $endDateValueDays = intval($endDateValueDays);
			  $durationValueDates = $endDateValueDays - $startDateValueDays;
			  $durationDatesTotalValueHours = $durationValueDates * 24;
			  $totalDuration = $durationDatesTotalValueHours + $durationValueTimes;
			  return $totalDuration;
			}
		     ?>



<?php
		//get form data
			$userName =  'test2';
			$startDateValue = $_REQUEST['startDateValue'];
			$endDateValue = $_REQUEST['endDateValue'];
			$startTimeValue =  $_REQUEST['pickupTimeValue'];
			$endTimeValue =  $_REQUEST['dropoffTimeValue'];
			$durationValue = calculateDuration($startDateValue, $endDateValue, $startTimeValue, $endTimeValue);
			$pickupLocationValue = $_REQUEST['pickupLocationValue'];
			$dropoffLocationValue = $_REQUEST['dropoffLocationValue'];
		
		    // Fetching all column data from the bike type table
		    $bikeTypePrice = $conn->query("SELECT * FROM bike_type_table");
		    //make array of bike types
		    $bikeTypeArrayPrice = array();
		    //loop through bike types
		    while ($row = $bikeTypePrice->fetch_assoc()) {
		        $bikeTypeIdPrice = $row["bike_type_id"];
		        $bikeTypeArrayItemPrice = "bike" . $bikeTypeIdPrice;
		        //add each bike type to array + "bike" ie bike40 for example
		        array_push($bikeTypeArrayPrice, $bikeTypeArrayItemPrice);
		    }
		    //make array of bike value variables from form
		   	$bikeVariableArrayPrice = array();
		    foreach($bikeTypeArrayPrice as $bikeTypeArrayPrice){
		    	//loop through all avaialble bike types
				    if (isset($_REQUEST[$bikeTypeArrayPrice])){
				    	//check if form has submitted bike type
					array_push($bikeVariableArrayPrice, $bikeTypeArrayPrice);
					//add bike value to bike value variable array
				    }
			}

			$bikePricesArray = array();
			foreach($bikeVariableArrayPrice as $bikeVariableArrayPrice){
				//dislay results
				$bikePriceID = str_replace('bike', '', $bikeVariableArrayPrice);
				$bikePrice = $conn->query("SELECT price_ph FROM bike_inventory_table WHERE bike_type_id = $bikePriceID LIMIT 1");
			    while ($row = $bikePrice->fetch_assoc()) {
			    	$bikePriceValue = $row["price_ph"];
			    	array_push($bikePricesArray, $bikePriceValue);
			    }
			}

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
			$accessoryPricesArray = array();
			foreach($accessoryVariableArray as $accessoryVariableArray){
				//dislay results
				$accessoryPriceID = str_replace('accessory', '', $accessoryVariableArray);

				$accessoryPrice = $conn->query("SELECT price_ph FROM accessory_inventory_table WHERE accessory_type_id = $accessoryPriceID LIMIT 1");
			    while ($row = $accessoryPrice->fetch_assoc()) {
			    	$accessoryPriceValue = $row["price_ph"];
			    	array_push($accessoryPricesArray, $accessoryPriceValue);
			    }
			}

			$totalPriceInput = calculatePrice($durationValue, $bikePricesArray, $accessoryPricesArray);

			  

			function calculatePrice($durationValue, $bikePricesArray, $accessoryPricesArray){
				$firstPrice = 0;
				foreach($bikePricesArray as $bikePricesArray){
					$newPrice = $bikePricesArray * $durationValue;
					$firstPrice += $newPrice;
				}
				$secondPrice = 0;
				foreach($accessoryPricesArray as $accessoryPricesArray){
					$newPrice = $accessoryPricesArray * $durationValue;
					$secondPrice += $newPrice;
				}
				$totalPrice = $firstPrice + $secondPrice;
				return $totalPrice;
			}

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
                            <a href="javascript:window.location.href=window.location.href" class="BreadcrumbsURL BreadcrumbsURLactive">Confirm</a>
                        </li>
                    </ul>
            </div>
        </div>

        <div class="maincontainer">
        <div id="dualContainer">
            <div id="dualColumn1">
                <h1><strong>Booking Confirmation:</strong></h1>
		        <p style="font-size: 24px;"><strong>Price: <?php echo("$" . $totalPriceInput . " AUD");?></strong></p>
		        <p style="font-size: 24px;"><strong>Pick Up Location: <?php 
		        	$getPickupLocationName = $conn->query("SELECT name FROM location_table WHERE location_id = $pickupLocationValue");
				    while ($row = $getPickupLocationName->fetch_assoc()) {
				    	$pickupLocationName = $row["name"];
				    }
		        	echo $pickupLocationName;
		        ?></strong></p>
		        <p style="font-size: 24px;"><strong>Drop Off Location: <?php
		        	$getDropoffLocationName = $conn->query("SELECT name FROM location_table WHERE location_id = $dropoffLocationValue");
				    while ($row = $getDropoffLocationName->fetch_assoc()) {
				    	$dropoffLocationName = $row["name"];
				    }
		        	echo $dropoffLocationName; 
		        	?></strong></p>
		       	<p style="font-size: 24px;"><strong>Duration: <?php 
		       	echo $durationValue;
		       	echo " Hours";
		       	?></strong></p>
		       	<p style="font-size: 24px;"><strong>Start Date: <?php echo $startDateValue;?></strong></p>
		       	<p style="font-size: 24px;"><strong>End Date: <?php echo $endDateValue;?></strong></p>
		        <p style="font-size: 24px;"><strong>Pickup Time: <?php 
		        	$startTimePrint = "";
			      	if ($startTimeValue == "9:00:00"){
				  		$startTimePrint = "9 AM";
				  	}else if ($startTimeValue == "10:00:00"){
				    	$startTimePrint = "10 AM";
				  	}else if ($startTimeValue == "11:00:00"){
				    	$startTimePrint = "11 AM";
				  	}else if ($startTimeValue == "12:00:00"){
				    	$startTimePrint = "12 PM";
				  	}else if ($startTimeValue == "13:00:00"){
				    	$startTimePrint = "1 PM";
				  	}else if ($startTimeValue == "14:00:00"){
				    	$startTimePrint = "2 PM";
				  	}else if ($startTimeValue == "15:00:00"){
				    	$startTimePrint = "3 PM";
				  	}else if ($startTimeValue == "16:00:00"){
				    	$startTimePrint = "4 PM";
				  }
				  echo $startTimePrint;
		        ?></strong></p>
		        <p style="font-size: 24px;"><strong>Dropoff Time: <?php 
		        $endTimePrint = "";
		      	if ($endTimeValue == "9:00:00"){
			  		$endTimePrint = "9 AM";
			  	}else if ($endTimeValue == "10:00:00"){
			    	$endTimePrint = "10 AM";
			  	}else if ($endTimeValue == "11:00:00"){
			    	$endTimePrint = "11 AM";
			  	}else if ($endTimeValue == "12:00:00"){
			    	$endTimePrint = "12 PM";
			  	}else if ($endTimeValue == "13:00:00"){
			    	$endTimePrint = "1 PM";
			  	}else if ($endTimeValue == "14:00:00"){
			    	$endTimePrint = "2 PM";
			  	}else if ($endTimeValue == "15:00:00"){
			    	$endTimePrint = "3 PM";
			  	}else if ($endTimeValue == "16:00:00"){
			    	$endTimePrint = "4 PM";
			  }
			  echo $endTimePrint;
		        ?></strong></p>
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
				echo "<p style='font-size: 24px;'><strong>Bikes Ordered: </strong></p>";
				foreach($bikeVariableArray as $bikeVariableArray){
					$bikeNameId = str_replace('bike', '', $bikeVariableArray);
					$bikeNameQuery = $conn->query("SELECT name FROM bike_type_table where bike_type_id = $bikeNameId");
					while ($row = $bikeNameQuery->fetch_assoc()) {
			    	$bikeName = $row["name"];
			    	}
			    	echo "<p style='font-size: 24px;'><em>" . $bikeName . "</em></p>";
				}
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
				echo "<p style='font-size: 24px;'><strong>Accessories Ordered: </strong></p>";
				foreach($accessoryVariableArray as $accessoryVariableArray){
					$accessoryNameId = str_replace('accessory', '', $accessoryVariableArray);
					$accessoryNameQuery = $conn->query("SELECT name FROM accessory_type_table where accessory_type_id = $accessoryNameId");
					while ($row = $accessoryNameQuery->fetch_assoc()) {
			    	$accessoryName = $row["name"];
			    	}
			    	echo "<p style='font-size: 24px;'><em>" . $accessoryName . "</em></p>";
					//loop through submitted accessories and display
				}

				$sqlBooking = "INSERT INTO booking_table (user_name, start_date, end_date, start_time, expected_end_time, duration_of_booking, pick_up_location, drop_off_location, booking_fee)
				VALUES ('$userName', '$startDateValue', '$endDateValue', '$startTimeValue', '$endTimeValue', '$durationValue', '$pickupLocationValue', '$dropoffLocationValue', '$totalPriceInput')";

				if ($conn->query($sqlBooking) === TRUE) {
				  $last_id = $conn->insert_id;
				  //echo "New booking created successfully";

				   $bikeType2 = $conn->query("SELECT * FROM bike_type_table");
				    //make array of bike types
				    $bikeTypeArray2 = array();
				    //loop through bike types
				    while ($row = $bikeType2->fetch_assoc()) {
				        $bikeTypeId2 = $row["bike_type_id"];
				        $bikeTypeArrayItem2 = "bike" . $bikeTypeId2;
				        //add each bike type to array + "bike" ie bike40 for example
				        array_push($bikeTypeArray2, $bikeTypeArrayItem2);
				    }
				    //make array of bike value variables from form
				   	$bikeVariableArray2 = array();
				    foreach($bikeTypeArray2 as $bikeTypeArray2){
				    	//loop through all avaialble bike types
						    if (isset($_REQUEST[$bikeTypeArray2])){
						    	//check if form has submitted bike type
							array_push($bikeVariableArray2, $bikeTypeArray2);
							//add bike value to bike value variable array
						    }
					}



				  foreach($bikeVariableArray2 as $bikeVariableArray2){
					$bikeVariableID = str_replace('bike', '', $bikeVariableArray2);
				  	$sqlGetBikes = "SELECT bike_id FROM bike_inventory_table WHERE bike_type_id = $bikeVariableID";
					$result = $conn->query($sqlGetBikes);
				  	if ($result->num_rows > 0) {
						while ($row = $result->fetch_assoc()) {
							$bikeInventoryId = $row["bike_id"];
						}
					}
				  	$sqlBookingBike = "INSERT INTO booking_bike_table (booking_id, bike_id)
					VALUES ('$last_id', '$bikeInventoryId')";
					if ($conn->query($sqlBookingBike) === TRUE){
					//	echo "New bike booking created successfully";
					}else{
						echo "Error: " . $sqlBookingBike . "<br>" . $conn->error;
					}
				  }



				  // Fetching all column data from the accessory type table
			    $accessoryType2 = $conn->query("SELECT * FROM accessory_type_table");
			    //make array of accessory types
			    $accessoryTypeArray2 = array();
			    while ($row = $accessoryType2->fetch_assoc()) {
			    	$accessoryTypeId2 = $row["accessory_type_id"];
			    	$accessoryTypeArrayItem2 = "accessory" . $accessoryTypeId2;
			    	//add all available accessories to type array
			        array_push($accessoryTypeArray2, $accessoryTypeArrayItem2);
			    }
			    //make array of accessorry  values from form
			    $accessoryVariableArray2 = array();
			    foreach($accessoryTypeArray2 as $accessoryTypeArray2){
			    	//loop through available accessory types
					    if (isset($_REQUEST[$accessoryTypeArray2])){
					    	//if accessory submitted in form add to accessory value array
						array_push($accessoryVariableArray2, $accessoryTypeArray2);
					    }
				}


				  foreach($accessoryVariableArray2 as $accessoryVariableArray2){
				  	$accessoryVariableID = str_replace('accessory', '', $accessoryVariableArray2);
				  	$sqlGetAccessory = "SELECT accessory_id FROM accessory_inventory_table WHERE accessory_type_id = $accessoryVariableID";
				  	$result = $conn->query($sqlGetAccessory);
				  	if ($result->num_rows > 0) {
						while ($row = $result->fetch_assoc()) {
							$accessoryInventoryId = $row["accessory_id"];
						}
					}
				  	$sqlBookingAccessory = "INSERT INTO booking_accessory_table (booking_id, accessory_id)
					VALUES ('$last_id', '$accessoryInventoryId')";
					if ($conn->query($sqlBookingAccessory) === TRUE){
					//	echo "New accessory booking created successfully";
					}else{
						echo "Error: " . $sqlBookingAccessory . "<br>" . $conn->error;
					}
				  }



				} else {
				  echo "Error: " . $sqlBooking . "<br>" . $conn->error;
				}


				
				//header("Location: makeabooking.php");



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

<?php 


?>


</body>
</html>
