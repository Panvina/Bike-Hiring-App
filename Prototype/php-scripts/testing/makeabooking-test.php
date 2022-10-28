<?php

$conn = new mysqli("localhost", "root", "", "bike_hiring_system");

//Add Test Bike
$bikeTypeQuery = "INSERT INTO bike_type_table (bike_type_id, name, picture_id, description) VALUES ('999', 'BikeTypeTest', '999', 'BikeTypeTest')";
$conn->query($bikeTypeQuery);

//Add Test Bike To Inventory
$bikeAddQuery = "INSERT INTO bike_inventory_table (bike_id, name, bike_type_id, helmet_id, price_ph, safety_inspect, description) VALUES ('999', 'BikeTest','999', '2', '25', '1', 'BikeTest')";
$conn->query($bikeAddQuery);

//Add Test Location
$LocationAddQuery = "INSERT INTO location_table (location_id, name, address, suburb, post_code, drop_off_location, pick_up_location) VALUES ('999', 'LocationTest', 'LocationTest', 'LocationTest', '3000', '1', '1')";
$conn->query($LocationAddQuery);

//Add Test Accessory
$AccessoryTypeQuery = "INSERT INTO accessory_type_table (accessory_type_id, name, description) VALUES ('999', 'AccessoryTypeTest', 'AccessoryTypeTest')";
$conn->query($AccessoryTypeQuery);

//Add Test Accessory To Inventory
$AccessoryQuery = "INSERT INTO accessory_inventory_table (accessory_id, name, accessory_type_id, price_ph, safety_inspect) VALUES ('999', 'AccessoryTest', '999', '10', '1')";
$conn->query($AccessoryQuery);

try {
	//Get Bike Variables
	$bikeType = $conn->query("SELECT * FROM bike_type_table WHERE bike_type_id='999'");
    while ($row = $bikeType->fetch_assoc()) {
    	$bikeTypeId = $row["bike_type_id"];  
        $bikeName = $row["name"];
        $bikeImage = $row["picture_id"];
        $bikeDescription = $row["description"];
    }
    //Get Accessory Variables
	$accessoryType = $conn->query("SELECT * FROM accessory_type_table WHERE accessory_type_id='999'");
    while ($row = $accessoryType->fetch_assoc()) {
    	$accessoryTypeId = $row["accessory_type_id"];
        $accessoryTypeName = $row["name"];
    }
    //Get Bike Availability
    $bikeInventoryAvailable = $conn->query("SELECT bike_type_id, bike_id, price_ph FROM bike_inventory_table where bike_type_id = $bikeTypeId");
  	$bikeInventoryNum = mysqli_num_rows($bikeInventoryAvailable);
  	while ($row = $bikeInventoryAvailable->fetch_assoc()) {
  		$bikePrice = $row["price_ph"];
    }
    //Get Bike Availability Test
  	if ($bikeInventoryNum > 0)
  	{
  		echo "Success: Bike Type Recieved.<br>";
		// Get Bike Price Test
		if ($bikePrice == '25')
		{
			echo "Success: Bike Price Recieved.<br>";
		}
  	}else
  	{
  		echo "Failure: Bike Type Not Recieved.<br>";
		echo "Failure: Bike Price Not Recieved.<br>";
  	}
  	$bikeAvailable = $conn->query("SELECT bike_id FROM booking_bike_table where bike_id = '999'");
	$bikeAvailableNum = mysqli_num_rows($bikeAvailable);
	if ($bikeAvailableNum == 0)
	{
		echo "Success: Bike Availability Recieved.<br>";
	}
	else
	{
		echo "Success: Bike Availability Not Recieved.<br>";
	}
    // Get Bike ID Test
	if ($bikeTypeId == '999')
	{
		echo "Success: Bike Type ID Recieved.<br>";
	}
	else
	{
		echo "Failure: Bike Type ID Not Recieved.<br>";
	}
	// Get Bike Name Test
	if ($bikeName == 'BikeTypeTest')
	{
		echo "Success: Bike Type Name Recieved.<br>";
	}
	else
	{
		echo "Failure: Bike Type Name Not Recieved.<br>";
	}
	// Get Bike Image Test
	if ($bikeImage == '999')
	{
		echo "Success: Bike Type Picture Recieved.<br>";
	}
	else
	{
		echo "Failure: Bike Type Picture Not Recieved.<br>";
	}
	// Get Bike Description Test
	if ($bikeDescription == 'BikeTypeTest')
	{
		echo "Success: Bike Type Description Recieved.<br>";
	}
	else
	{
		echo "Failure: Bike Type Description Not Recieved.<br>";
	}
	//Get Accessory Availability
    $accessoryInventoryAvailable = $conn->query("SELECT accessory_type_id, accessory_id FROM accessory_inventory_table where accessory_type_id = $accessoryTypeId");
  	$accessoryInventoryNum = mysqli_num_rows($accessoryInventoryAvailable);
  	if ($accessoryInventoryNum > 0)
  	{
  		echo "Success: Accessory Availability Recieved.<br>";
  	}else
  	{
  		echo "Failure: Accessory Availability Not Recieved.<br>";
  	}
  	 // Get Accessory ID Test
	if ($accessoryTypeId == '999')
	{
		echo "Success: Accessory Type ID Recieved.<br>";
	}
	else
	{
		echo "Failure: Accessory Type ID Not Recieved.<br>";
	}
	// Get Accessory Name Test
	if ($accessoryTypeName == 'AccessoryTypeTest')
	{
		echo "Success: Accessory Type Name Recieved.<br>";
	}
	else
	{
		echo "Failure: Accessory Type Name Not Recieved.<br>";
	}
	//Get Locations
    $locationQuery = $conn->query("SELECT * FROM location_table where location_id = '999'");
    while ($row = $locationQuery->fetch_assoc()) {
    	$locationID = $row["location_id"];
    	$locationName = $row["name"];
        $locationPickUp = $row["pick_up_location"];
        $locationDropOff = $row["drop_off_location"];
    }
  	 // Get Location ID Test
	if ($locationID == '999')
	{
		echo "Success: Location ID Recieved.<br>";
	}
	else
	{
		echo "Failure: Location ID Not Recieved.<br>";
	}
	 // Get Location Name Test
	if ($locationName == 'LocationTest')
	{
		echo "Success: Location Name Recieved.<br>";
	}
	else
	{
		echo "Failure: Location Name Not Recieved.<br>";
	}
	// Get Location Pick Up Status Test
	if ($locationPickUp == '1')
	{
		echo "Success: Location Drop Off Status Recieved.<br>";
	}
	else
	{
		echo "Failure: Location Drop Off Status Not Recieved.<br>";
	}
	// Get Location Drop Off Status Test
	if ($locationDropOff == '1')
	{
		echo "Success: Location Pick Up Status Recieved.<br>";
	}
	else
	{
		echo "Failure: Location Pick Up Status Not Recieved.<br>";
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
	$conn->query("DELETE FROM location_table WHERE location_id='999'");
	$conn->query("DELETE FROM accessory_type_table WHERE accessory_type_id='999'");
	$conn->query("DELETE FROM accessory_inventory_table WHERE accessory_id='999'");
}
?>