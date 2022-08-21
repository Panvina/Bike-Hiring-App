<?php
	class DBConnection
	{
		public $servername = "";
		public $username = "";
		public $password = "";
		public $dbname = "";

		public $conn = null;

		public function __construct($servername="localhost", $username="root", $password="", $dbname="bike_hiring_system")
		{
			$this->servername = $servername;
			$this->username = $username;
			$this->password = $password;
			$this->dbname = $dbname;
		}

		private function getConn()
		{
			$this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
		}

		private function closeConn()
		{
			$this->conn->close();
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
		public function insert($tablename, $columns, $data)
		{
			$ret = FALSE;

			$this->getConn();
			$query = "INSERT INTO $tablename ($columns) VALUES ($data)";
			//echo $query;
			if ($this->conn->query($query) == TRUE)
			{
				$ret = TRUE;
			}

			$this->closeConn();
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

			$this->getConn();

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

			$this->closeConn();

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

            $this->getConn();
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
			$this->closeConn();

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

			$this->getConn();
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

            $this->closeConn();

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

			$this->getConn();

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

			$this->closeConn();

			return $ret;
		}
	}

	/**
	 *	Prints a table. For testing.
	 *	Parameters:
	 *	- $tablename	: name of table to print
	 */
	function printRows($tablename)
	{
		$conn = new DBConnection();
		echo "<br>Printing array<br>";
		$ret = $conn->get("$tablename", "*");
		$keys = array_keys($ret[0]);
		for($x = 0; $x < count($ret); $x++)
		{
			$row = $ret[$x];
			$str = "";
			for($y = 0; $y < count($keys); $y++)
			{
				$key = $keys[$y];
				$str .= "$key: ";
				$str .="$row[$key] ";
			}
			echo "$str<br>";
		}
	}

	// change this variable to true to perform test
	$doTest = false;
	if ($doTest)
	{
		// Instantiate database connection object
		$conn = new DBConnection();

		// Test INSERT method
	    $conn->insert("bike_type_table", "Name, Description", "'Hydro', 'Non-existent'");
	    echo "INSERT success";

		// Test GET method
		printRows("bike_type_table");

		echo "GET success";

		// Test UPDATE method
		$conn->insert("bike_type_table", "Name, Description", "'Hydro', 'Non-existent'");
		echo "inserted<br>";
		$ret = $conn->getLastX("bike_type_table", "BikeTypeID", 1);
		$toUpdateId = $ret[0]["BikeTypeID"];
		$conn->update("bike_type_table", "BikeTypeID", $toUpdateId, "Description, Name", "New Description, Updated-Hydro");

		// Test DELETE method
		$conn->insert("bike_type_table", "Name, Description", "'Hydro', 'Test'");
		$ret = $conn->getLastX("bike_type_table", "BikeTypeID", 1);
		$toDeleteId = $ret[0]["BikeTypeID"];

		printRows("bike_type_table");
		$conn->delete("bike_type_table", "BikeTypeID", $toDeleteId);
		echo "<br>DELETE success";

		printRows("bike_type_table");
	}
?>
