<?php
	/**
	 * IMPORTANT NOTE:
	 *	- For column names with spaces, MySQL uses backticks (`) for these. Don't forget these, or the query will fail.
	 *
	 * Made by Dabin Lee (unless specified otherwise)
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

		public function __destruct()
		{
			$this->closeConn();
		}

		// create new database connection
		protected function getConn()
		{
			$this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
		}

		// Close database connection.
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
		public function insert($columns, $data)
		{
			$ret = FALSE;

			$query = "INSERT INTO $this->tablename ($columns) VALUES ($data)";
			// echo $query;
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

					// signal that a string is a string
					if (substr("$dat", 0, 1) == "0" || !is_numeric($dat))
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

				// echo $query;
				// exit();
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
			$query = "DELETE FROM $this->tablename WHERE $pkeyColName=$pkeyValue";
			//echo $query;
			$ret = $this->conn->query($query);

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

			// echo '<br>';
			// echo $query;
			// exit();
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

		//Jake.H accepts a query and runs the query in the database
		public function runQuery($query)
		{
			$ret = false;

			if ($this->conn->query($query) == TRUE)
			{
				$ret = TRUE;
			}

			return $ret;
		}
	}
?>
