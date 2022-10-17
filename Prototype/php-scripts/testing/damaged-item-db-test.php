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

	// test
	{
		// test : getDamagedBikes
		{
			$row = $sql->query("SELECT booking_id FROM booking_table");
			$row = $row->fetch_assoc();
			$bookingId = $row["booking_id"];

			$conn->insert("damaged_id, booking_id, bike_id, damage_fee", "99999, $bookingId, 99999, 0");

			$expectedResult = array();
			$rows = $sql->query("SELECT * FROM damaged_items_table WHERE bike_id IS NOT NULL");
			while($row = $rows->fetch_assoc()) {
				
			}

			$actualResult = $conn->getDamagedBikes();
		}

		// test : getDamagedAccessories
		{
			$actualResult = $conn->getDamagedAccessories();
		}
	}

	class DamagedItemsDBConnection extends DBConnection
	{
		/**
		 * Get all currently damaged bikes from inventory
		 */
		public function getDamagedBikes()
		{
			$ret = $this->get("*", "bike_id IS NOT NULL");

			return $ret;
		}

		/**
		 * Get all currently damaged accessories from inventory
		 */
		public function getDamagedAccessories()
		{
			$ret = $this->get("*", "accessory_id IS NOT NULL");

			return $ret;
		}
	}
?>
