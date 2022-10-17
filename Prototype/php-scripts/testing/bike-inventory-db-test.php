<?php
	include_once "../bike-inventory-db.php";
	include_once "../backend-connection.php";
	include_once "../bookings-db.php";

	// setup
	$conn = new BikeInventoryDBConnection();
	$sql = new mysqli("localhost", "root", "", "bike_hiring_system");

	$checkRows = $sql->query("SELECT bike_id FROM bike_inventory_table WHERE safety_inspect=1");
	$checkedBikesOriginal = $checkRows->num_rows;

	$uncheckRows = $sql->query("SELECT bike_id FROM bike_inventory_table WHERE safety_inspect=0");
	$uncheckedBikesOriginal = $uncheckRows->num_rows;

	// testing
	try {
		// test : getNumCheckedBikes
		{
			$expectedResult = $checkedBikesOriginal;
			$actualResult = $conn->getNumCheckedBikes();

			if ($expectedResult == $actualResult) {
				echo "getNumCheckedBikes success.<br>";
			}
			else {
				echo "getNumCheckedBikes failed. Expected $expectedResult. Got $actualResult.<br>";
			}
		}

		// test : getNumUncheckedBikes
		{
			$expectedResult = $uncheckedBikesOriginal;
			$actualResult = $conn->getNumUncheckedBikes();

			if ($expectedResult == $actualResult) {
				echo "getNumUncheckedBikes success.<br>";
			}
			else {
				echo "getNumUncheckedBikes failed. Expected $expectedResult. Got $actualResult.<br>";
			}
		}

		// test : getAvailableBikes
		{
			$date = date("Y-m-d");
			$start = "09:00";
			$end = "16:00";

			// add customer
			$query = "INSERT INTO customer_table (user_name,name,phone_number,email,street_address,suburb,post_code,licence_number,state) VALUES ('testcustomer','testname',0,'testemail','testaddress','testsuburb','testpostcode',0,'teststate')";
			$sql->query($query);

			// add location
			$query = "INSERT INTO location_table (location_id, name, address, suburb, post_code, drop_off_location, pick_up_location) VALUES (9999, '1', '1', '1', '1', '1', '1')";
			$sql->query($query);

			// add accessory
			$accessoryConn = new DBConnection("accessory_inventory_table");
			$accessoryTypeConn = new DBConnection("accessory_type_table");

			$accessoryTypeConn->insert("accessory_type_id,name,description", "99999,'accessorytypetest','accessorytypedesc'");
			$accessoryConn->insert("accessory_id,name,accessory_type_id,price_ph,safety_inspect", "99999,'accessorytest',99999,10000000000,1");

			// add bike
			$bikeConn = new DBConnection("bike_inventory_table");
			$bikeTypeConn = new DBConnection("bike_type_table");

			$bikeTypeConn->insert("bike_type_id,name,picture_id,description", "99999, 'biketypetest', 1, 'biketypedesctest'");
			$bikeConn->insert("bike_id,bike_type_id,name,helmet_id,price_ph,safety_inspect,description", "99999,99999,'biketest',99999,3579480,1,'bikedesc'");

			$bikeData = array("99999");
			$bookingData = array("testcustomer", $date, $start, $date, $end, 0, 9999, 9999, 1126491);

			// get current available bikes
			$bikes = $conn->getAvailableBikes($date, $start, $date, $end);

			// add booking
			$bookingDbConnection = new BookingsDBConnection();
			$bookingDbConnection->addBooking($bookingData, $bikeData);

			$newBikes = $conn->getAvailableBikes($date, $start, $date, $end);

			$countOldBikes = count($bikes);
			$countNewBikes = count($newBikes);
			if ($countOldBikes - $countNewBikes == 1) {
				echo "addAvailableBikes success.<br>";
			}
			else {
				echo "addAvailableBikes failed. Expected $countNewBikes bikes. Got $countOldBikes.<br>";
			}
		}
	}
	catch (Exception $e) {
		echo "Exception caught: $e->getMessage()";
	}
	finally {
		cleanup();
	}

	function cleanup() {
		$sql = new mysqli("localhost", "root", "", "bike_hiring_system");

        // delete bike
        $sql->query("DELETE FROM bike_inventory_table WHERE bike_id=99999");
		$sql->query("DELETE FROM bike_type_table WHERE bike_type_id=99999");

        // delete accessory
		$sql->query("DELETE FROM accessory_inventory_table WHERE accessory_id=99999");
		$sql->query("DELETE FROM accessory_type_table WHERE accessory_type_id=99999");

		// delete customer
		$sql->query("DELETE FROM customer_table WHERE user_name='testcustomer'");

		// delete location
		$sql->query("DELETE FROM location_table WHERE location_id=9999");

		// delete empty booking_bike_table references
		$sql->query("DELETE FROM booking_bike_table WHERE bike_id is null");

		$sql->query("DELETE FROM booking_table WHERE user_name is null");
        echo "<br>Finished cleanup.";
		exit();
	}
?>
