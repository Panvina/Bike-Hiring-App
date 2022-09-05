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

		/**
		 *	INSERT method
		 *	Parameters:
		 *		- tablename : name of table (e.g. 'bike_types')
		 *		- colnames : columns to fill from table (e.g. 'id, name, address')
		 *		- data : conditional on which rows to retrieve (e.g. '"val1", "val2", "val3"')
		 *
		 *	Return:
		 * 		- Return if insert was successful
		 *
		 *	To insert a new row, need to first create a booking_table row:
		 *		Requirements:
		 *		- CustomerID, Start Date, End Date, Start Time, End Time, Duration, Pick-up, Drop-off, and final price
		 *			- Final Price =
		 */
		public function insert($columns="name phone_number, email, street_address, suburb, post_code, license_number", $data)
		{
			$ret = FALSE;

			$data = explode(',', $data);
			if (count($data) == count(explode(',', $columns)))
			{
				$query = "INSERT INTO $tablename ($columns) VALUES ($data)";
				//echo $query;
				if ($this->conn->query($query) == TRUE)
				{
					$ret = TRUE;
				}
			}
			else
			{
				echo "Data value count is incorrect.";
			}

			return $ret;
		}
	}

	$doTest = false;

	if ($doTest)
	{
		$conn = new CustomerDBConnection();
		$customerList = $conn->get("cust_id, name");

		if ($customerList != null)
		{
			$keys = array_keys($customerList[0]);
			for($i = 0; $i < count($customerList); $i++)
			{
				$row = $customerList[$i];
				$option = array();
				$id = 0;
				// echo "<br>Printing: ";
				// print_r($row);
				// echo "<br>";

				for($j = 0; $j < count($keys); $j++)
				{
					$key = $keys[$j];
					if ($key == "cust_id")
					{
						$id = $key;
					}
					// echo "<br>val = $row[$key]<br>";
					array_push($option, $row[$key]);
				}
				$option = implode(": ", $option);
				echo "<option value='$id'>$option</option>";
			}
		}
	}
?>
