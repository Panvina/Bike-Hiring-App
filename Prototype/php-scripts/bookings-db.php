<!--
Project Name: Inverloch Bike Hire
Project Description: A website for hiring bikes. Front-end accompanied
	   by an admin dashboard.
File Description: interface for interacting with bookings table.
Contributor(s): Dabin Lee @ icelasersparr@gmail.com
-->
<?php
	include_once "backend-connection.php";

	class BookingsDBConnection extends DBConnection
	{
		public function __construct($tablename="booking_table", $servername="localhost", $username="root", $password="", $dbname="bike_hiring_system")
		{
			$this->servername = $servername;
			$this->username = $username;
			$this->password = $password;
			$this->dbname = $dbname;
			$this->tablename = $tablename;

			$this->getConn();
		}

		/**
		 * Get column names for display purposes.
		 */
		public function getBookingDisplayColumns()
		{
			$cols = "Booking ID,Bike Name,Customer Name,Start Date,Start Time,End Date,End Time,Duration<br>(Hours),Pick Up,Drop Off,Price($)";

			return $cols;
		}

		/**
		 *	Retrieve all rows from bookings table, with associated data.
		 *	condition is simply appended to the end of the
		 *
		 */
		public function getBookingRows($condition=0)
		{
			$ret = array();

			$cols = "
				booking_table.booking_id, bike_inventory_table.name as `Bike Name`,
				customer_table.name, booking_table.start_date, booking_table.start_time,
				booking_table.end_date, booking_table.expected_end_time,
				booking_table.duration_of_booking, lt1.name AS `pick_up_location`,
				lt2.name AS `drop_off_location`, booking_table.booking_fee";

			$bookingsTableName = $this->tablename;
			$bookingBikeTableName = "booking_bike_table";	// Table linking bikes to bookings
			$locationTableName = "location_table";			// Table with drop-off and pick-up locations
			$bikeInvTableName = "bike_inventory_table";		// Table with all individual concrete bikes
			$custTableName = "customer_table";				// Table with customer details

			/*
			 * Select rows: BookingID, CustomerID, BikeID, Start Date, Start Time,
			 * 		End Date, End Time, Duration, Pick Up Location, Drop Off Location.
			 *		and price
		 	 *	From booking_table Table
		 	 *	Join locations, bike inventory, and customers with original selection
			 */
			$query =   "SELECT $cols
						FROM $bookingsTableName
							LEFT JOIN $bookingBikeTableName
								ON $bookingBikeTableName.booking_id = $bookingsTableName.booking_id
							LEFT JOIN $bikeInvTableName
						    	ON $bikeInvTableName.bike_id = $bookingBikeTableName.bike_id
						    LEFT JOIN $custTableName
						    	ON $bookingsTableName.user_name = $custTableName.user_name
							LEFT JOIN $locationTableName lt1
								ON $bookingsTableName.pick_up_location=lt1.location_id
							LEFT JOIN $locationTableName lt2
    							ON $bookingsTableName.drop_off_location=lt2.location_id";

			if ($condition) {
				$query .= " WHERE $condition";
			}

			$query .= " ORDER BY $bookingsTableName.start_date, $bookingsTableName.start_time";

			// perform query and verify successful
			// echo "$query";
			$res = $this->conn->query($query);
			if ($res->num_rows > 0)
			{
				// append all rows to return array
				while($row = $res->fetch_assoc())
				{
					// check for null keys
					$keys = array_keys($row);
					for($i = 0; $i < count($keys); $i++)
					{
						$key = $keys[$i];
						if ($row[$key] == "")
						{
							$row[$key] = "[DeletedItem]";
						}
					}

					array_push($ret, $row);
					// For testing
					if (false)
					{
						print_r($row);
						echo "<br>";
						break;
					}
				}
			}
			else
			{
				$res = null;
			}

			return $ret;
		}

		/**
		 * Retrieve all rows from bookings table, with associated data for some
		 * bookingID
		 */
		public function retrieveBookingForChangeBooking($bookingId)
		{
			$ret = array();

			$cols = "
				booking_table.booking_id, customer_table.user_name,
				customer_table.name, booking_table.start_date, booking_table.start_time,
				booking_table.end_date, booking_table.expected_end_time,
				lt1.location_id AS `pick_up_location_id`, lt1.name AS `pick_up_location`,
				lt2.location_id AS `drop_off_location_id`, lt2.name AS `drop_off_location`";

			$bookingsTableName = $this->tablename;
			$locationTableName = "location_table";			// Table with drop-off and pick-up locations
			$custTableName = "customer_table";				// Table with customer details

			$query =   "SELECT $cols
						FROM $bookingsTableName
						    LEFT JOIN $custTableName
						    	ON $bookingsTableName.user_name = $custTableName.user_name
							LEFT JOIN $locationTableName lt1
								ON $bookingsTableName.pick_up_location=lt1.location_id
							LEFT JOIN $locationTableName lt2
    							ON $bookingsTableName.drop_off_location=lt2.location_id
							WHERE $bookingsTableName.booking_id = $bookingId";

			// perform query and verify successful
			//echo "$query";
			$res = $this->conn->query($query);
			if ($res->num_rows > 0)
			{
				// append all rows to return array
				while($row = $res->fetch_assoc())
				{
					array_push($ret, $row);
					// For testing
					if (false)
					{
						print_r($row);
						echo "<br>";
						break;
					}
				}
			}
			else
			{
				$res = null;
			}

			// return single row as result should be a single row
			return $ret[0];
		}

		/**
		 * TODO: Switch from standard arrays to associative arrays
		 * Required booking data (in order):
		 *	- user_name			  : Customer ID
		 *	- start_date		  : Booking start date
		 *	- start_time		  : Booking start time
		 *	- end_date			  : Booking end date
		 *	- end_time			  : Booking end time
		 *	- booking_duration	  : Duration of booking (in hours)
		 *	- pick_up_location	  : Location of pick-up for booking
		 *	- drop_off_location	  : Location of drop-off for booking
		 *	- booking_fee		  : Price of booking (function of duration and bikes/accessories)
		 *
		 * Required bike data (in order):
		 *	- bike_id[array]	  : Array of bike ids for booking
		 *
		 * Optional data (accessories - in order):
		 *	- accessory_id[array] :	Array of accessory ids for booking (may be empty)
		 *
		 * Performs an SQL transaction
		 *
		 */
		public function addBooking($bookingData, $bikeData, $accessoryData=array())
		{
			$ret = false;

			// initialise local variables (purely for readability/semantic reasons)
			$user_name = $bookingData[0];
			$start_date = $bookingData[1];
			$start_time = $bookingData[2];
			$end_date = $bookingData[3];
			$end_time = $bookingData[4];
			$booking_duration = $bookingData[5];
			$pick_up_location = $bookingData[6];
			$drop_off_location = $bookingData[7];
			$booking_fee = $bookingData[8];

			// Get data for transactions into single strings
			// Booking data
			$bookingData = "'$user_name', '$start_date', '$start_time', '$end_date', '$end_time', $booking_duration, $pick_up_location, $drop_off_location, $booking_fee";

			// construct booking table query
			$bookingTableQuery = "INSERT INTO $this->tablename (user_name, start_date, start_time, end_date, expected_end_time, duration_of_booking, pick_up_location, drop_off_location, booking_fee) VALUES ($bookingData); ";

			// query to save last insert id (from booking) as booking id
			$getLastBookingIdQuery = "SET @booking_id=LAST_INSERT_ID(); ";

			// construct booking bike table query
			// need to repeat for count(explode(",", $bike_id))
			$bookingBikeTableQuery = "INSERT INTO booking_bike_table (booking_id, bike_id) VALUES";
			for($i = 0; $i < count($bikeData); $i++)
			{
				$bikeId = $bikeData[$i];
				$bookingBikeTableQuery .= "(@booking_id, $bikeId)";
				if ($i < count($bikeData) - 1)
				{
					$bookingBikeTableQuery .= ',';
				}
				else
				{
					$bookingBikeTableQuery .= ';';
				}
			}

			// construct booking bike table query
			// need to repeat for count(explode(",", $bike_id))
			$bookingAccessoryTableQuery = "";
			if (count($accessoryData) > 0)
			{
				$bookingAccessoryTableQuery = "INSERT INTO booking_accessory_table (booking_id, accessory_id) VALUES ";
				for($i = 0; $i < count($accessoryData); $i++)
				{
					$accessoryId = $accessoryData[$i];
					$bookingAccessoryTableQuery .= "(@booking_id, $accessoryId) ";

					if ($i < count($accessoryData) - 1)
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
			if ($this->conn->query("START TRANSACTION;") == TRUE)
			{
				$ret = TRUE;
			}

			// execute booking_table query
			echo "<br>$bookingTableQuery<br>";
			if ($this->conn->query($bookingTableQuery) == TRUE)
			{
				$ret = TRUE;
			}

			// retrieve primary key of previously executed query
			if ($this->conn->query($getLastBookingIdQuery) == TRUE)
			{
				$ret = TRUE;
			}

			// execute booking_bike_table query
			if ($this->conn->query($bookingBikeTableQuery) == TRUE)
			{
				$ret = TRUE;
			}

			// execute booking_accessory_table query
			echo $bookingAccessoryTableQuery;
			if ($bookingAccessoryTableQuery != "")
			{
				if ($this->conn->query($bookingAccessoryTableQuery) == TRUE)
				{
					$ret = TRUE;
				}
			}

			// commit changes to database
			if ($this->conn->query("COMMIT;") == TRUE)
			{
				$ret = TRUE;
			}

			return $ret;
		}

		/**
		 * Modify a booking of id `$bookingId`
		 * $bookingData is of order: start_date, start_time, end_date, expected_end_time,
		 *							 duration_of_booking, pick_up_location, drop_off_location,
		 *							 booking_fee
		 */
		public function modifyBooking($bookingId, $bookingData, $bikeData, $accessoryData=array())
		{
			// compile updated data into pairs
			$updatedData = joinDataAndCols($bookingData, array("start_date", "start_time", "end_date", "expected_end_time", "duration_of_booking", "pick_up_location", "drop_off_location", "booking_fee"));

			// construct booking bike table query
			// need to repeat for count(explode(",", $bike_id))
			$bookingBikeTableQuery = "INSERT INTO booking_bike_table (booking_id, bike_id) VALUES";
			for($i = 0; $i < count($bikeData); $i++)
			{
				$bikeId = $bikeData[$i];
				$bookingBikeTableQuery .= "($bookingId, $bikeId)";
				if ($i < count($bikeData) - 1)
				{
					$bookingBikeTableQuery .= ',';
				}
				else
				{
					$bookingBikeTableQuery .= ';';
				}
			}

			// construct booking bike table query
			// need to repeat for count(explode(",", $bike_id))
			$bookingAccessoryTableQuery = "";
			if (count($accessoryData) > 0)
			{
				$bookingAccessoryTableQuery = "INSERT INTO booking_accessory_table (booking_id, accessory_id) VALUES ";
				for($i = 0; $i < count($accessoryData); $i++)
				{
					$accessoryId = $accessoryData[$i];
					$bookingAccessoryTableQuery .= "($bookingId, $accessoryId) ";

					if ($i < count($accessoryData) - 1)
					{
						$bookingAccessoryTableQuery .= ',';
					}
					else
					{
						$bookingAccessoryTableQuery .= ';';
					}
				}
			}

			/*
			 * BEGIN QUERIES
			 */
			$queries = array();
			// start transaction
			array_push($queries, "START TRANSACTION;");

			// edit BookingsTable entry
			// columns: start date, start time, end date,
			// end time, pickup location, dropoff location
			$updatedData = implode(", ", $updatedData);
			array_push($queries, "UPDATE $this->tablename SET $updatedData WHERE booking_id=$bookingId;");

			// delete all BookingAccessory and BookingBike
			// table rows with same booking_id
			array_push($queries, "DELETE FROM booking_bike_table WHERE booking_id=$bookingId;");
			array_push($queries, "DELETE FROM booking_accessory_table WHERE booking_id=$bookingId;");

			// readd BookingAccessory and BookingBike rows
			array_push($queries, $bookingBikeTableQuery);
			array_push($queries, $bookingAccessoryTableQuery);

			// end transaction
			array_push($queries, "COMMIT;");

			$success = true;
			for($i = 0; $i < count($queries); $i++)
			{
				$query = $queries[$i];
				echo "$query<br>";
				$success &= !($this->conn->query($query));
			}

			return $success;
		}

		/**
		 * Delete booking with some bookingId
		 */
		function deleteBooking($bookingId)
		{
			/*
			 * BEGIN QUERIES
			 */
			$queries = array();
			// start transaction
			array_push($queries, "START TRANSACTION;");

			// delete all bookings, BookingAccessory, and BookingBike
			// table rows with same booking_id
			array_push($queries, "DELETE FROM booking_bike_table WHERE booking_id=$bookingId;");
			array_push($queries, "DELETE FROM booking_accessory_table WHERE booking_id=$bookingId;");

			// This must be done last due to foreign key constraints
			array_push($queries, "DELETE FROM booking_table WHERE booking_id=$bookingId;");

			// end transaction
			array_push($queries, "COMMIT;");

			$success = true;
			for($i = 0; $i < count($queries); $i++)
			{
				$query = $queries[$i];
				//echo "$query<br>";
				$success &= !($this->conn->query($query));
			}

			return $success;
		}

		//Jake.H Prints out and assigned selected box based on states
		public function printStates($state)
		{
			echo "<select name='state' id='state'>;";
			if ($state == "NSW")
			{
				echo "<option value='NSW' Selected>NSW</option>;";
			}
			else
			{
				echo "<option value='NSW'>NSW</option>;";
			}

			if ($state == "NT")
			{
				echo "<option value='NT' Selected>NT</option>;";
			}
			else
			{
				echo "<option value='NT'>NT</option>;";
			}

			if ($state == "QLD")
			{
				echo "<option value='QLD' Selected>QLD</option>;";
			}
			else
			{
				echo "<option value='QLD'>QLD</option>;";
			}

			if ($state == "SA")
			{
				echo "<option value='SA' Selected>TAS</option>;";
			}
			else
			{
				echo "<option value='SA'>TAS</option>;";
			}

			if ($state == "WA")
			{
				echo "<option value='WA' Selected>WA</option>;";
			}
			else
			{
				echo "<option value='WA'>WA</option>;";
			}

			if ($state == "TAS")
			{
				echo "<option value='TAS' Selected>WA</option>;";
			}
			else
			{
				echo "<option value='TAS'>WA</option>;";
			}

			if ($state == "VIC")
			{
				echo "<option value='VIC' selected>VIC</option>;";
			}
			else
			{
				echo "<option value='VIC'>VIC</option>;";
			}

			echo "</select>";
		}
	}
?>
