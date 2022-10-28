<?php
/* Code completed by Aadesh Jagannathan - 102072344*/
	include_once "backend-connection.php";

	class DamagedItemsDBConnection extends DBConnection
	{
		public function __construct($tablename="damaged_items_table", $servername="localhost", $username="root", $password="", $dbname="bike_hiring_system")
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
		public function getDamagedBikes()
		{
			$ret = $this->get("*", "bike_id IS NOT NULL");

			return $ret;
		}

		/**
		 * Get all currently available bikes from inventory
		 */
		public function getDamagedAccessories()
		{
			$ret = $this->get("*", "accessory_id IS NOT NULL");

			return $ret;
		}
	}
?>
