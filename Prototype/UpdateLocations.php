<?php
include("php-scripts/Reusable.php");

//Retrieving data
$LID = $_POST["LID"];
$LID = sanitise_input($LID);
$dropoffInput = $_POST["dropOffBox"];
$dropoffValue= isItNull($dropoffInput);
$pickupInput = $_POST["pickUpBox"];
$pickupValue =isItNull($pickupInput);

//test which button press
if(isset($_POST["deleteLocation"]))
{
	echo "<h2>True Delete</h2>";
}
if(isset($_POST["updateLocation"]))
{
	echo "<h2>True Update</h2>";
}

//connection related items
$host = "localhost";
$user = "root";
$pwd = "";
$db_msg = "";
$sql_db = "bike_hiring_system";
$conn = @mysqli_connect
	("$host",
	 "$user",
	 "$pwd",
	 "$sql_db") 
	or die
	('Failed to connect to server');


if (!$conn)
{//if connection fails
	$db_msg .= "Connection Failed, ";
	exit();
}
else
{
	//the two isset is to see which function button is clicked
	if(isset($_POST["deleteLocation"]))//delete a location that is not important
	{
		$query = "DELETE FROM `location_table` WHERE `location_table`.`location_id` = $LID;";
		$result = mysqli_query($conn,$query);
		if($result){//Data Deleted Successfully
			header("location:Locations.php");
		}
		else
		{//Delete data fail
			$db_msg .= "Deleting Data Failed";
		}
	}
	
	if(isset($_POST["updateLocation"]))//updating the checkboxes send
	{
		$query = "UPDATE `location_table` SET `drop_off_location` = '$dropoffValue', `pick_up_location` = '$pickupValue' WHERE `location_table`.`location_id` = $LID;";
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
	
	mysqli_close ($conn);// Close the database connect
}

if($db_msg!="")//this is to print if there is any errors
{
	echo"<p>$db_msg</p>";
	exit();
}
?>