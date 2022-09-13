<?php
	include_once "backend-connection.php";

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

		/**
		 * Get all currently unavailable bikes from inventory
		 */
		public function getUnavailableBikes()
		{
			$ret = $this->get("*", "safety_inspect=0");

			return $ret;
		}

		/**
		 * Get all currently available bikes from inventory
		 */
		public function getAvailableBikes()
		{
			$ret = $this->get("*", "safety_inspect=1");

			return $ret;
		}

		/**
		 * Get bike availability between start and end
		 *
		 *
		 * All parameters are strings.
		 * Dates are to be formatted as: YYYY-mm-dd
		 */
		public function getBikesAvailabilityAtDate($startDate, $startTime, $endDate, $endTime)
		{
			$bikeTable = $this->tablename;
			$bookingTable = "booking_table";
			$bookingBikeTable = "booking_bike_table";

			// construct query. Join with booking table and booking_bike_table
			$query =   "SELECT $bikeTable.bike_id
						FROM $bikeTable
							LEFT JOIN $bookingTable
								ON $bikeTable.bike_id = $bookingTable.bike_id
						WHERE ";

			// // prospective booking within existing bookings
			// // that is prospective booking start and end date within existing booking start and end dates
			// $query .= "('$startDate' >= $bookingTable.start_date AND
			// 			'$endDate' <= $bookingTable.endDate) AND ";
			//
			// // prospective booking starts before, but ends during existing booking
			// $query .= "('$startDate' <= $bookingTable.start_date AND
			// 			'$endDate' <= $bookingTable.endDate) AND ";
			//
			// // prospective booking starts after, but ends before existing booking
			// $query .= "('$startDate' >= $bookingTable.start_date AND
			// 			'$endDate' >= $bookingTable.endDate) AND ";

			$query =   "SELECT $cols
						FROM $bookingsTableName
						    LEFT JOIN $custTableName
						    	ON $bookingsTableName.user_name = $custTableName.user_name
							LEFT JOIN $locationTableName lt1
								ON $bookingsTableName.pick_up_location=lt1.location_id
							LEFT JOIN $locationTableName lt2
    							ON $bookingsTableName.drop_off_location=lt2.location_id
						WHERE $bookingsTableName.booking_id = $bookingId";
		}
	}
?>
