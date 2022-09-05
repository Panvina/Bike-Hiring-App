<!doctype html>
<?php
include("backend-connection.php");
function sanitise_input($data){
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return($data);
	}

$nameInput = $_POST["nameInput"];
$addressInput= $_POST["addressInput"];
$suburbInput = $_POST["suburbInput"];
$postcodeInput = $_POST["postcodeInput"];
$dropoffInput = $_POST["dropOffInput"];
$pickupInput = $_POST["pickUpInput"];
echo "$nameInput, $addressInput, $suburbInput, $postcodeInput, $dropoffInput, $pickupInput";

$err_msg="";
//Name
$nameInput=sanitise_input($nameInput);
if ($nameInput=="") {
	$err_msg .= "<p>Please enter info.</p>";
}
else if (!preg_match("/^[a-zA-Z ]{2,25}$/",$nameInput)) {
	$err_msg .= "<p>Name of location can only contain max 25 alpha characters.</p>";
}

//postcodes
$postcodeInput=sanitise_input($postcodeInput);
if ($postcodeInput=="") {
	$err_msg .= "<p>Please enter Postcode.</p>";
}
else if (!preg_match('/^[0-9]{4}$/',$postcodeInput))
{
	$err_msg= "The postcode must be a 4-digit number.";
}
else if(!(substr($postcodeInput,-4,1)==3 /*&& $state=="VIC"*/)){
	$err_msg .= "<p>The postcode you enetered is not a Victorian postcode.</p>";
}


if($err_msg!=""){
	echo"<p>$err_msg</p>";
	exit();
}
		$note = "Test: ";
		$host = "localhost";
		$user = "root";
		$pwd = "";
		$sql_db = "bike_hiring_system";
		$conn = @mysqli_connect
			("$host",
			 "$user",
			 "$pwd",
			 "$sql_db") 
			or die
			('Failed to connect to server');
		if (!$conn)
		{
			$note .= "Connection Failed";
			exit();
		}
		else
		{
			$note .= "Connection Passed";
			//create table if not exists
			$query = "CREATE TABLE IF NOT EXISTS `location_table` (
			  `LocationID` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			  `Name` varchar(45) NOT NULL,
			  `Address` varchar(255) NOT NULL,
			  `Suburb` varchar(45) NOT NULL,
			  `Post Code` varchar(4) NOT NULL,
			  `Drop Off Location` tinyint(4) NOT NULL DEFAULT 0,
			  `Pick Up Location` tinyint(4) NOT NULL DEFAULT 0
			)";
			$result = mysqli_query($conn,$query);
			if($result){//create table successful
				$note .= ", Create Table Success";
				$query = "INSERT INTO `location_table` (`Name`, `Address`, `Suburb`, `Post Code`, `Drop Off Location`, `Pick Up Location`) VALUES ( '$nameInput', '$addressInput', '$suburbInput', '$postcodeInput', '0', '0'); ";
				
				$insert_result = mysqli_query ($conn, $query);
				if($insert_result){//insert successful
					$note .= ", Success Insert";
					header("location:Locations.php");
				} else {
					$note .= ", Insert  unsuccessful ";
				}
			} else {
			$db_msg .= ", Create table operation unsuccessful";
		}
		mysqli_close ($conn);					// Close the database connect
		}

?>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>
	<h2><?php echo $note?></h2>
</body>
</html>