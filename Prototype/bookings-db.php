<?php
	include "backend-connection.php";

	class BookingsDBConnection extends DBConnection
	{
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
		public function insert($tablename="booking_table", $columns="CustID, BikeID, Start Date, End Date, Start Time, Expected End Time, Duration of Booking, Pick Up Location, Drop Off Location, Final Price", $data)
		{
			$ret = FALSE;

			$data = explode(',', $data);

			$query = "INSERT INTO $tablename ($columns) VALUES ($data)";
			//echo $query;
			if ($this->conn->query($query) == TRUE)
			{
				$ret = TRUE;
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
		public function update($tablename, $idColName, $id, $colnames, $data)
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
				$query = "UPDATE $tablename SET ";

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
		public function delete($tablename, $pkeyColName, $pkeyValue)
		{
			$ret = FALSE;

			$query = "DELETE FROM $tablename WHERE $pkeyColName=$pkeyValue";
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
		public function get($tablename, $colnames, $condition=0)
		{
			$ret = array();

			$query = "SELECT $colnames FROM $tablename";
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

		/**
		 *	Retrieve the last 'x' rows from a table.
		 *
		 * 	Parameters:
		 *	- tablename	: name of table to get from
		 *	- pkeyName	: name of primary key of table (auto-incrementing pkey)
		 *	- x			: number of rows (from last) to retrieve
		 */
		public function getLastX($tablename, $pkeyName, $x)
		{
			$ret = array();

			$query = "SELECT * FROM $tablename ORDER BY $pkeyName DESC LIMIT $x";
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
	}
?>
