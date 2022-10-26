<!--
Project Name: Inverloch Bike Hire
Project Description: A website for hiring bikes. Front-end accompanied
	   by an admin dashboard.
File Description: Show both the functions and locations information
Contributor(s):
	- Clement Cheung @ 103076376@student.swin.edu.au
	- Dabin Lee @ icelasersparr@gmail.com
	- Jake Hipworth @ 102090870@student.swin.edu.au (Navigation section and Styles)
-->
<?php
session_start();
// dashboard side menu import (Dabin)
include_once("php-scripts/dashboard-menu.php");

//Assigns the session variable used for side nav. Added by Jake Hipworth 102090870
$_SESSION["CurrentPage"] = "";
?>
<!DOCTYPE html>
<html>

<head>
	<title> Locations </title>
	<div class="flexDisplay">
		<h1 class="header"> <a href="index.php"><img src="img/photos/Inverloch_Logo3.png" alt="Inverloch Logo" id="Logo" /></a> Locations </h1>
		<a id="webpageDirect" name="webpageDirect" href='index.php'> Back to website </a>
	</div>
	<script src="scripts/FormOpenOrClose.js"></script>
	<link rel="stylesheet" href="style/popup.css">
	<link rel="stylesheet" href="style/dashboard-style.css">
	<!-- Styling unique to Locations pages-->
	<link rel="stylesheet" href="style/Location_style.css">
	<?php
	include("php-scripts/Reusable.php");
	//This is a setup to the database
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


	if (isset($_GET["search"])) {
		$search_query = $_GET["search"];
		$query = "SELECT * FROM `location_table` WHERE `name` = '$search_query';";
	} else {
		//this to select all items from the table before showing it
		$query = "SELECT * FROM `location_table`";
	}
	?>

</head>

<body>
	<div class="grid-container">
		<div class="menu">
			<?php printMenu("location"); ?>
		</div>
		<div class="main">
			<h1> Pick-Up and Drop-Off Locations </h1>

			<div class="midbar">
				<form action='UpdateLocations.php' method='POST'>
					<input type="text" name="search" placeholder="Search (Location Name)"></input>
					<button type="submit" name="search-btn"> Search </button>
				</form>
				<!-- Trigger/Open The Adding New locations PopUp -->
				<button id='LID' class='addLocationModal' name='addLocationModal' type='submit' value='LID' onclick='window.location.href="Locations.php?add=true"'>+ Add Location</button>

			</div>
			<!--This handles if the Database having an issue -->
			<div>
				<p class='error'>
					<?php
					//Idea from Jake and Aadesh
					//this is basically if there is any issues with the database while in middle of the form
					if (!empty($_GET['db_msg'])) {
						$db_msg = $_GET['db_msg'];
						echo $db_msg;
					}
					?>
				</p>
			</div>

			<!-- This handles if  the confirmation of Update, Add or Delete being a success. -->
			<div>
				<?php
				//Idea from Jake and Aadesh
				//this is basically where it starts checking if there is any success, if there is any, it will print it out onto the page that the item that the user has done is completed
				if (isset($_GET["add"])) {
					if ($_GET["add"] == "success") {
						echo "<p class='success'>New location data has successfully been added to the database</p>";
					}
				} else if (isset($_GET["delete"])) {
					if ($_GET["delete"] == "success") {
						echo "<p class='success'>Location data has been deleted successfully from the database</p>";
					}
				} else if (isset($_GET["update"])) {
					if ($_GET["update"] == "success") {
						echo "<p class='success'>Location data has been updated successfully from the database</p>";
					}
				}
				?>
			</div>


			<!-- List of locations -->
			<table class="TableContent" id="data-table">
				<!-- Location Tables Start here -->
				<tr>
					<th> Name </th>
					<th> Address </th>
					<th> Drop-Off </th>
					<th> Pick-Up </th>
					<th> Edit </th>
				</tr>
				<?php
				$result = mysqli_query($conn, $query);
				if ($result) //if the given query is a success
				{
					$record = mysqli_fetch_array($result);
					if ($record) {
						//this is basically retrieveing data and then showing it on screen
						while ($record) {
							//grabbing and putting all the data into variables or putting them together
							$fulladdress = "";
							$LID = $record['location_id'];
							$name = $record['name'];
							$name = sanitise_input($name);
							$address = $record['address'];
							$address = sanitise_input($address);
							$suburb = $record['suburb'];
							$suburb = sanitise_input($suburb);
							$postcode = $record['post_code'];
							$postcode = sanitise_input($postcode);
							$dropOff = $record['drop_off_location'];
							$pickUp = $record['pick_up_location'];
							$fulladdress = "$address,  $suburb, $postcode, Vic, Australia";

							//checking the values from database and turning it into checked so it can be shown on the interface
							$pickUpResult = checkValue($pickUp);
							$dropOffResult = checkValue($dropOff);

							//This is showing each data from database on the website interface
							echo "<tr>";
							echo "<td>$name";
							echo "</td>";
							echo "<td>$fulladdress</td>";
							echo "<td> <input type='checkbox' class='CheckBox' id='dropOffBox' name='dropOffBox' $dropOffResult onclick='return false;'> </td>";
							echo "<td> <input type='checkbox' class='CheckBox' id='pickUpBox' name='pickUpBox' $pickUpResult onclick='return false;'> </td>";
							echo "<td>
							<!-- This is to open a dropdown table -->
							<div class='dropdown'>
								<button class='dropbtn' disabled>...</button>
								<div class='dropdown-content'>
									<!-- Trigger/Open The Update PopUp -->
									<form method='POST' action='UpdateLocations.php' event.preventDefault()>
										<button id='$LID' class='updateLocationModal dropdown-element' name='updateLocationModal' type='submit' value='$LID'>Update</button>
									</form>
									
									<!-- Trigger/Open The Delete PopUp -->
									<form method='POST' action='UpdateLocations.php' event.preventDefault()>
									<input type='hidden' id='$name' class='deleteName' name='deleteName' value='$name'>
									<input type='hidden' id='$fulladdress' class='deleteAddress' name='deleteAddress' value='$fulladdress'>
										
										<button id='$LID' class='deleteLocationModal dropdown-element' name='deleteLocationModal'  type='submit' value='$LID'>Delete</button>
									</form>
								</div>
							</div>						
							</td>";
							echo "</tr>";

							//this is to move onto the next data
							$record = mysqli_fetch_assoc($result);
						}
					}
				} else //showing if there is no data or an error from database
				{
					echo "<tr>";
					echo "<td>Data</td>";
					echo "<td> Does not Exist </td>";
					echo "<td> <input type='checkbox' class='CheckBox' onclick='return false;'> </td>";
					echo "<td> <input type='checkbox' class='CheckBox' onclick='return false;'> </td>";
					echo "<td>...</td>";
					echo "</tr>";
				}
				?>
			</table>
		</div>

		<!-- All modal popups should go here -->

		<!-- Add Locations modal popup -->
		<div id="addModal" class="modal-overlay" <?php
													//this is to check if the button is selected, if thats the case, the modal popup will happen
													//Idea and code from Aadesh and Jake
													if (isset($_GET["add"]) && ($_GET["add"] == "true" || $_GET["add"] == "false")) {
														echo "style = 'display:inline-block'";
													}
													?>>

			<!-- PopUp content for adding location-->
			<div class="top5 modal-content">
				<a href="locations.php" class="close-btn">
					<span class="close-btn">&times;</span>
				</a>
				<p>
				<h2 id="addHead">Add Location</h2>
				</p>
				<form action="AddLocations.php" method="post">
					<?php
					//this is to initiate the data so if an error does come up, data would replace it
					$addname = "";
					$addaddress = "";
					$addsuburb = "";
					$addpostcode = "";
					//this is to show the data that the user has inputted
					if (($_GET["add"] == "false")
						&& ((!empty($_GET["name_msg"])) || (!empty($_GET["sub_msg"])) || (!empty($_GET["post_msg"])) || (!empty($add_msg))) 
					) {
						//this is to retrieve data from the previous page as the user has failed to pass a validation check
						$addname = $_SESSION["name"];
						$addaddress = $_SESSION["address"];
						$addsuburb = $_SESSION["suburb"];
						$addpostcode = $_SESSION["postcode"];
						$addname = sanitise_input($addname);
						$addaddress = sanitise_input($addaddress);
						$addsuburb = sanitise_input($addsuburb);
						$addpostcode = sanitise_input($addpostcode);
					}


					echo "<label for='nameInput'>Name </label><br/>
					<input type='text' placeholder='Enter Name' name='nameInput' id ='nameInput' class='inputlocation' value='$addname' required>
					<br/>";
					//this is if name has validation error
					if ($_GET["add"] == "false" && !isempty($_GET["name_msg"])) {
						$name_msg = $_GET["name_msg"];
						echo "<p class='error center'>$name_msg</p>";
					}
					echo "<br/>";

					echo "<label for='addressInput'>Address </label><br/>
					<input type='text' placeholder='Enter Address' name='addressInput' id='addressInput' class='inputlocation' value='$addaddress' required>
					<br/>";
					//this is if address has validation error
					if ($_GET["add"] == "false" && !empty($_GET["add_msg"])) {
						$add_msg = $_GET["add_msg"];
						echo "<p class='error center'>$add_msg</p>";
					}
					echo "<br/>";

					echo "<label for='suburbInput'>Suburb </label><br/>
					<input type='text' placeholder='Enter Suburb' name='suburbInput' id='suburbInput' class='inputlocation' value='$addsuburb'required>
					<br/>";

					//this is if suburb has validation error
					if ($_GET["add"] == "false" && !empty($_GET["sub_msg"])) {
						$sub_msg = $_GET["sub_msg"];
						echo "<p class='error center'>$sub_msg</p>";
					}
					echo "<br/>";


					echo "<label for='postcodeInput'>Postcode </label><br/>
					<input type='text' placeholder='Enter Postcode' name='postcodeInput' id='postcodeInput' class='inputlocation' maxlength='4' value='$addpostcode' required>
					<br/>";

					//this is if postcode has validation error
					if ($_GET["add"] == "false" && !empty($_GET["post_msg"])) {
						$post_msg = $_GET["post_msg"];
						echo "<p class='error center'>$post_msg</p>";
					}
					echo "<br/>";
					?>
					<label for="dropOffInput">Drop Off </label>
					<input type='checkbox' class='CheckBox' name="dropOffInput" id="dropOffInput" />

					<label for="pickUpInput">Pick Up </label>
					<input type='checkbox' class='CheckBox' name="pickUpInput" id="pickUpInput" />
					<br />
					<br />
					<button type="submit" name="submitLocation" id="submitLocation" class="btn top5">Add</button>
				</form>
			</div>
		</div>

		<!-- Update Locations modal popup -->
		<div id='updateModal' class='modal-overlay' <?php
													//this is to check if the button is selected, if thats the case, the modal popup will happen
													//Idea and code from Aadesh and Jake
													if ((isset($_GET["update"])) &&
														(($_GET["update"] == "true") || ($_GET["update"] == "false"))
													) {
														echo "style = 'display:inline-block'";
													}
													?>>

			<!-- Update PopUp content -->
			<div class='top5 modal-content'>
				<a href="locations.php" class="close-btn">
					<span class="close-btn">&times;</span></a>
				<p>
				<h2 id="updateHead">Update Location</h2>
				</p>
				<?php
				$LID = $_SESSION['LID'];
				//this query is searching the specific Locaction data that the user specified
				$query = "SELECT * FROM `location_table` WHERE `location_id` = $LID";
				$result = mysqli_query($conn, $query);
				if ($result) //if query success
				{
					$record = mysqli_fetch_array($result);
					//this is basically retrieveing data and then showing it on screen
					while ($record) {
						//grabbing and putting all the data into variables or putting them together
						$updateaddress = "";
						$updatename = $record['name'];
						$updatename = sanitise_input($updatename);
						$updateaddress = $record['address'];
						$updateaddress = sanitise_input($updateaddress);
						$updatesuburb = $record['suburb'];
						$updatesuburb = sanitise_input($updatesuburb);
						$updatepostcode = $record['post_code'];
						$updatepostcode = sanitise_input($updatepostcode);
						$dropOffupdate = $record['drop_off_location'];
						$pickUpUpdate = $record['pick_up_location'];

						//checking the values from database and turning it into checked so it can be shown on the interface
						$updatePickup = checkValue($pickUpUpdate);
						$updateDropoff = checkValue($dropOffupdate);

						//This is showing each data from database on the website interface
						echo "<form method='POST' action='UpdateLocations.php' >";
						echo "<input type='hidden' id='LID' name='LID' value='$LID'>";
						if (
							($_GET["update"] == "false") 
							&& ((!empty($_GET["name_msg"])) || (!empty($_GET["sub_msg"])) || (!empty($_GET["post_msg"])) || (!empty($add_msg))) 
						) {
							$updatename = $_SESSION["name"];
							$updateaddress = $_SESSION["address"];
							$updatesuburb = $_SESSION["suburb"];
							$updatepostcode = $_SESSION["postcode"];
						}

						echo "<label for='nameupdate'>Name </label><br/>
						<input type='text' name='nameupdate' id ='nameupdate' class='inputlocation' value='$updatename' required><br/>";

						//this is if name has validation error
						if ($_GET["update"] == "false" && !empty($_GET["name_msg"])) {
							$name_msg = $_GET["name_msg"];
							echo "<p class='error center'>$name_msg</p>";
						}
						echo "<br/>";

						echo "<label for='addressupdate'>Address </label><br/>
					<input type='text' placeholder='Enter Address' name='addressupdate' id='addressupdate' class='inputlocation' value='$updateaddress' required>
					<br/>";
						//this is if address has validation error
						if ($_GET["update"] == "false" && !empty($_GET["add_msg"])) {
							$add_msg = $_GET["add_msg"];
							echo "<p class='error center'>$add_msg</p>";
						}
						echo "<br/>";

						echo "<label for='suburbupdate'>Suburb </label><br/>
					<input type='text' placeholder='Enter Suburb' name='suburbupdate' id='suburbupdate' class='inputlocation' value='$updatesuburb' required>
					<br/>";

						//this is if suburb has validation error
						if ($_GET["update"] == "false" && !empty($_GET["sub_msg"])) {
							$sub_msg = $_GET["sub_msg"];
							echo "<p class='error center'>$sub_msg</p>";
						}
						echo "<br/>";

						echo "<label for='postcodeUpdate'>Postcode </label><br/>
					<input type='text' placeholder='EnterPostcode' name='postcodeUpdate' id='postcodeUpdate' class='inputlocation' maxlength='4' value='$updatepostcode' required>
					<br/>";

						//this is if postcode has validation error
						if ($_GET["update"] == "false" && !empty($_GET["post_msg"])) {
							$post_msg = $_GET["post_msg"];
							echo "<p class='error center'>$post_msg</p>";
						}
						echo "<br/>";

						echo "<label for='dropOffBox'>Drop Off Location </label>
					<input type='checkbox' class='CheckBox' id='dropOffBox' name='dropOffBox' $updateDropoff><br/>";

						echo "<label for='pickUpBox'>Pick Up Location </label>
					<input type='checkbox' class='CheckBox' id='pickUpBox' name='pickUpBox' $updatePickup> <br/><br/>";

						echo "<button type='submit' name='updateLocation' id='updateLocation' class='search-btn'>Update</button>
					</form>";

						//this is to move onto the next data
						$record = mysqli_fetch_assoc($result);
					}
				}

				?>
			</div>
		</div>

		<!--This is to confirm deleting location data from the database-->

		<!-- Confirming Delete Locations modal popup -->
		<div id='deleteModal' class='modal-overlay' <?php
													//this is to check if the button is selected, if thats the case, the modal popup will happen
													//Idea and code from Aadesh and Jake
													if (isset($_GET["delete"])) {
														if ($_GET["delete"] == "true") {
															echo "style = 'display:inline-block'";
														} else {
															echo "style = 'display:none'";
														}
													}
													?>>

			<!--This section is to have a form to Delete the location data-->
			<!-- PopUp Delete confirm content -->
			<div class='top5 modal-content'>
				<a href="locations.php" class="close-btn">
					<span class="close-btn">&times;</span></a>

				<p>
				<h2 id="deleteHead">Location Delete<br />Confirmation</h2>
				</p>
				<form method='POST' action='UpdateLocations.php' event.preventDefault()>
					<?php
					if (isset($_SESSION['LID'])) {
						$LID = $_SESSION['LID'];

						$dname = $_SESSION["name"];
						$daddress = $_SESSION["address"];
						echo "<input type='hidden' id='LID' name='LID' value='$LID'>";
						echo "<h3>Do you want to delete:</h3>";
						echo "<p>$dname</p>";
						echo "<h3>Address:</h3>";
						echo "<p>$daddress</p>";
					} else {
						echo "<h2>You are deleting nothing</h2>";
					}
					?>

					<!--This two button is mainly to show confirmation if its ok to delete the location row or not  -->
					<!--this code is borrowed and modified from Aadesh-->
					<button class="confirmationbutton" type='submit' name='deleteLocation' id='deleteLocation'>Yes</button>
					<button class="confirmationbutton" type='submit' name='cancelDeleteLocation' id='cancelDeleteLocation'>No</button>
				</form>
			</div>
		</div>
	</div>

	<?php

	//this is mainly to close off the database
	mysqli_close($conn);
	?>
</body>

</html>