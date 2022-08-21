<?php
	include "backend-connection.php";

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

		public function getBookingRows()
		{
			$ret = array();

			$cols = "
				booking_table.BookingID,bike_inventory_table.Name as `Bike Name`,
				customer_table.Name as `Customer Name`, booking_table.`Start Date`,
				booking_table.`Start Time`, `booking_table`.`End Date`, booking_table.`Expected End Time`,
				booking_table.`Duration Of Booking`, lt1.Name as `Pick Up Location`,
				lt2.Name as `Drop Off Location`, booking_table.`Final Price`";

			$bookingsTableName = $this->tablename;
			$locationTableName = "location_table";
			$bikeInvTableName = "bike_inventory_table";
			$custTableName = "customer_table";

			/*
			 * Select rows: BookingID, CustomerID, BikeID, Start Date, Start Time,
			 * 		End Date, End Time, Duration, Pick Up Location, Drop Off Location.
			 *		and price
		 	 *	From booking_table Table
		 	 *	Join locations, bike inventory, and customers with original selection
			 */
			$query =   "SELECT $cols
						FROM $bookingsTableName
							LEFT JOIN $locationTableName lt1
								ON $bookingsTableName.`Pick Up Location`=`lt1`.`LocationID`
							LEFT JOIN $locationTableName lt2
    							ON $bookingsTableName.`Drop Off Location`=`lt2`.`LocationID`
    						LEFT JOIN $bikeInvTableName
						    	ON $bikeInvTableName.`BikeID` = $bookingsTableName.`BikeID`
						    LEFT JOIN $custTableName
						    	ON $bookingsTableName.CustID = $custTableName.`CustID`";

			// perform query and verify successful
			// echo "$query";
			$res = $this->conn->query($query);
			if ($res->num_rows > 0)
			{
				// append all rows to return array
				while($row = $res->fetch_assoc())
				{
					array_push($ret, $row);
				}
			}
			else
			{
				$res = null;
			}

			return $ret;
		}

		/**
		 *	Update method
		 *	Parameters:
		 *		- tablename : name of table (e.g. 'bike_types')
		 *		- colnames 	: columns to retrieve from table (e.g. 'id, name, address')
		 *						- Type: String
		 *						- e.g. "colname1, colname2, colname3"
		 *						NOTE: len(colnames) must equal len(data)
		 *		- data	 	: columns to retrieve from table (e.g. 'id, name, address')
	 	 *						- Type: String
	 	 *						- e.g. "data1, data2, data3"
		 *		- idColName : name of the primary key of table
		 *		- id 		: id of row to update
		 *
		 *	Return:
		 *		- ret : return if update was successful
		 */
		public function update($idColName, $id, $colnames, $data)
		{
			$ret = false;

			// Convert data and columns to arrays
			$cols = explode(",", $colnames);
			$data = explode(",", $data);

			// confirm that number of column names and data are coherent
			$colDataCheckSuccess = count($data) == count($cols);

			if ($colDataCheckSuccess)
			{
				// construct update query
				$query = "UPDATE $this-> SET ";

				for($x = 0; $x < count($cols); $x++)
				{
					// remove trailing and leading whitespace characters
					$col = trim($cols[$x]);
					$dat = trim($data[$x]);
					if (!is_numeric($dat))
					{
						$dat = "'$dat'";
					}

					$query .= "$col=$dat";

					if ($x != count($cols) - 1)
					{
						$query .= ", ";
					}
				}
				$query .= " WHERE $idColName=$id";

				//echo $query;
				if ($this->conn->query($query) == TRUE)
				{
					$ret = TRUE;
				}
			}
			else
			{
				echo "<br>Data and column counts are not equal<br>";
			}

			return $ret;
		}

		/**
		 *	DELETE method
		 *	Parameters:
		 *		- tablename 	: name of table (e.g. 'bike_types')
		 *		- pkeyColName	: name of primary key
		 *		- pkeyValue		: primary key if of item to delete
		 *
		 *	Return:
		 *		- Return if delete operation was successful
		 */
		public function delete($pkeyColName, $pkeyValue)
		{
			$ret = FALSE;

			$query = "DELETE FROM $this->tablename WHERE $pkeyColName=$pkeyValue";
			//echo $query;
			if ($this->conn->query($query) == TRUE)
			{
				echo "Record deleted successfully!";
			}
			else
			{
				echo "Error: " . $query . "<br>" . $this->conn->error;
			}

			return $ret;
		}

		/**
		 *	SELECT method
		 *	Parameters:
		 *		- tablename : name of table (e.g. 'bike_types')
		 *		- colnames : columns to retrieve from table (e.g. 'id, name, address')
		 *			- NOTE: Can leave as '*' to get all columns
		 *		- condition : conditional on which rows to retrieve (e.g. 'col1 = someValue')
		 *
		 *	Return:
		 *		- ret : Array of rows returned by query
		 */
		public function get($colnames, $condition=0)
		{
			$ret = array();

			$query = "SELECT $colnames FROM $this->tablename";
			if ($condition)
			{
				$query = append_string($query, " WHERE $condition");
			}

			echo '<br>';
			echo $query;
			$res = $this->conn->query($query);
			if ($res->num_rows > 0)
			{
				while($row = $res->fetch_assoc())
				{
					array_push($ret, $row);
				}
			}

            return $ret;
		}
	}
?>
