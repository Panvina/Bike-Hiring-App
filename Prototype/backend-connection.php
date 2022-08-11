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

		public function insert($tablename, $columns, $data)
		{
			$this->getConn();
			$query = "INSERT INTO $tablename ($columns) VALUES ($data)";
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

		public function update()
		{
			$this->getConn();
			$query = "INSERT INTO $tablename ($columns) VALUES ($data)";
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
