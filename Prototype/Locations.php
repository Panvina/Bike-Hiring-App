<!DOCTYPE html>
<html>
    <head>
        <title> Locations </title>
        <h1 class="header"> <img src="img/photos/Inverloch_Logo3.png" alt="Inverloch Logo" id="Logo"/> Locations </h1>
		
		<script src="scripts/FormOpenOrClose.js"></script>
		<link rel="stylesheet" href="style/Jake_Location_style.css"><!--
		<link rel="stylesheet" href="style/LocationPop.css">-->
		<link rel="stylesheet" href="style/LocationPop2.css">
		<?php
		include("backend-connection.php");
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
		}
		else
		{
			$note .= "Connection Passed";
			
		}
		
		$query = "SELECT `Name`, `Address`, `Suburb`, `Post Code`, `Drop Off Location`, `Pick Up Location` FROM location_table";
		$result = mysqli_query($conn,$query);
		if(!$result)
		{
			$note .= ", Query failed";
		}
		else
		{
			$note .= ", Query Succeed";
		}
		
//						@mysqli_select_db($conn,"$sql_db");
//		$conn = new DBConnection("$host",
//								 "$user",
//								 "$pwd",
//								"$sql_db");
		
		function checkValue($value)
		{
			$results = "";
//			echo "TestValue: $value <br/>";
			if($value=="1")
			{
				$results = "checked";
			}
			
			return $results;
		}
			?>
		
    </head>
    <body>
        <nav>
            <div class = "sideNavigation">
                <a href = "Dashboard.php"> <img src= "img/icons/bulletin-board.png" alt="Dashboard Logo" /> Dashboard </a> <br>
                <a href = "Customer.php"> <img src= "img/icons/account-group.png" alt="Customer Logo" />  Customer  </a> <br>
                <a href= "Inventory.php"> <img src= "img/icons/bicycle.png" alt="Inventory Logo" />  Inventory </a> <br>
                <a href= "bookings.php"> <img src= "img/icons/book-open-blank-variant.png" alt="Bookings Logo" /> Bookings </a> <br>
                <a href= "Block_Out_Date.php"> <img src= "img/icons/calendar.png" alt="Block out date Logo" /> Block Out Dates </a> <br>
                <a class="active" href= "Locations.php"> <img src= "img/icons/earth.png" alt="Locations Logo" /> Locations </a> <br>
            </div>
         </nav>


         <div class="Content">
            <h1> Pick-Up & Drop-Off Locations </h1>
			<h2><?php echo $note;?></h2>
			 
			 <!-- Trigger/Open The Modal -->
			 <button id="myBtn" style="left: 0%"  class="open-button" type="button">+ Add Location</button>
			 
			 <!-- The Modal -->
			 <div id="myModal" class="modal">
				 
				 <!-- Modal content -->
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

            <table class="TableContent">
                 <tr>
                     <th> Name </th>
                     <th> Address </th>
                     <th> Drop-Off </th>
                     <th> Pick-Up </th>
                     <th> Query </th>
                 </tr>
<!--
                 <tr>
                     <td> Inverloch Libary </td>
                     <td> 16 A'Beckett Strret, Inverloch, Vic, 3996 </td>
                     <td> <input type="checkbox" class="CheckBox"> </td>
                     <td> <input type="checkbox" class="CheckBox"> </td>
                 </tr>
-->
				<?php
				if(!$result)
					{
					echo "<tr>";
					echo "<td>Query</td>";
					echo "<td> Has Failed you </td>";
                    echo "<td> <input type='checkbox' class='CheckBox'> </td>";
					echo "<td> <input type='checkbox' class='CheckBox'> </td>";
					echo "<td> All </td>";
					echo"</tr>";
					}
					else
					{
						$record = mysqli_fetch_array($result);
						if($record)
						{
							while ($record)
							{
								$fulladdress = "";
								$address = $record['Address'];
								$suburb = $record['Suburb'];
								$postcode = $record['Post Code'];
								$dropOff = $record['Drop Off Location'];
								$pickUp = $record['Pick Up Location'];
								$fulladdress = "$address,  $suburb, $postcode, Vic, Australia";
								
								$pickUpResult= checkValue($dropOff);
								$dropOffResult= checkValue($pickUp);
//								echo "$postcode<br/>";
								echo "<tr>";
								echo "<td>{$record['Name']}<br/>";
								
/*								echo("PickUp: $pickUpResult<br/>");
								echo("DropOff: $dropOffResult<br/>");*/
								echo "</td>";
								echo "<td> {$fulladdress} </td>";
								echo "<td> <input type='checkbox' class='CheckBox' $pickUpResult> </td>";
								echo "<td> <input type='checkbox' class='CheckBox' $dropOffResult> </td>";
								echo "<td> - - - </td>";
								echo"</tr>";
								
								$record = mysqli_fetch_assoc($result);
							}
						}
						
						
						
					}
				mysqli_close ($conn);
				?>
            </table>
        </div>

    </body>
</html>
