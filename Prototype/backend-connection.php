<?php
	/**
	 *
	 *
	 *
	 *
	 * IMPORTANT NOTE:
	 *	- For column names with spaces, MySQL uses backticks (`) for these. Don't forget these, or the query will fail.
	 */
	
	class DBConnection
	{
		protected $servername = "";
		protected $username = "";
		protected $password = "";
		protected $dbname = "";
		protected $tablename = "";

		protected $conn = null;

		public function __construct($tablename, $servername="localhost", $username="root", $password="", $dbname="bike_hiring_system")
		{
			$this->servername = $servername;
			$this->username = $username;
			$this->password = $password;
			$this->dbname = $dbname;
			$this->tablename = $tablename;

			$this->getConn();
		}

		// public function __construct($servername, $username, $password, $dbname)
		// {
		// 	$this->conn = new mysqli($servername, $username, $password, $dbname);
		// }

		public function __destruct()
		{
			$this->closeConn();
		}

		protected function getConn()
		{
			$this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
		}

		protected function closeConn()
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
		
		public function insert($columns, $data)
		{
			// $this->closeConn();
			// $this->getConn();
			$ret = FALSE;

			$query = "INSERT INTO $this->tablename ($columns) VALUES ($data)";
			echo $query;
			if ($this->conn->query($query) == TRUE)
			{
				$ret = TRUE;
			}

			return $ret;
		}
			
		// public function insert($tablename, $columns, $data)
		// {
		// 	$query = "INSERT INTO $tablename ($columns) VALUES ($data)";
		// 	//echo $query;
		// 	if ($this->conn->query($query) == TRUE)
		// 	{
		// 		echo "Record created successfully";
		// 	}
		// 	else
		// 	{
		// 		echo "Error: " . $query . "<br>" . $this->conn->error;

		// 	}
		// }

		// public function insert($tablename, $columns, $data)
		// {
		// 	$query = "INSERT INTO $tablename ($columns) VALUES ($data)";
		// 	//echo $query;
		// 	if ($this->conn->query($query) == TRUE)
		// 	{
		// 		echo "Record created successfully";
		// 	}
		// 	else
		// 	{
		// 		echo "Error: " . $query . "<br>" . $this->conn->error;

		// 	}
		// }

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
				$query = "UPDATE $this->tablename SET ";

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

				echo $query;
				//echo "<p> $query </p>";
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
			echo $query;
			if ($this->conn->query($query) == TRUE)
			{
				echo "Record deleted successfully!";
				$ret = true;
			}
			else
			{
				echo "Error: " . $query . "<br>" . $this->conn->error;
			}

			return $ret;
		}

		public function findPrimaryKey()
		{
			$ret = array();

			$query = "SHOW KEYS FROM $this->tablename WHERE Key_name = 'PRIMARY'";

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
				$query .= " WHERE $condition";
			}

			echo '<br>';
			//echo $query;
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
		public function getLastX($pkeyName, $x)
		{
			$query = "SELECT * FROM $this->tablename ORDER BY $pkeyName DESC LIMIT $x";
			echo '<br>';
			echo $query;
			$ret = $this->conn->query($query);
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
		 *	Prints a table. For testing.
		 *	Parameters:
		 *	- $tablename	: name of table to print
		 */
		public function printRows()
		{
			echo "<br>Printing array<br>";
			$ret = $this->get("*");
			$keys = array_keys($ret[0]);
			for($x = 0; $x < count($ret); $x++)
			{

				$key = $keys[$y];
				$str .= "$key: ";
				$str .="$row[$key] ";

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

		// Convert result from SQL query to PHP array
		public function getRowsFromResult($queryRes)
		{
			$ret = null;

			if ($queryRes->num_rows > 0)
			{
				$ret = array();
				while($row = $queryRes->fetch_assoc())
				{
					array_push($ret, $row);
				}
			}

			return $ret;
		}
	}

	// change this variable to true to perform test
	$doTest = false;
	if ($doTest)
	{
		// Instantiate database connection object
		$conn = new DBConnection("bike_type_table");

		// Test INSERT method
	    $conn->insert("Name, Description", "'Hydro', 'Non-existent'");
	    echo "INSERT success";

		// Test GET method
		$conn->printRows();

		echo "GET success";

		// Test UPDATE method
		$conn->insert("Name, Description", "'Hydro', 'Non-existent'");
		$conn->printRows();
		echo "inserted<br>";
		$ret = $conn->getLastX("BikeTypeID", 1);
		$toUpdateId = $ret[0]["BikeTypeID"];
		$conn->update("BikeTypeID", $toUpdateId, "Description, Name", "New Description, Updated-Hydro");
		$conn->printRows();

		// Test DELETE method
		$conn->insert("Name, Description", "'Hydro', 'Test'");
		$ret = $conn->getLastX("BikeTypeID", 1);
		$toDeleteId = $ret[0]["BikeTypeID"];

		$conn->printRows("bike_type_table");
		$conn->delete("BikeTypeID", $toDeleteId);
		echo "<br>DELETE success";

		$conn->printRows("bike_type_table");
	}
?>
