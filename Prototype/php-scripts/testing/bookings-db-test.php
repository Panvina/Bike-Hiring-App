<!--
Project Name: Inverloch Bike Hire
Project Description: A website for hiring bikes. Front-end accompanied
	   by an admin dashboard.
File Description: interface for interacting with bookings table and related operations.
Contributor(s): Dabin Lee @ icelasersparr@gmail.com
-->
<?php
	include_once "../bookings-db.php";

	// setup
	$conn = new BookingsDBConnection();
	$sql = new mysqli("localhost", "root", "", "bike_hiring_system");

	$bookingId = -1;

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
	$bookingData = array("testcustomer", "2022-10-16", "09:00", "2022-10-16", "10:00", 0, 9999, 9999, 1126491);

	try {
		// test : addBooking
		{
			// add booking
			$conn->addBooking($bookingData, $bikeData);

			// check booking exists
			$bookingRow = $sql->query("SELECT booking_id FROM booking_table WHERE user_name='testcustomer'");
			$countRows = $bookingRow->num_rows;
			if ($countRows == 1) {
				$bookingId = $bookingRow->fetch_assoc()["booking_id"];

				// check bike is associated properly
				$bookingBikeRow = $sql->query("SELECT bike_id FROM booking_bike_table WHERE booking_id=$bookingId");
				$bikeRowCount = $bookingBikeRow->num_rows;

				if ($bikeRowCount == 1) {
					$bikeId = $bookingBikeRow->fetch_assoc()["bike_id"];

					if ($bikeId == 99999) {
						echo "addBooking success.<br>";
					}
					else {
						echo "addBooking failed. bike_id=$bikeId. Expected 99999<br>";
						cleanup();
					}
				}
				else {
					echo "addBooking failed. bike.num_rows = $bikeRowCount<br>";
					cleanup();
				}
			}
			else {
				echo "addBooking failed. booking.num_rows = $countRows<br>";
				cleanup();
			}
		}

		// test : getBookingRows
		{
			$rows = $conn->getBookingRows("booking_table.booking_id=$bookingId");
			$countRows = count($rows);

			// check correct booking retrieved
			if ($countRows == 1) {
				$row = $rows[0];
				$actualUser = $row["name"];
				$actualDur = $row["duration_of_booking"];
				if ($actualUser == "testname" && $actualDur == 0) {
					echo "getBookingRows success<br>";
				}
				else {
					echo "getBookingRows failed. Expected (testname, 0). GOT ($actualUser, $actualDur)<br>";
					cleanup();
				}
			}
			else {
				echo "getBookingRows failed. num_rows = $countRows<br>";
				cleanup();
			}
		}

		// test : retrieveBookingForChangeBooking
		{
			$row = $conn->retrieveBookingForChangeBooking($bookingId);
			$actualUser = $row["name"];
			if ($actualUser == "testname") {
				echo "retrieveBookingForChangeBooking success<br>";
			}
			else {
				echo "retrieveBookingForChangeBooking failed. Expected (testname). GOT ($actualUser)<br>";
				cleanup();
			}
		}

		// test : modifyBooking
		{
			$bookingData = array("2022-10-16", "09:00", "2022-10-16", "11:00", 1, 9999, 9999, 1126491);

			$ret = $conn->modifyBooking($bookingId, $bookingData, $bikeData);
			if ($ret) {
				$row = $sql->query("SELECT expected_end_time, duration_of_booking FROM booking_table WHERE booking_id=$bookingId");
				$row = $row->fetch_assoc();

				$actualDur = $row["duration_of_booking"];
				$actualEndTime = $row["expected_end_time"];

				// check duration changed to 1, and endTime changed to 11:00:00
				if ($actualDur == 1 && $actualEndTime == "11:00:00") {
					echo "modifyBooking success.<br>";
				}
				else {
					echo "modifyBooking failed. Expected (1, 11:00). Got ($actualDur, $actualEndTime)<br>";
					cleanup();
				}
			}
			else {
				echo "modifyBooking failed. Function returned false.<br>";
				cleanup();
			}
		}

		// test : deleteBooking
		{
			$res = $conn->deleteBooking($bookingId);
			if ($res) {
				$row = $sql->query("SELECT * FROM booking_table WHERE booking_id=$bookingId");
				if ($row->num_rows == 0) {
					echo "deleteBooking success<br>";
				}
				else {
					echo "deleteBooking failed. num_rows > 0.<br>";
					cleanup();
				}
			}
			else {
				echo "deleteBooking failed. Function returned false.<br>";
				cleanup();
			}
		}
	}
	catch (Exception $e) {
		$msg = $e->getMessage();
		echo "<br>$msg";
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

		echo "<br>Cleanup completed.";
		// exit();
	}
?>
