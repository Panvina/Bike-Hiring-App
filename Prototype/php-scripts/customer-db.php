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
		public function checkMultipleUserName($username)
		{
			$ret = false;
			$customerTable = "customer_table";
			$employeeTable = "employee_table";
			$fetchedUserName = substr($username, 3);

			$query = "SELECT customer_table.user_name FROM customer_table UNION ALL SELECT employee_table.user_name FROM employee_table
			where ($employeeTable.user_name = $fetchedUserName) OR ($employeeTable.user_name = $fetchedUserName)";

			$res = $this->conn->query($query);
			if ($res->num_rows >= 1)
			{
				$ret = true;
			}

			return $ret;
		}
	}

?>
