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
	//get form data
	$userName =  $_REQUEST['userName'];
	$startDateValue = $_REQUEST['startDateValue'];
	$endDateValue = $_REQUEST['endDateValue'];
	$startTimeValue =  $_REQUEST['pickupTimeValue'];
	$endTimeValue =  $_REQUEST['dropoffTimeValue'];
	$durationValue = 0; //will make function to calculate
	$pickupLocationValue = $_REQUEST['pickupLocationValue'];
	$dropoffLocationValue = $_REQUEST['dropoffLocationValue'];
	$totalPriceInput = 0.0;// will make function to calculate
		// Performing insert query execution
	/*
		$sql = "INSERT INTO booking_table (user_name, start_date, end_date, start_time, expected_end_time, duration_of_booking, pick_up_location, drop_off_location, booking_fee) VALUES ('$userName', '$startDateValue','$endDateValue','$startTimeValue','$endTimeValue', '$durationValue', 'pickupLocationValue', 'dropoffLocationValue', 'totalPriceInput')";
	if(mysqli_query($conn, $sql)){
	} else{
	// Echo error if failed query fails
	    echo "ERROR: $sql. " 
	        . mysqli_error($conn);
	}
	// Close connection
	mysqli_close($conn);
	*/
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