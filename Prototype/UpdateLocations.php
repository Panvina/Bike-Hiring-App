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
include( "php-scripts/Reusable.php" );
//this is to spit the address into seperate sections
function commansplit($data)
{
	$pieces = explode(",",$data);
	return $pieces;
}

//Retrieving data from the table from Locations.php
$LID = $_POST[ "LID" ];
$LID = sanitise_input( $LID );
$dropoffInput = $_POST[ "dropOffBox" ];
$dropoffValue = isItNull( $dropoffInput );
$pickupInput = $_POST[ "pickUpBox" ];
$pickupValue = isItNull( $pickupInput );
$name = $_POST["nameupdate"];
$name = sanitise_input($name); 
$completeaddress = $_POST["fulladdress"];
$completeaddress = sanitise_input($completeaddress);
$splitaddress = commansplit($completeaddress);
$address = $splitaddress[0];
$suburb = $splitaddress[1];
$postcode = $splitaddress[2];

//test which button press
if ( isset( $_POST[ "deleteLocation" ] ) ) {
  echo "<h2>True Delete</h2>";
}
if ( isset( $_POST[ "updateLocation" ] ) ) {
  echo "<h2>True Update</h2>";
}

//connection to database
$host = "localhost";
$user = "root";
$pwd = "";
$db_msg = "";
$sql_db = "bike_hiring_system";
$conn = @mysqli_connect( "$host",
  "$user",
  "$pwd",
  "$sql_db" )
or die
  ( 'Failed to connect to server' );


if ( !$conn ) { //if connection fails
  $db_msg .= "Connection Failed, ";
  exit();
} else {
  //the two isset is to see which function button is clicked
  if ( isset( $_POST[ "deleteLocation" ] ) ) //delete a location that is not important
  {
    //this query is to delete the location data that the admin want to remove
    $query = "DELETE FROM `location_table` WHERE `location_table`.`location_id` = $LID;";
    $result = mysqli_query( $conn, $query );
    if ( $result ) { //Data Deleted Successfully
      header( "location:Locations.php" );
    } else { //Delete data fail
      $db_msg .= "Deleting Data Failed";
    }
  }
  //this query is to update the location data that the admin want to update

  if(isset($_POST["updateLocation"]))//updating the checkboxes send
	{
		$query = "UPDATE `location_table` SET `name` = '$name', `address` = '$address', `suburb` = '$suburb', `post_code` = '$postcode', `drop_off_location` = '$dropoffValue', `pick_up_location` = '$pickupValue' WHERE `location_table`.`location_id` = '$LID';";
		// $query = "UPDATE `location_table` SET `name` = '$name', `drop_off_location` = '$dropoffValue', `pick_up_location` = '$pickupValue' WHERE `location_table`.`location_id` = '$LID';";
		$result = mysqli_query($conn,$query);
		if($result)
		{//Data Updated Successfully
			header("location:Locations.php");//this is to redirect if success
		}
		else
		{//Data Update Fail
			$db_msg .="Data has fail to update";
		}
	}

  mysqli_close( $conn ); // Close the database connect
}

if ( $db_msg != "" ) //this is to print if there is any errors
{
  echo "<p>$db_msg</p>";
  exit();
}
?>