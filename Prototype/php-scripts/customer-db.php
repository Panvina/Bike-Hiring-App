<?php
	include_once "backend-connection.php";

	class CustomerDBConnection extends DBConnection
	{
		public function __construct($tablename="customer_table", $servername="localhost", $username="root", $password="", $dbname="bike_hiring_system")
		{
			echo "<script>console.log('Test');</script>";
			$this->servername = $servername;
			$this->username = $username;
			$this->password = $password;
			$this->dbname = $dbname;
			$this->tablename = $tablename;

			$this->getConn();

			echo "<script>console.log('Test');</script>";
		}

		//Jake.H
		//not working currently atm
		public function checkMultipleUserName($username)
		{
			$ret = false;
			$customerTable = "customer_table";
			$employeeTable = "employee_table";
			$fetchedUserName = substr($username, 3);

			// $query = "SELECT customer_table.user_name FROM customer_table UNION ALL SELECT employee_table.user_name FROM employee_table
			// where ($employeeTable.user_name = $fetchedUserName) OR ($employeeTable.user_name = $fetchedUserName)";
			
			$query = "SELECT customer_table.user_name FROM customer_table inner join employee_table on employee_table.user_name = customer_table.$fetchedUserName
			where customer_table.user_name = $fetchedUserName";

			$res = $this->conn->query($query);
			if ($res->num_rows >= 1)
			{
				$ret = true;
			}

			return $ret;
		}

		public function printStates()
		{
			echo "<select name='state' id='state'>;   
					<option value='NSW'>NSW</option>;
					<option value='NT'>NT</option>;
					<option value='QLD'>QLD</option>;
					<option value='SA'>TAS</option>;
					<option value='WA'>WA</option>;
					<option value='TAS'>WA</option>;
					<option value='VIC' selected>VIC</option>;
					</select>";
		}
	}

?>
