<?php
	include_once "backend-connection.php";

	class AccessoryInventoryDBConnection extends DBConnection
	{
		public function __construct($tablename="accessory_inventory_table", $servername="localhost", $username="root", $password="", $dbname="bike_hiring_system")
		{
			$this->servername = $servername;
			$this->username = $username;
			$this->password = $password;
			$this->dbname = $dbname;
			$this->tablename = $tablename;

			$this->getConn();
		}

		// get conflicting bikes, then remove them. Return non-conflicting bikes.
	   public function getAvailableAccessories($startDate, $startTime, $endDate, $endTime, $bookingId)
	   {
		   $filterQuery = getConflictingBookingsQuery($startDate, $startTime, $endDate, $endTime);

		   $bookingsTableName = "booking_table";
		   $bookingAccessoryTable = "booking_accessory_table";	// Table linking accessories to bookings
		   $AccessoryInvTableName = $this->tablename;		// Table with all individual concrete bikes
		   $damagedTableName = "damaged_items_table";

		   $query =   "SELECT $bookingAccessoryTable.accessory_id
					   FROM $bookingsTableName
						   LEFT JOIN $bookingAccessoryTable
							   ON $bookingAccessoryTable.booking_id = $bookingsTableName.booking_id
						   LEFT JOIN $AccessoryInvTableName
							   ON $AccessoryInvTableName.accessory_id = $bookingAccessoryTable.accessory_id
					   WHERE $filterQuery";

		   // echo "$query";
		   // echo "<br>";

		   // get bike_ids for unavailable bikes
		   $overlappingAccessories = array();
		   $res = $this->conn->query($query);
		   if ($res->num_rows > 0)
		   {
			   // append all rows to return array
			   while($row = $res->fetch_assoc())
			   {
				   array_push($overlappingAccessories, $row);
			   }
		   }

		   // remove duplicates
		   $unavailableAccessories = array();
		   for($i = 0; $i < count($overlappingAccessories); $i++)
		   {
			   $accessoryId = $overlappingAccessories[$i]["accessory_id"];
			   if (!in_array($accessoryId, $unavailableAccessories))
			   {
				   array_push($unavailableAccessories, $accessoryId);
			   }
		   }

		   // get damaged items
		   $damagedAccessories = array();
		   $query = "SELECT accessory_id FROM $damagedTableName WHERE accessory_id IS NOT NULL";

		   $res = $this->conn->query($query);
		   if ($res->num_rows > 0)
		   {
			   // append all rows to return array
			   while($row = $res->fetch_assoc())
			   {
				   array_push($damagedAccessories, $row);
			   }
		   }

		   // add damaged bikes to cleaned bikes
		   for($i = 0; $i < count($damagedAccessories); $i++)
		   {
			   $accessoryId = $damagedAccessories[$i]["accessory_id"];
			   if (!in_array($bikeId, $unavailableAccessories))
			   {
				   array_push($unavailableAccessories, $accessoryId);
			   }
		   }

		   // construct query (could put this above, but leaving separate for clarity)
		   $accessoryQuery = "LOCATE(accessory_id, '";
		   for($i = 0; $i < count($unavailableAccessories); $i++)
		   {
			   $accessoryId = $unavailableAccessories[$i];
			   $accessoryQuery .= "$accessoryId,";
		   }
		   $accessoryQuery .= "') = 0";

		   // add bike ids of current booking to allow for reselection
		   if ($bookingId != null)
		   {
			   $accessoryQuery .= " OR LOCATE(accessory_id, '";
			   $query = "SELECT $AccessoryInvTableName.accessory_id FROM $bookingAccessoryTable
						 LEFT JOIN $AccessoryInvTableName
							 ON $bookingAccessoryTable.accessory_id = $AccessoryInvTableName.accessory_id
						 WHERE $bookingAccessoryTable.booking_id = $bookingId";
			   $res = $this->conn->query($query);
			   if ($res->num_rows > 0)
			   {
				   while($row = $res->fetch_assoc())
				   {
					   $accessoryQuery .= "{$row['accessory_id']},";
				   }
			   }
			   $accessoryQuery .= "') > 0";
		   }

		   // get accessories that are available by searching for all accessories not already booked for period, or damaged
		   $query = "SELECT accessory_id, name FROM $AccessoryInvTableName WHERE $accessoryQuery";
		   // echo $query;

		   $availableAccessories = array();
		   $res = $this->conn->query($query);
		   if ($res->num_rows > 0)
		   {
			   // append all rows to return array
			   while($row = $res->fetch_assoc())
			   {
				   array_push($availableAccessories, $row);
			   }
		   }

		   return $availableAccessories;
	   }
	}
?>
