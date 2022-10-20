<!--
Project Name: Inverloch Bike Hire
Project Description: A website for hiring bikes. Front-end accompanied
	   by an admin dashboard.
File Description: interface for interacting with the customer table and related operations.
Contributor(s) of main file: Dabin Lee @ icelasersparr@gmail.com
Altered for different testing purposes: Jake Hipworth @ 102090870@student.swin.edu.au
-->
<?php
	include("../backend-connection.php");

	// setup
	$conn = new DBConnection("employee_table");
	$sql = new mysqli("localhost", "root", "", "bike_hiring_system");

	// add customer
	$staffQuery = "INSERT INTO employee_table (user_name,name,phone_number,email,address,suburb,post_code,state) VALUES ('teststaff','testname',0,'testemail','testaddress','testsuburb','testpostcode','teststate')";
	$sql->query($staffQuery);

	try {
		// Add staff test:
		// check staff exists after adding
		$staffRow = $sql->query("SELECT user_name FROM employee_table WHERE user_name='teststaff'");
		$countRows = $staffRow->num_rows;
		if ($countRows == 1) {
			$staffUser_Name = $staffRow->fetch_assoc()["user_name"];

			if ($staffUser_Name == 'teststaff')
			{
				echo "Test success: Add staff success.<br>";
			}
			else
			{
				echo "Test failed: Add staff failed. Staff user_name=$staffUser_Name. Expected teststaff<br>";
			}

			//Update staff test:
			$sql->query("UPDATE employee_table SET name = 'newUpdateTestName' WHERE user_name = 'teststaff'");
			$staffNameRow = $sql->query("SELECT name FROM employee_table WHERE user_name='teststaff'");
			$staffName = $staffNameRow->fetch_assoc()["name"];
			if ($staffName == "newUpdateTestName")
			{
				echo "Test success: Update staff success.<br>";
			}
			else
			{
				echo "Test failed: Update staff failed. staff name=$staffName. Expected newUpdateTestName<br>";
			}

		}
		else
		{
			echo "Test failed: No staff found.<br>";
		}

		//delete staff test:
		$sql->query("DELETE FROM employee_table WHERE user_name = 'teststaff'");
		$staffDeleteRow = $sql->query("SELECT user_name FROM employee_table WHERE user_name='teststaff'");
		$countNewRows = $staffDeleteRow->num_rows;
		if ($countNewRows == 0)
		{
			echo "Test success: Delete staff success.<br>";
		}
		else
		{
			echo "Test failed: Delete staff failed.<br>";
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

		// delete staff
		$sql->query("DELETE FROM employee_table WHERE user_name='teststaff'");

		echo "<br>Cleanup completed.";
	}
?>