<!--
Project Name: Inverloch Bike Hire
Project Description: A website for hiring bikes. Front-end accompanied
	   by an admin dashboard.
File Description: This is to both validate and add location data into the database
Contributor:
	- Clement Cheung @ 103076376@student.swin.edu.au
-->
<!-- This page is completely done by Clement -->
<!doctype html>
<?php
include( "php-scripts/Reusable.php" );

//this area is where the data is retrieved from the form and the initial sanitisation of code happens
$nameInput = $_POST[ "nameInput" ];
$nameInput = sanitise_input( $nameInput );
$addressInput = $_POST[ "addressInput" ];
$addressInput = sanitise_input( $addressInput );
$suburbInput = $_POST[ "suburbInput" ];
$suburbInput = sanitise_input( $suburbInput );
$postcodeInput = $_POST[ "postcodeInput" ];
$postcodeInput = sanitise_input( $postcodeInput );
$dropoffInput = $_POST[ "dropOffInput" ];
$dropoffValue = isItNull( $dropoffInput );
$pickupInput = $_POST[ "pickUpInput" ];
$pickupValue = isItNull( $pickupInput );
echo "$nameInput, $addressInput, $suburbInput, $postcodeInput, DropOffInput:$dropoffInput, PickUpInput:$pickupInput, DropOffValue: $dropoffValue, PickUpValue: $pickupValue";

$err_msg = "";
//Name valdiation
$nameInput = sanitise_input( $nameInput );
if ( $nameInput == "" ) {
  $err_msg .= "<p>Please enter info.</p>";
} else if ( !preg_match( "/^[a-zA-Z ]{2,25}$/", $nameInput ) ) {
  $err_msg .= "<p>Name of location can only contain max 25 alpha characters.</p>";
}

//postcodes validation
$postcodeInput = sanitise_input( $postcodeInput );
if ( $postcodeInput == "" ) {
  $err_msg .= "<p>Please enter Postcode.</p>";
} else if ( !preg_match( '/^[0-9]{4}$/', $postcodeInput ) ) {
  $err_msg = "The postcode must be a 4-digit number.";
} else if ( !( substr( $postcodeInput, -4, 1 ) == 3 ) ) //To show this is from the state of Victoaria since Iverloch bike hire is located in Victoria
{
  $err_msg .= "<p>The postcode you enetered is not a Victorian postcode.</p>";
}

//setting up and connecting to DB
if ( $err_msg != "" ) {
  echo "<p>$err_msg</p>";
  exit();
}

$db_msg = "";
$host = "localhost";
$user = "root";
$pwd = "";
$sql_db = "bike_hiring_system";
$conn = @mysqli_connect( "$host",
  "$user",
  "$pwd",
  "$sql_db" )
or die
  ( 'Failed to connect to server' );
if ( !$conn ) {
  $db_msg .= "Connection Failed";
  exit();
} else {
  $db_msg .= "Connection Passed";
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

  $result = mysqli_query( $conn, $query );
  if ( $result ) { //create table successful
    $query = "INSERT INTO `location_table` (`name`, `address`, `suburb`, `post_code`, `drop_off_location`, `pick_up_location`) VALUES ( '$nameInput', '$addressInput', '$suburbInput', '$postcodeInput', '$dropoffValue', '$pickupValue'); ";
    $insert_result = mysqli_query( $conn, $query );
    if ( $insert_result ) { //insert successful
      $db_msg .= ", Success Insert";
      header( "location:Locations.php" );
    } else { //if insert data into database fail
      $db_msg .= ", Insert  unsuccessful ";
    }
  } else {
    $db_msg .= ", Create table operation unsuccessful";
  }
  mysqli_close( $conn ); // Close the database connect
}

if ( $db_msg != "" ) //this is to print if there is any errors
{
  echo "<p>$db_msg</p>";
}
?>