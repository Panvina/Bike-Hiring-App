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
		 *		- colnames : columns to retrieve from table (e.g. 'id, name, address')
		 *		- data : columns to retrieve from table (e.g. 'id, name, address')
		 *		- id : id of row to update
		 *
		 *	Return:
		 *		- ret : return if update was successful
		 */
		public function update($tablename, $id, $colnames, $data)
		{
			$ret = FALSE;

			$this->getConn();
			$columnValuePairs = [];
			if (is_array($colnames))
			{

			}
			$query = "UPDATE $tablename SET lastname='Doe' WHERE id=2";

			//echo $query;
			if ($this->conn->query($query) == TRUE)
			{
				$ret = TRUE;
			}

			$this->closeConn();

			return $ret;
		}

		/**
		 *	DELETE method
		 *	Parameters:
		 *		- tablename : name of table (e.g. 'bike_types')
		 *		- id : id of item to delete
		 *
		 *	Return:
		 *		- Return if delete operation was successful
		 */
		public function delete($tablename, $id)
		{
			$ret = FALSE;

                        $this->getConn();
			$query = "DELETE FROM $tablename WHERE id=$id";
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
	}


	// Instantiate database connection object
	$conn = new DBConnection();

	// Test INSERT method
    $conn->insert("bike_type_table", "Name, Description", "'Hydro', 'Non-existent'");
    echo "insert bike_type_table name=hydro, description=non-existent";

	// Test GET method
    $ret = $conn->get("bike_type_table", "BikeTypeID, Name, Description");
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
    //$conn->insert("bike_type_table", "Name, Description", "'Hydro', 'Non-existent'");
    //$conn->delete();
?>
