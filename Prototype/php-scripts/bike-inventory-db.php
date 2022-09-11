<?php
	include_once "backend-connection.php";

	class BikeInventoryDBConnection extends DBConnection
	{
		public function __construct($tablename="bike_inventory_table", $servername="localhost", $username="root", $password="", $dbname="bike_hiring_system")
		{
			$this->servername = $servername;
			$this->username = $username;
			$this->password = $password;
			$this->dbname = $dbname;
			$this->tablename = $tablename;

			$this->getConn();
		}

		/**
		 * Get all currently unavailable bikes from inventory
		 */
		public function getUnavailableBikes()
		{
			$ret = $this->get("*", "safety_inspect=0");

			return $ret;
		}

		/**
		 * Get all currently available bikes from inventory
		 */
		public function getAvailableBikes()
		{
			$ret = $this->get("*", "safety_inspect=1");

			return $ret;
		}
	}
?>
