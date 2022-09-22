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
    // dashboard side menu import (Dabin)
    include_once("php-scripts/dashboard-menu.php");
?>
<!DOCTYPE html>
<html>
	<head>
		<title> Locations </title>
		<h1 class="header"> <a href="index.php"><img src="img/photos/Inverloch_Logo3.png" alt="Inverloch Logo" id="Logo" /></a> Locations </h1>
        <link rel="stylesheet" href="style/dashboard-style.css">
        <link rel="stylesheet" href="style/popup.css">
		<link rel="stylesheet" href="style/LocationPop.css">
		<?php
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
        <div class="grid-container">
        	<div class="menu">
        		<?php printMenu("location"); ?>
        	</div>
        	<div class="main">
                <h1> Pick-Up & Drop-Off Locations </h1>

    			<!-- Trigger/Open The PopUp -->
    			<button id="myBtn" style="left: 0%"  class="open-button" type="button">+ Add Location</button>
                <table class="TableContent" id="data-table">
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
        						echo "<td><input type='hidden' id='LID' name='LID' value='{$LID}'><input type='text' name='nameupdate' id ='nameupdate' value='{$name}'  style='width: 100%; border: hidden;' required><br/>";
        						echo "</td>";
        						echo "<td> <input type='text' name='fulladdress' id ='fulladdress' value='{$fulladdress}' style='width: 100%; border: hidden;' required> </td>";
        						echo "<td> <input type='checkbox' class='CheckBox' id='dropOffBox' name='dropOffBox' $dropOffResult> </td>";
        						echo "<td> <input type='checkbox' class='CheckBox' id='pickUpBox' name='pickUpBox' $pickUpResult> </td>";
        						echo "<td class='editcolumn'>
        						<div class='dropdown'>
        							<button class='dropbtn' disabled>...</button>
        							<div class='dropdown-content'>
        								<button type='submit' name='updateLocation' id='updateLocation' class='dropdown-element'>Update</button><br/>
        								<button type='submit' name='deleteLocation' id='deleteLocation' class='dropdown-element'>Delete</button>
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
        </div>

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
	</body>
    <script src="scripts/FormOpenOrClose.js"></script>
    <script>
            /* When the user clicks on the button,
toggle between hiding and showing the dropdown content */
        function myFunction() {
            document.getElementById("myDropdown").classList.toggle("show");
        }
</script>
</html>
