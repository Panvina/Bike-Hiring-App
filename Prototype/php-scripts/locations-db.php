<?php
	include_once "backend-connection.php";

	class LocationsDBConnection extends DBConnection
	{
		public function __construct($tablename="location_table", $servername="localhost", $username="root", $password="", $dbname="bike_hiring_system")
		{
			$this->servername = $servername;
			$this->username = $username;
			$this->password = $password;
			$this->dbname = $dbname;
			$this->tablename = $tablename;

			$this->getConn();
		}
	}
?>
