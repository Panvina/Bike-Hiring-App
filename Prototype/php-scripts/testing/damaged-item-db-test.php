<?php
	include_once "../damaged-item-db.php";

	// setup
	$conn = new DamagedItemsDBConnection();
	$sql = new mysqli("localhost", "root", "", "bike_hiring_system");

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

	$row = $sql->query("SELECT booking_id FROM booking_table");
	$row = $row->fetch_assoc();
	$bookingId = $row["booking_id"];

	try {
		// test : getDamagedBikes
		{
			$conn->insert("damaged_id, booking_id, bike_id, damage_fee", "99999, $bookingId, 99999, 0");

			$expectedResult = array();
			$rows = $sql->query("SELECT * FROM damaged_items_table WHERE bike_id IS NOT NULL");
			while($row = $rows->fetch_assoc()) {
				array_push($expectedResult, $row);
			}

			$actualResult = $conn->getDamagedBikes();

			if ($actualResult == $expectedResult) {
				echo "getDamagedBikes success.<br>";
			}
			else {
				echo "getDamagedBikes failed. Expected ";
				print_r($expectedResult);
				echo ". Got ";
				print_r($actualResult);
				echo "<br>";
			}
		}

		// test : getDamagedAccessories
		{
			$conn->insert("damaged_id, booking_id, accessory_id, damage_fee", "99998, $bookingId, 99999, 0");

			$expectedResult = array();
			$rows = $sql->query("SELECT * FROM damaged_items_table WHERE accessory_id IS NOT NULL");
			while($row = $rows->fetch_assoc()) {
				array_push($expectedResult, $row);
			}

			$actualResult = $conn->getDamagedAccessories();

			if ($actualResult == $expectedResult) {
				echo "getDamagedAccessories success.<br>";
			}
			else {
				echo "getDamagedAccessories failed. Expected ";
				print_r($expectedResult);
				echo ". Got ";
				print_r($actualResult);
				echo "<br>";
			}
		}
	}
	catch (Exception $e) {
		echo "Exception caught. $e->getMessage()";
	}
	finally {
		cleanup();
	}

	// clean up
	function cleanup() {
		try {
			$sql = new mysqli("localhost", "root", "", "bike_hiring_system");

			// delete bike
			$sql->query("DELETE FROM bike_inventory_table WHERE bike_id=99999");
			$sql->query("DELETE FROM bike_type_table WHERE bike_type_id=99999");

			// delete accessory
			$sql->query("DELETE FROM accessory_inventory_table WHERE accessory_id=99999");
			$sql->query("DELETE FROM accessory_type_table WHERE accessory_type_id=99999");

			$sql->query("DELETE FROM damaged_items_table WHERE damaged_id=99998");
			$sql->query("DELETE FROM damaged_items_table WHERE damaged_id=99999");
		}
		catch (Exception $e) {
			$msg = $e->getMessage();
			echo "Exception caught: $msg";
			echo "<br>Make sure test data is deleted.";
		}
		echo "<br>Cleanup completed.";
		exit();
	}
?>
