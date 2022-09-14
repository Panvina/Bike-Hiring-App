<!--
Project Name: Inverloch Bike Hire
Project Description: A website for hiring bikes. Front-end accompanied
	   by an admin dashboard.
File Description: Show both the functions and locations information
Contributor(s):
	- Clement Cheung @ 103076376@student.swin.edu.au
	- Jake Hipworth @ 102090870@student.swin.edu.au (Navigation section and Styles)
-->
<?php if(!isset($_SESSION)){ 
        session_start();     
    }
	?>
<!DOCTYPE html>
<html>
	<head>
		<title> Locations </title>
		<h1 class="header"> <img src="img/photos/Inverloch_Logo3.png" alt="Inverloch Logo" id="Logo"/> Locations </h1>
		
		<script src="scripts/FormOpenOrClose.js"></script>
		<script>
				/* When the user clicks on the button, 
toggle between hiding and showing the dropdown content - By Clement */
			function myFunction() {
				document.getElementById("myDropdown").classList.toggle("show");
			}
</script>
		<link rel="stylesheet" href="style/Jake_Location_style.css">
		<link rel="stylesheet" href="style/LocationPop.css">
		<link rel="stylesheet" href="style/dropdownboxcss.css">
		<?php
		// Setting up Database and connecting to reusable file where there are functions which can be reused
		// Section coded by Clement
		include("php-scripts/Reusable.php");
		
		//setting up and connecting to DB
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
		?>
		
	</head>
	<body>
		<nav>
			<!--Navigation area Done by Jake-->
			<div class = "sideNavigation">
				<a href = "Dashboard.php"> <img src= "img/icons/bulletin-board.png" alt="Dashboard Logo" /> Dashboard </a> <br>
				<a href = "Customer.php"> <img src= "img/icons/account-group.png" alt="Customer Logo" />  Customer  </a> <br>
				<?php if ($_SESSION["login-type"] == "owner"){
                        echo "<a href='staff.php'> <img src='img/icons/staff.png' alt='Staff Logo' /> Staff </a> <br>";} ?>
				<a href= "Inventory.php"> <img src= "img/icons/bicycle.png" alt="Inventory Logo" />  Inventory </a> <br>
				<a href="Accessory.php"> <img src="img/icons/accessories.png" alt="Inventory Logo" /> Accessories </a> <br>
				<a href= "Bookings.php"> <img src= "img/icons/book-open-blank-variant.png" alt="Bookings Logo" /> Bookings </a> <br>
				<a href= "Block_Out_Date.php"> <img src= "img/icons/calendar.png" alt="Block out date Logo" /> Block Out Dates </a> <br>
				<a class="active" href= "Locations.php"> <img src= "img/icons/earth.png" alt="Locations Logo" /> Locations </a> <br>
			</div>
		</nav>
		
		<!-- This section is done by Clement and it is for Adding Locations and have it pop up when clicking a button.  -->
		<div class="Content"> 
			<h1> Pick-Up & Drop-Off Locations </h1>
			
			<!-- Trigger/Open The PopUp -->
			<button id="myBtn" style="left: 0%"  class="open-button" type="button">+ Add Location</button>
			
			<!-- The PopUp -->
			<div id="myModal" class="modal">
				
				<!-- PopUp content -->
				<div class="modal-content">
					<span class="close">&times;</span>
					<form action="AddLocations.php" class="form-container" method="post">
						<p>
						<h1>Add Location</h1>
						</p>
					<label for="nameInput"><b>Name:</b></label>
					<input type="text" placeholder="Enter Name" name="nameInput" id ="nameInput" class="inputlocation" required>
					<br/>
					<label for="addressInput"><b>Address:</b></label>
					<input type="text" placeholder="Enter Address" name="addressInput" id="addressInput" class="inputlocation" required>
					<br/>
					<label for="suburbInput"><b>Suburb:</b></label>
					<input type="text" placeholder="Enter Suburb" name="suburbInput" id="suburbInput" class="inputlocation" required>
					<br/>
					<label for="postcodeInput"><b>Postcode:</b></label>
					<input type="text" placeholder="Enter Postcode" name="postcodeInput" id="postcodeInput" class="inputlocation" maxlength="4" required>
					
					<label for="postcodeInput"><b>Drop Off:</b></label> 
					<input type='checkbox' class='CheckBox' name="dropOffInput" id="dropOffInput"/>
					
					<label for="postcodeInput"><b>Pick Up:</b></label> 
					<input type='checkbox' class='CheckBox' name="pickUpInput" id="pickUpInput"/>
					<br/>
					<button type="submit" name="submitLocation" id="submitLocation" class="btn, inputlocation">submit</button>
					</form>
			</div>
		</div>
		<!-- This section is done by Clement it is to show the locations form the database along with two buttons for Updating and Deleting  -->
		<table class="TableContent">
			<tr>
				<th> Name </th>
				<th> Address </th>
				<th> Drop-Off </th>
				<th> Pick-Up </th>
				<th> Query </th>
			</tr>
			<?php
			//this to select all items from the table before showing it
			$query = "SELECT * FROM `location_table`";
			$result = mysqli_query($conn,$query);
			if(!$result)
			{//showing if query has failed
				echo "<tr>";
				echo "<td>Query</td>";
				echo "<td> Has Failed you </td>";
				echo "<td> <input type='checkbox' class='CheckBox'> </td>";
				echo "<td> <input type='checkbox' class='CheckBox'> </td>";
				echo "<td> - - - </td>";
				echo"</tr>";
			}
			else
			{//query success
				$record = mysqli_fetch_array($result);
				if($record)
				{
					while ($record)//this is basically retrieveing data and then showing it on screen
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
						$pickUpResult= checkValue($pickUp);
						$dropOffResult= checkValue($dropOff);
						
						//This is showing each data from database on the website interface
						echo "<form method='POST' action='UpdateLocations.php'>";
						echo "<tr>";
						echo "<td>{$name}<input type='hidden' id='LID' name='LID' value='{$LID}'><br/>";
						echo "</td>";
						echo "<td> {$fulladdress} </td>";
						echo "<td> <input type='checkbox' class='CheckBox' id='dropOffBox' name='dropOffBox' $dropOffResult> </td>";
						echo "<td> <input type='checkbox' class='CheckBox' id='pickUpBox' name='pickUpBox' $pickUpResult> </td>";
						echo "<td>
						<div class='dropdown'>
							<button class='dropbtn' disabled>...</button>
							<div class='dropdown-content'>
								<button type='submit' name='deleteLocation' id='deleteLocation' class='btn'>Delete</button><br/>
								<button type='submit' name='updateLocation' id='updateLocation' class='btn'>Update</button>
							</div>
						</div>
						
						</td>";
						
						
						echo"</tr>";
						echo "</form>";
						
						$record = mysqli_fetch_assoc($result);//this is to move onto the next data
					}
				}
				else
				{//showing if there is no data
					echo "<tr>";
					echo "<td>Data</td>";
					echo "<td> Does not Exist </td>";
					echo "<td> <input type='checkbox' class='CheckBox'> </td>";
					echo "<td> <input type='checkbox' class='CheckBox'> </td>";
					echo "<td> - - - </td>";
					echo"</tr>";
				}
			}
			mysqli_close ($conn);
			?>
		</table>
		</div>

	</body>
</html>