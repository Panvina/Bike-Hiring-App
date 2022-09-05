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
		 *	INSERT method
		 *	Parameters:
		 *		- tablename : name of table (e.g. 'bike_types')
		 *		- colnames : columns to fill from table (e.g. 'id, name, address')
		 *		- data : conditional on which rows to retrieve (e.g. '"val1", "val2", "val3"')
		 *
		 *	Return:
		 * 		- Return if insert was successful
		 *
		 *	To insert a new row, need to first create a booking_table row:
		 *		Requirements:
		 *		- CustomerID, Start Date, End Date, Start Time, End Time, Duration, Pick-up, Drop-off, and final price
		 *			- Final Price =
		 */
		public function insert($columns="CustID, BikeID, `Start Date`, `End Date`, `Start Time`, `Expected End Time`, `Duration of Booking`, `Pick Up Location`, `Drop Off Location`, `Final Price`", $data)
		{
			$ret = FALSE;

			$data = explode(',', $data);
			if (count($data) == count(explode(',', $columns)))
			{
				$query = "INSERT INTO $tablename ($columns) VALUES ($data)";
				//echo $query;
				if ($this->conn->query($query) == TRUE)
				{
					$ret = TRUE;
				}
			}
			else
			{
				echo "Data value count is incorrect.";
			}

			return $ret;
		}

		/**
		 *	Retrieve all rows from bookings table, with associated data.
		 *	USAGE:
		 *
		 *
		 *
		 */
		public function getBookingRows()
		{
			$ret = array();

			$cols = "
				booking_table.booking_id, bike_inventory_table.name as `Bike Name`,
				customer_table.name, booking_table.start_date, booking_table.start_time,
				booking_table.end_date, booking_table.expected_end_time,
				booking_table.duration_of_booking, lt1.name AS `Pick Up`,
				lt2.name AS `Drop Off`, booking_table.final_price";

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
						    	ON $bookingsTableName.cust_id = $custTableName.cust_id
							LEFT JOIN $locationTableName lt1
								ON $bookingsTableName.pick_up_location=lt1.location_id
							LEFT JOIN $locationTableName lt2
    							ON $bookingsTableName.drop_off_location=lt2.location_id";

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

			return $ret;
		}
	}
?>
