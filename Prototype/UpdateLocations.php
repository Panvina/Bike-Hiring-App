<!--
Project Name: Inverloch Bike Hire
Project Description: A website for hiring bikes. Front-end accompanied
	   by an admin dashboard.
File Description: This is to either update or delete location data
Contributor:
	- Clement Cheung @ 103076376@student.swin.edu.au
-->
<!-- This page is completely done by Clement -->
<?php

session_start();
include("php-scripts/Reusable.php");
//this is if either buttons for update or delete location is pressed so this part of function would run
if (isset($_POST["updateLocation"]) || isset($_POST["deleteLocation"])) {
	//Retrieving data from the table from Locations.php
	$LID = $_POST["LID"];
	$LID = sanitise_input($LID);
	$dropoffInput = $_POST["dropOffBox"];
	$dropoffValue = isItNull($dropoffInput);
	$pickupInput = $_POST["pickUpBox"];
	$pickupValue = isItNull($pickupInput);
	$name = $_POST["nameupdate"];
	$name = sanitise_input($name);
	$address = $_POST["addressupdate"];
	$address = sanitise_input($address);
	$suburb = $_POST["suburbupdate"];
	$suburb = sanitise_input($suburb);
	$postcode = $_POST["postcodeUpdate"];
	$postcode = sanitise_input($postcode);

	//This is to make sure if the location button is selected and this section of code is mainly validations
	if (isset($_POST["updateLocation"])) {
		$name_msg = "";
		$post_msg = "";
		$suburb_msg = "";


		//Name valdiation
		if ($name == "") {
			$name_msg .= "Please enter info.";
		}

		//postcodes validation
		if ($postcode == "") {
			$post_msg .= "Please enter Postcode.";
		} else if (!preg_match('/^\d{4}$/', $postcode)) {
			$post_msg = "The postcode must be a 4-digit number.";
		} else if ((substr($postcode, -4, 1) != 3)) //To show this is from the state of Victoaria since Iverloch bike hire is located in Victoria
		{
			$post_msg .= "The postcode you enetered is not a Victorian postcode.";
		}

		//Suburb valdiation
		$suburb = sanitise_input($suburb);
		if ($suburb == "") {
			$suburb_msg .= "Please enter address.";
		} else if (!preg_match("/^[a-zA-Z',.\s-]{1,25}$/", $suburb)) {
			$suburb_msg .= "Suburb of location can only contain alpha characters.";
		}


		//if there is an validation error, it would be send back to Location.php with an error message
		if (($name_msg != "") || ($post_msg != "") || ($suburb_msg != "")) {
			$_SESSION["LID"] = $LID;
			$_SESSION["name"] = $name;
			$_SESSION["address"] = $address;
			$_SESSION["suburb"] = $suburb;
			$_SESSION["postcode"] = $postcode;
			header("location:Locations.php?update=false&name_msg=$name_msg&post_msg=$post_msg&sub_msg=$suburb_msg");
			exit();
		}
	}

	//connection to database
	$host = "localhost";
	$user = "root";
	$pwd = "";
	$db_msg = "";
	$sql_db = "bike_hiring_system";
	$conn = @mysqli_connect(
		"$host",
		"$user",
		"$pwd",
		"$sql_db"
	)
		or die('Failed to connect to server');


	if (!$conn) //if connection fails
	{
		$db_msg .= "<p>Connection Failed</p>";
		exit();
	} else {
		//This function is to delete location data/row from the database
		//the delete button is clicked
		if (isset($_POST["deleteLocation"])) {
			//this query is to delete the location data that the admin want to remove
			$query = "DELETE FROM `location_table` WHERE `location_table`.`location_id` = $LID;";
			$result = mysqli_query($conn, $query);

			//Data Deleted Successfully
			if ($result) {
				header("location:Locations.php?delete=success");
			} else  //Delete data fail
			{
				$db_msg .= "<p>Deleting Data Failed</p>";
			}
		}

		//This function is to update the location data that the admin want to update
		//The button to update location is click send
		if (isset($_POST["updateLocation"])) {
			//this is to make sure that any extra special characters when added to the database is possible
			$name = mysqli_real_escape_string($conn, $name);
			$address = mysqli_real_escape_string($conn, $address);

			//this is setup and then update the location data from location database
			$query = "UPDATE `location_table` SET `name` = '$name', `address` = '$address', `suburb` = '$suburb', `post_code` = '$postcode', `drop_off_location` = '$dropoffValue', `pick_up_location` = '$pickupValue' WHERE `location_table`.`location_id` = '$LID';";
			$result = mysqli_query($conn, $query);
			if ($result) { //Data Updated Successfully
				header("location:Locations.php?update=success");
			} else { //Data Update Fail
				$db_msg .= "Data has fail to update";
			}
		}

		// Close the database connect
		mysqli_close($conn);
	}


	//This is to send back to Location page if there is any database error
	if ($db_msg != "") {
		echo "Database connection issue: $db_msg";
		$db_msg = "<p>Database connection issue: $db_msg</p>";
		header("location:Locations.php?db_msg=$db_msg");
		exit();
	}
}


//this is so that the Update and delete modal can appear
//idea and modification from this last section is from Aadesh and Jake
if (isset($_POST["updateLocationModal"])) {
	//this is to also set the location chosen
	$LID = $_POST["updateLocationModal"];
	$_SESSION["LID"] = $LID;
	//This is so code know that the update need to popup
	header("location:Locations.php?update=true");
}

if (isset($_POST["deleteLocationModal"])) {
	//this is to also set the location chosen
	$LID = $_POST["deleteLocationModal"];
	$_SESSION["LID"] = $LID;
	$lName = $_POST['deleteName'];
	$lAddress = $_POST['deleteAddress'];
	$_SESSION["name"] = $lName;
	$_SESSION["address"] = $lAddress;
	//This is so code know that the delete need to popup
	header("location:Locations.php?delete=true");
}

//this is if the admin do not want to delete location
if (isset($_POST["cancelDeleteLocation"])) {
	//This is so code know that the delete need to popup
	header("location:Locations.php");
}

//This is the search functionality
//Search concept adapted from Alex and Addesh
if (isset($_POST['search-btn'])) {
	$search = $_POST["search"];
	$search = sanitise_input($search);

	if ($search != "") {
		header("Location: Locations.php?search=$search");
	} else {
		header("Location: Locations.php");
	}
}
?>