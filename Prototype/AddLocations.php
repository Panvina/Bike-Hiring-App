<!--
Project Name: Inverloch Bike Hire
Project Description: A website for hiring bikes. Front-end accompanied
	   by an admin dashboard.
File Description: This is to both validate and add location data into the database
Contributor:
	- Clement Cheung @ 103076376@student.swin.edu.au
-->
<!-- This page is completely done by Clement -->
<?php

session_start();
include("php-scripts/Reusable.php");


// This is if the adding of new location code
if (isset($_POST["submitLocation"])) {
	//this area is where the data is retrieved from the form and the initial sanitisation of code happens
	$nameInput = $_POST["nameInput"];
	$nameInput = sanitise_input($nameInput);
	$addressInput = $_POST["addressInput"];
	$addressInput = sanitise_input($addressInput);
	$suburbInput = $_POST["suburbInput"];
	$suburbInput = sanitise_input($suburbInput);
	$postcodeInput = $_POST["postcodeInput"];
	$postcodeInput = sanitise_input($postcodeInput);
	$dropoffInput = $_POST["dropOffInput"];
	$dropoffValue = isItNull($dropoffInput);
	$pickupInput = $_POST["pickUpInput"];
	$pickupValue = isItNull($pickupInput);


	//This section is mainly dealing with validation items
	$name_msg = "";
	$post_msg = "";
	$suburb_msg = "";

	//Name valdiation
	if ($nameInput == "") {
		$name_msg .= "Please enter info.";
	}
	//else if ( !preg_match( "/^[a-zA-Z ]{2,25}$/", $nameInput ) ) {
	//  $name_msg .= "Name of location can only contain max 25 alpha characters.";}

	//postcodes validation
	if ($postcodeInput == "") {
		$post_msg .= "Please enter Postcode.";
	} else if (!preg_match('/^\d{4}$/', $postcodeInput)) {
		$post_msg = "The postcode must be a 4-digit number.";
	} else if ((substr($postcodeInput, -4, 1) != 3)) //To show this is from the state of Victoaria since Iverloch bike hire is located in Victoria
	{
		$post_msg .= "The postcode you enetered is not a Victorian postcode.";
	}

	//Suburb valdiation
	$suburbInput = sanitise_input($suburbInput);
	if ($suburbInput == "") {
		$suburb_msg .= "Please enter address.";
	} else if (!preg_match("/^[a-zA-Z',.\s-]{1,25}$/", $suburbInput)) {
		$suburb_msg .= "Suburb of location can only contain alpha characters.";
	}


	//if there is an validation error, it would be send back to Location.php with an error message
	if (($name_msg != "") || ($post_msg != "") || ($suburb_msg != "")) {
		$_SESSION["name"] = $nameInput;
		$_SESSION["address"] = $addressInput;
		$_SESSION["suburb"] = $suburbInput;
		$_SESSION["postcode"] = $postcodeInput;
		header("location:Locations.php?add=false&name_msg=$name_msg&post_msg=$post_msg&sub_msg=$suburb_msg");
		exit();
	}


	//This section manages adding new data to database
	//setting up and connecting to DB
	$db_msg = "";
	$host = "localhost";
	$user = "root";
	$pwd = "";
	$sql_db = "bike_hiring_system";
	$conn = @mysqli_connect(
		"$host",
		"$user",
		"$pwd",
		"$sql_db"
	)
		or die('Failed to connect to server');
	if (!$conn) {
		$db_msg .= "Connection Failed";
		exit();
	} else {
		//create table if not exists
		$query = "CREATE TABLE IF NOT EXISTS `location_table` (
             `location_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
             `name` varchar(45) NOT NULL,
             `address` varchar(255) NOT NULL,
             `suburb` varchar(45) NOT NULL,
             `post_code` varchar(4) NOT NULL,
             `drop_off_location` tinyint(1) NOT NULL DEFAULT 0,
             `pick_up_location` tinyint(1) NOT NULL DEFAULT 0
             )";


		//this is to make sure that any extra special characters when added to the database is possible
		$addressInput = mysqli_real_escape_string($conn, $addressInput);
		$nameInput = mysqli_real_escape_string($conn, $nameInput);

		//this is to set the query before executing it
		$result = mysqli_query($conn, $query);
		//create table successful
		if ($result) {
			$query = "INSERT INTO `location_table` (`name`, `address`, `suburb`, `post_code`, `drop_off_location`, `pick_up_location`) VALUES ( '$nameInput', '$addressInput', '$suburbInput', '$postcodeInput', '$dropoffValue', '$pickupValue'); ";
			$insert_result = mysqli_query($conn, $query);
			//if adding new location to database is successful
			if ($insert_result) {
				header("location:Locations.php?add=success");
				exit();
			} else //if insert data into database fail
			{
				$db_msg .= ", Insert  unsuccessful ";
			}
		} else {
			$db_msg .= ", Create table operation unsuccessful";
		}
		// Close the database connect
		mysqli_close($conn);
	}

	//This is to send back to the Location.php if there is any database error
	if ($db_msg != "") {
		echo "<p>Add Database eroors: $db_msg</p>";
		$db_msg = "<p>Location Database errors: $db_msg</p>";
		header("location:Locations.php?db_msg=$db_msg");
		exit();
	}
}
?>