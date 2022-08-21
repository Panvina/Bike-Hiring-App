<?php
	class DBConnection
	{
		public $conn = null;

		public function __construct($servername, $username, $password, $dbname)
		{
			$this->conn = new mysqli($servername, $username, $password, $dbname);
		}

		public function __destruct()
		{
			$this->conn->close();
		}

		public function insert($tablename, $columns, $data)
		{
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
		}
	}

	$conn = new DBConnection("localhost", "root", "", "bike_hiring_system");
	//$conn->insert("bike_type_table", "Name, Description", "'Hydro', 'Non-existent'");

	// $servername = "localhost";
	// $username = "root";
	// $password = "";
	// $dbName = "bike_hiring_system";
	//
	// // Create connection
	// $conn = new mysqli($servername, $username, $password, $dbName);
	//
	// // Check connection
	// if ($conn->connect_error) {
	// 	die("Connection failed: " . $conn->connect_error);
	// 	echo "Connection failed";
	// }
	// 	echo "Connected successfully";
	//
	// $sql = "INSERT INTO bike_type_table (Name, Description)
	// VALUES ('Electric', 'Bad bikes')";
	//
	// if ($conn->query($sql) === TRUE) {
	//   echo "New record created successfully";
	// } else {
	//   echo "Error: " . $sql . "<br>" . $conn->error;
	// }
	//
	// $conn->close();
?>

<?php
?>
