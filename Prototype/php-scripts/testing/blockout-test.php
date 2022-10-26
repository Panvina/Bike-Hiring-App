<?php

$conn = new mysqli("localhost", "root", "", "bike_hiring_system");

//Add Test Bike
$blockoutQuery = "INSERT INTO block_out_dates (date_id, date_value, date_day, date_month, date_year, date_blockout, date_reason, date_day_name ) VALUES ('999', '2022-01-01', '999', '999', '999', '1', '999', '999' )";
$conn->query($blockoutQuery);

try {
	//Get Block Out Date Variables
	$blockoutTest = $conn->query("SELECT * FROM block_out_dates WHERE date_id='999'");
    while ($row = $blockoutTest->fetch_assoc()) {
    	$date_id = $row["date_id"];  
    	$date_value = $row["date_value"];  
    	$date_day = $row["date_day"];  
    	$date_month = $row["date_month"];  
    	$date_year = $row["date_year"];  
    	$date_day_name = $row["date_day_name"]; 
    	$date_blockout = $row["date_blockout"];   
    }
   // Get Block Out Date ID Test
	if ($date_id == '999')
	{
		echo "Success: Block Out Date Recieved.<br>";
	}
	else
	{
		echo "Failure: Block Out Date Not Recieved.<br>";
	}
	// Get  Block Out Date Value Test
	if ($date_value == '2022-01-01')
	{
		echo "Success: Block Out Date Value Recieved.<br>";
	}
	else
	{
		echo "Failure: Block Out Date Value Not Recieved.<br>";
	}
	// Get  Block Out Date Day Test
	if ($date_day == '999')
	{
		echo "Success: Block Out Date Day Recieved.<br>";
	}
	else
	{
		echo "Failure: Block Out Date Day Not Recieved.<br>";
	}
	// Get  Block Out Date Month Test
	if ($date_month == '999')
	{
		echo "Success: Block Out Date Month Recieved.<br>";
	}
	else
	{
		echo "Failure: Block Out Date Month Not Recieved.<br>";
	}
	// Get  Block Out Date Year Test
	if ($date_year == '999')
	{
		echo "Success: Block Out Date Year Recieved.<br>";
	}
	else
	{
		echo "Failure: Block Out Date Year Not Recieved.<br>";
	}
	// Get  Block Out Date Day Name Test
	if ($date_day_name == '999')
	{
		echo "Success: Block Out Date Day Name Recieved.<br>";
	}
	else
	{
		echo "Failure: Block Out Date Day Name Not Recieved.<br>";
	}
	// Get  Block Out Date Status Test
	if ($date_blockout == '1')
	{
		echo "Success: Block Out Date Status Recieved.<br>";
	}
	else
	{
		echo "Failure: Block Out Date Status Not Recieved.<br>";
	}
	// Change Block Out Status
	$blockoutChangeQuery = "UPDATE block_out_dates SET date_blockout = 0 WHERE date_id = '999'";
	$conn->query($blockoutChangeQuery);

	$blockoutTest2 = $conn->query("SELECT * FROM block_out_dates WHERE date_id='999'");
    while ($row = $blockoutTest2->fetch_assoc()) { 
    	$date_blockout2 = $row["date_blockout"];   
    }
    // Get  Block Out Date Changed Status Test
	if ($date_blockout2 == '0')
	{
		echo "Success: Block Out Date Status Successfully Changed.<br>";
	}
	else
	{
		echo "Failure: Block Out Date Status Unsuccessfully Changed.<br>";
	}

}
catch (Exception $e) {
	// Catch Exceptions
	$msg = $e->getMessage();
	echo "<br>$msg";
}
finally {
	//Clean Up
	$conn = new mysqli("localhost", "root", "", "bike_hiring_system");
	$conn->query("DELETE FROM block_out_dates WHERE date_id='999'");
}
?>