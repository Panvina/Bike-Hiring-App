<?php

$conn = new mysqli("localhost", "root", "", "bike_hiring_system");

//Add Test Bike
$bikeTypeQuery = "INSERT INTO bike_type_table (bike_type_id, name, picture_id, description) VALUES ('999', 'BikeTypeTest', '999', 'BikeTypeTest')";
$conn->query($bikeTypeQuery);

//Add Test Bike To Inventory
$bikeAddQuery = "INSERT INTO bike_inventory_table (bike_id, name, bike_type_id, helmet_id, price_ph, safety_inspect, description) VALUES ('999', 'BikeTest','999', '2', '25', '1', 'BikeTest')";
$conn->query($bikeAddQuery);

//Add Test Account 
$accountQuery = "INSERT INTO accounts_table (user_name, role_id, password) VALUES ('bookingtest@test.com', '3', 'testpassword')";
$conn->query($accountQuery);

//Add Test Customer 
$accountQuery = "INSERT INTO customer_table (user_name, name, phone_number, email, street_address, suburb, post_code, licence_number, state) VALUES ('bookingtest@test.com', 'Test Name', '999999999', 'bookingtest@test.com', 'test street', 'test', '3000', '99999999', 'VIC')";
$conn->query($accountQuery);

//Add Test Booking 
$bookingQuery = "INSERT INTO booking_table (booking_id, user_name, start_date, end_date, start_time, expected_end_time, duration_of_booking, pick_up_location, drop_off_location, booking_fee) VALUES ('999', 'bookingtest@test.com', '2022-01-01', '2022-01-02', '09:00:00', '12:00:00', '3', '100', '100', '100')";
$conn->query($bookingQuery);

//Add Test Bike Booking
$bookingBikeQuery = "INSERT INTO booking_bike_table (booking_bike_id, booking_id, bike_id) VALUES ('999', '999', '999')";
$conn->query($bookingBikeQuery);

try {
	//Get Booking Variables
	$bikeType = $conn->query("SELECT * FROM booking_table WHERE booking_id='999'");
    while ($row = $bikeType->fetch_assoc()) {
    	$bookingID = $row["booking_id"];  
    }
    //Get Inventory Variables
	$bikeType = $conn->query("SELECT * FROM booking_bike_table WHERE booking_bike_id='999'");
    while ($row = $bikeType->fetch_assoc()) {
    	$bookingBikeID = $row["booking_bike_id"];  
    	$bikeID = $row["bike_id"];  
    }
    // Get Booking Confirmation Test
	if ($bookingID == '999')
	{
		echo "Success: Booking Confirmation Recieved.<br>";
	}
	else
	{
		echo "Failure: Booking Confirmation Not Recieved.<br>";
	}
	// Get Inventory Confirmation Test
	if ($bikeID == '999')
	{
		echo "Success: Inventory Confirmation Recieved.<br>";
	}
	else
	{
		echo "Failure: Inventory Confirmation Not Recieved.<br>";
	}
}
catch (Exception $e) {
	// Catch Exceptions
	$msg = $e->getMessage();
	echo "<br>$msg";
}
finally {
	// Clean Up
	$conn = new mysqli("localhost", "root", "", "bike_hiring_system");
	$conn->query("DELETE FROM bike_inventory_table WHERE bike_type_id='999'");
	$conn->query("DELETE FROM bike_type_table WHERE bike_type_id='999'");
	$conn->query("DELETE FROM accounts_table WHERE user_name ='bookingtest@test.com'");
	$conn->query("DELETE FROM customer_table WHERE user_name ='bookingtest@test.com'");
	$conn->query("DELETE FROM booking_bike_table WHERE booking_bike_id ='999'");
	$conn->query("DELETE FROM booking_table WHERE booking_id='999'");
}
?>