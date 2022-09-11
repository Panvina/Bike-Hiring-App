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
		public function insert($columns="bike_id, name, bike_type_id, helmet_id, price_ph, safety_inspect, description", $data)
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
	}
?>
