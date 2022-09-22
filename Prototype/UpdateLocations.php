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
include( "php-scripts/Reusable.php" );
//this is if either buttons for update or delete location is pressed so this part of function would run
if(isset( $_POST[ "updateLocation" ] )||isset( $_POST[ "deleteLocation" ] ))
{
	//Retrieving data from the table from Locations.php
	$LID = $_POST[ "LID" ];
	$LID = sanitise_input( $LID );
	$dropoffInput = $_POST[ "dropOffBox" ];
	$dropoffValue = isItNull( $dropoffInput );
	$pickupInput = $_POST[ "pickUpBox" ];
	$pickupValue = isItNull( $pickupInput );
	$name = $_POST["nameupdate"];
	$name = sanitise_input($name); 
	$address = $_POST["addressupdate"];
	$address = sanitise_input($address);
	$suburb = $_POST["suburbupdate"];
	$suburb = sanitise_input($suburb);
	$postcode = $_POST["postcodeUpdate"];
	$postcode = sanitise_input($postcode);
	
	if(isset( $_POST[ "updateLocation" ] ))
	{
		$err_msg="";
		
		//Name valdiation
		if ( $name == "" ) 
		{
			$err_msg .= "<p>Please enter info.</p>";
		} 

		//postcodes validation
		if ( $postcode == "" ) 
		{
			$err_msg .= "<p>Please enter Postcode.</p>"; 
		}
		else if ( !preg_match( '/^[0-9]{4}$/', $postcode ) )			
		{
			$err_msg = "The postcode must be a 4-digit number.";
		}
		else if ( !( substr( $postcode, -4, 1 ) == 3 ) ) //To show this is from the state of Victoaria since Iverloch bike hire is located in Victoria
		{
			$err_msg .= "<p>The postcode you enetered is not a Victorian postcode.</p>";
		}
		
		//if there is an validation error, it would be send back to Location.php with an error message
		if ( $err_msg != "" ) {
			echo "<p>$err_msg</p>";
			header("location:Locations.php?err_msg=$err_msg&update=false");
			exit();
		}
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
	

	if ( !$conn ) //if connection fails
    { 
      $db_msg .= "<p>Connection Failed</p>";
      exit();
    } 
    else 
    {
		//the delete button is clicked
		if ( isset( $_POST[ "deleteLocation" ] ) )
		{
			//this query is to delete the location data that the admin want to remove
			$query = "DELETE FROM `location_table` WHERE `location_table`.`location_id` = $LID;";
			$result = mysqli_query( $conn, $query );
			
			//Data Deleted Successfully
			if ( $result ) 
			{ 
				header( "location:Locations.php?delete=success" );
			}
			else  //Delete data fail
			{ 
				$db_msg .= "<p>Deleting Data Failed</p>";
			}
		}
		
		//this query is to update the location data that the admin want to update
		if(isset($_POST["updateLocation"]))//updating the checkboxes send
		{
			//this is to make sure that any extra special characters when added to the database is possible
			$name = mysqli_real_escape_string($conn, $name);  
			$address= mysqli_real_escape_string($conn, $address);
			
			//this is setup and then update the location data from location database
			$query = "UPDATE `location_table` SET `name` = '$name', `address` = '$address', `suburb` = '$suburb', `post_code` = '$postcode', `drop_off_location` = '$dropoffValue', `pick_up_location` = '$pickupValue' WHERE `location_table`.`location_id` = '$LID';";
            $result = mysqli_query($conn,$query);
			if($result)
			{//Data Updated Successfully
    			header("location:Locations.php?update=success");
            }
            else
            {//Data Update Fail
                $db_msg .="Data has fail to update";
            }
		}
		
		// Close the database connect
		mysqli_close( $conn ); 
	}


	//this is to print if there is any errors
	if ( $db_msg != "" )
	{
		echo "Database connection issue: $db_msg";
		$db_msg= "<p>Database connection issue: $db_msg</p>";
    	header("location:Locations.php?db_msg=$db_msg");
		exit();
    }
}


//this is so that the Update and delete modal can appear
if(isset($_POST["updateLocationModal"]))
{
	//this is to also set the location chosen
	$LID = $_POST["updateLocationModal"];
	$_SESSION["LID"] = $LID;	
	//This is so code know that the update need to popup
	header("location:Locations.php?update=true");
}

if(isset($_POST["deleteLocationModal"]))
{
	//this is to also set the location chosen
	$LID = $_POST["deleteLocationModal"];
	$_SESSION["LID"] = $LID;
	//This is so code know that the delete need to popup
	header("location:Locations.php?delete=true");
}

//this is if the admin do not want to delete location
if(isset($_POST["cancelDeleteLocation"]))
{
	//This is so code know that the delete need to popup
	header("location:Locations.php");
}
?>