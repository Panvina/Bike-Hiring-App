<!--
Project Name: Inverloch Bike Hire
Project Description: A website for hiring bikes. Front-end accompanied
	   by an admin dashboard.
File Description: interface for interacting with the customer table and related operations.
Contributor(s) of main file: Dabin Lee @ icelasersparr@gmail.com
Altered for different testing purposes: Jake Hipworth @ 102090870@student.swin.edu.au
-->
<?php
	include_once "../customer-db.php";

	// setup
	$conn = new CustomerDBConnection();
	$sql = new mysqli("localhost", "root", "", "bike_hiring_system");

	// add customer
	$customerQuery = "INSERT INTO customer_table (user_name,name,phone_number,email,street_address,suburb,post_code,licence_number,state) VALUES ('testcustomer','testname',0,'testemail','testaddress','testsuburb','testpostcode',0,'teststate')";
	$sql->query($customerQuery);

	try {
		// Add customer test:
		// check customer exists after adding
		$customerRow = $sql->query("SELECT user_name FROM customer_table WHERE user_name='testcustomer'");
		$countRows = $customerRow->num_rows;
		if ($countRows == 1) {
			$customerUser_Name = $customerRow->fetch_assoc()["user_name"];

			if ($customerUser_Name == 'testcustomer')
			{
				echo "Test success: Add Customer success.<br>";
			}
			else
			{
				echo "Test failed: Add Customer failed. Customer user_name=$customerUser_Name. Expected testcustomer<br>";
			}

			//Update customer test:
			$sql->query("UPDATE customer_table SET name = 'newUpdateTestName' WHERE user_name = 'testcustomer'");
			$customerNameRow = $sql->query("SELECT name FROM customer_table WHERE user_name='testcustomer'");
			$customerName = $customerNameRow->fetch_assoc()["name"];
			if ($customerName == "newUpdateTestName")
			{
				echo "Test success: Update Customer success.<br>";
			}
			else
			{
				echo "Test failed: Update Customer failed. Customer name=$customerName. Expected newUpdateTestName<br>";
			}

		}
		else
		{
			echo "Test failed: No customer found.<br>";
		}

		//delete customer test:
		$sql->query("DELETE FROM customer_table WHERE user_name = 'testcustomer'");
		$customerDeleteRow = $sql->query("SELECT user_name FROM customer_table WHERE user_name='testcustomer'");
		$countNewRows = $customerDeleteRow->num_rows;
		if ($countNewRows == 0)
		{
			echo "Test success: Delete Customer success.<br>";
		}
		else
		{
			echo "Test failed: Delete Customer failed.<br>";
		}
	}
	catch (Exception $e) {
		$msg = $e->getMessage();
		echo "<br>$msg";
	}
	finally {
		cleanup();
	}

	function cleanup() {
		$sql = new mysqli("localhost", "root", "", "bike_hiring_system");

		// delete customer
		$sql->query("DELETE FROM customer_table WHERE user_name='testcustomer'");

		echo "<br>Cleanup completed.";
	}
?>