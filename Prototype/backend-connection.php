<?php
	class DBConnection
	{
		public $servername = "";
		public $username = "";
		public $password = "";
		public $dbname = "";

		public $conn = null;

		public function __construct($servername, $username, $password, $dbname)
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

			$this->close();
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

			$this->close();

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
			$this->close();

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
		public function get($tablename, $colnames, $condition)
		{
			$ret = [];

			$this->getConn();
			$query = "SELECT $colnames FROM $tablename WHERE $condition";
			//echo $query;
			$res = $this->conn->query($query);
			if ($res->num_rows > 0)
			{
				while($row = $res->fetch_assoc())
				{
					array_push($res, $row);
				}
			}

                        $this->close();

                        return $ret;
		}

		public function delete($tablename, $id)
		{
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
			$this->close();
		}

		public function get($tablename, $names, )
		{
			$this->getConn();
			$query = "SELECT id, firstname, lastname FROM MyGuests";
			//echo $query;
			if ($this->conn->query($query) == TRUE)
			{
				echo "Record created successfully";
			}
			else
			{
				echo "Error: " . $query . "<br>" . $this->conn->error;
			}
			$this->close();
		}
	}

	// Testing
	// $conn = new DBConnection("localhost", "root", "", "bike_hiring_system");
	// $conn->insert("bike_type_table", "Name, Description", "'Hydro', 'Non-existent'");
?>
