<!--
Project Name: Inverloch Bike Hire
Project Description: A website for hiring bikes. Front-end accompanied
	   by an admin dashboard.
File Description: Show both the functions and locations information
Contributor(s):
	- Clement Cheung @ 103076376@student.swin.edu.au
	- Jake Hipworth @ 102090870@student.swin.edu.au (Navigation section and Styles)
-->
<?php
session_start();
// dashboard side menu import (Dabin)
include_once("php-scripts/dashboard-menu.php");
?>
<!DOCTYPE html>
<html>

<head>
	<title> Locations </title>
	<h1 class="header"> <a href="index.php"><img src="img/photos/Inverloch_Logo3.png" alt="Inverloch Logo" id="Logo" /></a> Locations </h1>
	<script src="scripts/FormOpenOrClose.js"></script>
	<link rel="stylesheet" href="style/Jake_Location_style.css">
	<!-- <link rel="stylesheet" href="style/LocationPop.css"> -->
	<link rel="stylesheet" href="style/popup.css">
	<link rel="stylesheet" href="style/dashboard-style.css">
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
	?>

</head>

<body>
	<div class="grid-container">
		<div class="menu">
			<?php printMenu("location"); ?>
		</div>
		<div class="main">
			<!-- Trigger/Open The add locations PopUp -->
			<form method='POST' action='AddLocations.php' event.preventDefault()>
				<h1> Pick-Up and Drop-Off Locations </h1>
				<button id='LID' class='addLocationModal' name='addLocationModal' type='submit' value='LID' style="float: right; left:0%; ">+ Add Location</button>
			</form>

			<!--This handles the confirmation of Update, Add or Delete and Database issues -->
			<div style="color: red;">
				<?php
				//Idea from Jake and Aadesh
				//this is basically if there is any issues with the database while in middle of the form
				if (!empty($_GET['db_msg'])) {
					$db_msg = $_GET['db_msg'];
					echo $db_msg;
				}
				//this is basically where it starts checking if there is any success, if there is any, it will print it out onto the page that the item that the user has done is completed
				else if (isset($_GET["add"])) {
					if ($_GET["add"] == "success") {
						echo "<p>New location data has successfully been added to the database</p>";
					}
				} else if (isset($_GET["delete"])) {
					if ($_GET["delete"] == "success") {
						echo "<p>Location data has been deleted successfully from the database</p>";
					}
				} else if (isset($_GET["update"])) {
					if ($_GET["update"] == "success") {
						echo "<p>Location data has been updated successfully from the database</p>";
					}
				}
				?>
			</div>


			<!-- List of locations -->
			<table class="TableContent" id="data-table">
				<!-- Put your table here -->
				<tr>
					<th> Name </th>
					<th> Address </th>
					<th> Drop-Off </th>
					<th> Pick-Up </th>
					<th> Edit </th>
				</tr>
				<?php
				//this to select all items from the table before showing it
				$query = "SELECT * FROM `location_table`";
				$result = mysqli_query($conn, $query);
				if ($result) //if the given query is a success
				{
					$record = mysqli_fetch_array($result);
					if ($record) {
						while ($record) //this is basically retrieveing data and then showing it on screen
						{
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
							echo "<td> <input type='checkbox' class='CheckBox' id='dropOffBox' name='dropOffBox' $dropOffResult style='width=auto;'> </td>";
							echo "<td> <input type='checkbox' class='CheckBox' id='pickUpBox' name='pickUpBox' $pickUpResult style='width=auto;'> </td>";
							echo "<td>
							<!-- This is to open a dropdown table -->
							<div class='dropdown'>
								<button class='dropbtn' disabled>...</button>
								<div class='dropdown-content'>
									<!-- Trigger/Open The Update PopUp -->
									<form method='POST' action='UpdateLocations.php' event.preventDefault()>
										<button id='$LID' style='left: 0%'  class='updateLocationModal' name='updateLocationModal' type='submit' value='$LID'>Update</button>
									</form>
									
									<!-- Trigger/Open The Delete PopUp -->
									<form method='POST' action='UpdateLocations.php' event.preventDefault()>
									<input type='hidden' id='$name' class='deleteName' name='deleteName' value='$name'>
									<input type='hidden' id='$fulladdress' class='deleteAddress' name='deleteAddress' value='$fulladdress'>
										
										<button id=$LID style='left: 0%'  class='deleteLocationModal' name='deleteLocationModal'  type='submit' value='$LID'>Delete</button>
									</form>
								</div>
							</div>						
							</td>";
							echo "</tr>";

							$record = mysqli_fetch_assoc($result); //this is to move onto the next data
						}
					}
				} else //showing if there is no data or an error from database
				{
					echo "<tr>";
					echo "<td>Data</td>";
					echo "<td> Does not Exist </td>";
					echo "<td> <input type='checkbox' class='CheckBox'> </td>";
					echo "<td> <input type='checkbox' class='CheckBox'> </td>";
					echo "<td>...</td>";
					echo "</tr>";
				}
				?>
			</table>
		</div>

		<!-- All modal popups should go here -->

		<!-- Add Locations modal popup -->
		<div id="addModal" class="modal" <?php
											//checks to see if there was any errors and if there was, it will continue to display the modal
											if (isset($_GET["add"])) {
												if ($_GET["add"] == "true") {
													echo "style = 'display:inline-block'";
												} else if ($_GET["add"] == "false") {
													echo "style = 'display:inline-block'";
												}
											}
											?>>

			<!-- PopUp content for adding location-->
			<div class="modal-content" style="margin: 5% auto;text-align: inherit;width: 17%;">
				<!--<span class="addclose" href="locations.php">&times;</span>-->
				<a href="locations.php" style="text-decoration: none;text-decoration-color:beige;">&times;</a>

				<h1 style="margin-left: 8%">Add Location</h1>

				<form action="AddLocations.php" class="form-container" method="post">
					<?php
					//this is to initiate the data so if an error does come up, data would replace it
					$addname = "";
					$addaddress = "";
					$addsuburb = "";
					$addpostcode = "";
					//this is to show if there is an error from validating codes
					if ($_GET["add"] == "false") {
						if (!empty($_GET["err_msg"])) {
							$err_msg = $_GET["err_msg"];
							echo "<div style='color: red'>$err_msg</div>";

							//this is to retrieve data from the previous page as the user has failed to pass a validation check
							$addname = $_GET["name"];
							$addaddress = $_GET["address"];
							$addsuburb = $_GET["suburb"];
							$addpostcode = $_GET["postcode"];
							$addname = sanitise_input($addname);
							$addaddress = sanitise_input($addaddress);
							$addsuburb = sanitise_input($addsuburb);
							$addpostcode = sanitise_input($addpostcode);
						}
					}


					echo "<label for='nameInput'><b>Name:</b></label>
					<input type='text' placeholder='Enter Name' name='nameInput' id ='nameInput' class='inputlocation' value='$addname' required>
					<br/>";
					echo "<label for='addressInput'><b>Address:</b></label>
					<input type='text' placeholder='Enter Address' name='addressInput' id='addressInput' class='inputlocation' value='$addaddress' required>
					<br/>";
					echo "<label for='suburbInput'><b>Suburb:</b></label>
					<input type='text' placeholder='Enter Suburb' name='suburbInput' id='suburbInput' class='inputlocation' value='$addsuburb'required>
					<br/>";
					echo "<label for='postcodeInput'><b>Postcode:</b></label>
					<input type='text' placeholder='Enter Postcode' name='postcodeInput' id='postcodeInput' class='inputlocation' maxlength='4' value='$addpostcode' required>
					<br/>"
					?>
					<label for="dropOffInput"><b>Drop Off:</b></label>
					<input type='checkbox' class='CheckBox' name="dropOffInput" id="dropOffInput" />

					<label for="pickUpInput"><b>Pick Up:</b></label>
					<input type='checkbox' class='CheckBox' name="pickUpInput" id="pickUpInput" />
					<br />
					<button type="submit" name="submitLocation" id="submitLocation" class="btn, inputlocation" style='margin-left: 12%;margin-top: 5%;'>Add Location</button>
				</form>
			</div>
		</div>

		<!-- The PopUp for update locations-->
		<div id='updateModal' class='modal' <?php
											//checks to see if there was any errors and if there was, it will continue to display the modal
											if (isset($_GET["update"])) {
												if ($_GET["update"] == "true") {
													echo "style = 'display:inline-block'";
												} else if ($_GET["update"] == "false") {
													echo "style = 'display:inline-block'";
												}
											}
											?>>

			<!-- Update PopUp content -->
			<div class='modal-content' style="margin: 5% auto;text-align: inherit;">
				<!--<span class='updateclose'>&times;</span>-->
				<a href="locations.php" class='updateclose' style="text-decoration: none;text-decoration-color:beige;">&times;</a>
				<p>
				<h1>Update Location</h1>
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

						if ($_GET["update"] == "false") {
							if (!empty($_GET["err_msg"])) {
								$err_msg = $_GET["err_msg"];
								echo "<div style='color: red'>$err_msg</div>";
							}
						}
						//This is showing each data from database on the website interface
						echo "<form method='POST' action='UpdateLocations.php' style='text-align: center;'>";
						echo "<input type='hidden' id='LID' name='LID' value='$LID'>";

						echo "<label for='nameupdate'><b>Name:</b></label>
					<input type='text' name='nameupdate' id ='nameupdate' value='$updatename' required><br/>";

						echo "<label for='addressupdate'><b>Address:</b></label>
					<input type='text' placeholder='Enter Address' name='addressupdate' id='addressupdate' class='inputlocation' value='$updateaddress' required>
					<br/>";

						echo "<label for='suburbupdate'><b>Suburb:</b></label>
					<input type='text' placeholder='Enter Suburb' name='suburbupdate' id='suburbupdate' class='inputlocation' value='$updatesuburb' required>
					<br/>";

						echo "<label for='postcodeUpdate'><b>Postcode:</b></label>
					<input type='text' placeholder='EnterPostcode' name='postcodeUpdate' id='postcodeUpdate' class='inputlocation' maxlength='4' value='$updatepostcode' required>
					<br/>";

						echo "<label for='dropOffBox'><b>Drop Off Location:</b></label>
					<input type='checkbox' class='CheckBox' id='dropOffBox' name='dropOffBox' $updateDropoff><br/>";

						echo "<label for='pickUpBox'><b>Pick Up Location:</b></label>
					<input type='checkbox' class='CheckBox' id='pickUpBox' name='pickUpBox' $updatePickup> <br/>";

						echo "<button type='submit' name='updateLocation' id='updateLocation' class='btn'>Update</button>
					</form>";

						//this is to move onto the next data
						$record = mysqli_fetch_assoc($result);
					}
				}

				?>
			</div>
		</div>

		<!--This is to confirm deleting location data from the database-->

		<!-- The PopUp for Delete item-->
		<div id='deleteModal' class='modal' <?php
											//Used to redirect back to the form once the first button has been pressed
											//Idea and code from Jake and Aadesh
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
			<div class='modal-content' style="margin: 5% auto;text-align: inherit;">
				<!--<span class='deleteclose'>&times;</span>-->
				<a href="locations.php" style="text-decoration: none;text-decoration-color:beige;">&times;</a>
				<p>
				<h1>Delete Location</h1>
				</p>
				<form method='POST' action='UpdateLocations.php' event.preventDefault()>
					<?php
					if (isset($_SESSION['LID'])) {
						$LID = $_SESSION['LID'];

						$dname = $_SESSION["name"];
						$daddress = $_SESSION["address"];
						echo "<input type='hidden' id='LID' name='LID' value='$LID'>";
						echo "<h2 style='text-align: center;height: 3%;'>You are going to delete:</h2>";
						echo "<h3 style='text-align: center;height: 3%;'>$dname</h3>";
						echo "<h2 style='text-align: center;height: 3%;'>Address:</h2>";
						echo "<h3  style='text-align: center;'>$daddress</h3>";
					} else {
						echo "<h2>You are deleting nothing</h2>";
					}
					?>

					<!--this code is borrowed and modified from Aadesh-->
					<button style='width: 40%; margin-left: 28%; position: relative;' type='submit' name='deleteLocation' id='deleteLocation'>Yes</button>
					<button style='width: 40%; margin-left: 28%; position: relative; background-color: red;' type='submit' name='cancelDeleteLocation' id='cancelDeleteLocation'>No</button>
				</form>
			</div>
		</div>
	</div>

	<?php
	mysqli_close($conn);
	?>
</body>

</html>