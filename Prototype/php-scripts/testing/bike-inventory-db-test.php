<?php
	include_once "backend-connection.php";
	include_once "utils.php";

	class BikeInventoryDBConnection extends DBConnection
	{
		public function __construct($tablename="bike_inventory_table", $servername="localhost", $username="root", $password="", $dbname="bike_hiring_system")
		{
			$this->servername = $servername;
			$this->username = $username;
			$this->password = $password;
			$this->dbname = $dbname;
			$this->tablename = $tablename;

			$this->getConn();
		}

		public function getNumCheckedBikes()
		{
			$bikeCount = 0;

			$query = "SELECT bike_id FROM $this->tablename WHERE safety_inspect=1";
			// echo $query;
			$res = $this->conn->query($query);
			if ($res->num_rows > 0)
			{
				$bikeCount = $res->num_rows;
			}

			return $bikeCount;
		}

		public function getNumUncheckedBikes()
		{
			$bikeCount = 0;

			$query = "SELECT bike_id FROM $this->tablename WHERE safety_inspect=0";
			$res = $this->conn->query($query);
			if ($res->num_rows > 0)
			{
				$bikeCount = $res->num_rows;
			}

			return $bikeCount;
		}


		 // get conflicting bikes, then remove them. Return non-conflicting bikes.
 		public function getAvailableBikes($startDate, $startTime, $endDate, $endTime, $bookingId)
 		{
 			$overlappedBikes = array();

 			$filterQuery = getConflictingBookingsQuery($startDate, $startTime, $endDate, $endTime);
			// echo "$filterQuery<br>";
			// exit();

 			$bookingsTableName = "booking_table";
 			$bookingBikeTableName = "booking_bike_table";	// Table linking bikes to bookings
 			$bikeInvTableName = $this->tablename;		// Table with all individual concrete bikes
 			$damagedTableName = "damaged_items_table";

 			$query =   "SELECT $bikeInvTableName.bike_id
 						FROM $bookingsTableName
 							LEFT JOIN $bookingBikeTableName
 								ON $bookingBikeTableName.booking_id = $bookingsTableName.booking_id
 							LEFT JOIN $bikeInvTableName
 						    	ON $bikeInvTableName.bike_id = $bookingBikeTableName.bike_id
 						WHERE $filterQuery";

 			// echo "$query<br><br>";

 			// get bike_ids for unavailable bikes
 			$res = $this->conn->query($query);
 			if ($res->num_rows > 0)
 			{
 				// append all rows to return array
 				while($row = $res->fetch_assoc())
 				{
 					array_push($overlappedBikes, $row);
 				}
 			}
			// print_r($overlappedBikes);

 			// remove duplicates
 			$unavailableBikes = array();
 			for($i = 0; $i < count($overlappedBikes); $i++)
 			{
 				$bikeId = $overlappedBikes[$i]["bike_id"];
 				if (!in_array($bikeId, $unavailableBikes))
 				{
 					array_push($unavailableBikes, $bikeId);
 				}
 			}

 			// get damaged items
 			$damagedBikes = array();
 			$query = "SELECT bike_id FROM $damagedTableName WHERE bike_id IS NOT NULL";

 			$res = $this->conn->query($query);
 			if ($res->num_rows > 0)
 			{
 				// append all rows to return array
 				while($row = $res->fetch_assoc())
 				{
 					array_push($damagedBikes, $row);
 				}
 			}

 			// add damaged bikes to cleaned bikes
 			for($i = 0; $i < count($damagedBikes); $i++)
 			{
 				$bikeId = $damagedBikes[$i]["bike_id"];
 				if (!in_array($bikeId, $unavailableBikes))
 				{
 					array_push($unavailableBikes, $bikeId);
 				}
 			}

 			// construct query (could put this above, but leaving separate for clarity)
 			$bikeQuery = "LOCATE(bike_id, '";
 			for($i = 0; $i < count($unavailableBikes); $i++)
 			{
 				$bikeId = $unavailableBikes[$i];
 				$bikeQuery .= "$bikeId,";
 			}
 			$bikeQuery .= "') = 0";

			// add bike ids of current booking to allow for reselection
			if ($bookingId != null)
			{
				$bikeQuery .= " OR LOCATE(bike_id, '";
				$query = "SELECT $bikeInvTableName.bike_id FROM $bookingBikeTableName
						  LEFT JOIN $bikeInvTableName
						      ON $bookingBikeTableName.bike_id = $bikeInvTableName.bike_id
						  WHERE $bookingBikeTableName.booking_id = $bookingId";
				$res = $this->conn->query($query);
				if ($res->num_rows > 0)
				{
					while($row = $res->fetch_assoc())
					{
						$bikeQuery .= "{$row['bike_id']},";
					}
				}
				$bikeQuery .= "') > 0";
			}

 			// get bikes that are available by searching for all bikes not already booked for period, or damaged
 			$query = "SELECT bike_id, name FROM $bikeInvTableName WHERE $bikeQuery";
 			// echo $query;

			$availableBikes = array();
 			$res = $this->conn->query($query);
 			if ($res->num_rows > 0)
 			{
 				// append all rows to return array
 				while($row = $res->fetch_assoc())
 				{
 					array_push($availableBikes, $row);
 				}
 			}

 			return $availableBikes;
 		}
	}
?>
