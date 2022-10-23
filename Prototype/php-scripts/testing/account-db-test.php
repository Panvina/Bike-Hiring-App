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
	$conn = new DBConnection("accounts_table");
	$sql = new mysqli("localhost", "root", "", "bike_hiring_system");

	// add customer
	$accountQuery = "INSERT INTO accounts_table (user_name,role_id,password) VALUES ('testaccount',1,'0123456789')";
	$sql->query($accountQuery);

	try {
		// Add account test:
		// check account exists after adding
		$accountRow = $sql->query("SELECT user_name FROM accounts_table WHERE user_name='testaccount'");
		$countRows = $accountRow->num_rows;
		if ($countRows == 1) {
			$accountUser_Name = $accountRow->fetch_assoc()["user_name"];

			if ($accountUser_Name == 'testaccount')
			{
				echo "Test success: Add account success.<br>";
			}
			else
			{
				echo "Test failed: Add account failed. Staff user_name=$accountUser_Name. Expected testaccount<br>";
			}

			//Update account test:
			$sql->query("UPDATE accounts_table SET password = '9876543210' WHERE user_name = 'testaccount'");
			$accountPasswordRow = $sql->query("SELECT password FROM accounts_table WHERE user_name='testaccount'");
			$accountPassword = $accountPasswordRow->fetch_assoc()["password"];
			if ($accountPassword == "9876543210")
			{
				echo "Test success: Update account success.<br>";
			}
			else
			{
				echo "Test failed: Update account failed. staff password=$accountPassword. Expected 9876543210<br>";
			}

		}
		else
		{
			echo "Test failed: No account found.<br>";
		}

		//delete account test:
		$sql->query("DELETE FROM accounts_table WHERE user_name = 'testaccount'");
		$accountDeleteRow = $sql->query("SELECT user_name FROM accounts_table WHERE user_name='testaccount'");
		$countNewRows = $accountDeleteRow->num_rows;
		if ($countNewRows == 0)
		{
			echo "Test success: Delete account success.<br>";
		}
		else
		{
			echo "Test failed: Delete account failed.<br>";
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

		// delete account
		$sql->query("DELETE FROM accounts_table WHERE user_name='testaccount'");

		echo "<br>Cleanup completed.";
	}
?>