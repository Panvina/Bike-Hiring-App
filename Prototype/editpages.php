<?php
session_start();

date_default_timezone_set('Australia/Melbourne');

include_once("php-scripts/backend-connection.php");

//Linking utility functions associated with inventory
include("php-scripts/utils.php");

//enabling the user privilege of certain tabs. Added by Vina Touch 101928802
include_once "user-privilege.php";

//Establishing database connection using mysqli()
$conn = new mysqli("localhost", "root", "", "bike_hiring_system");
?>

<!DOCTYPE html>
<html>
    <link rel="stylesheet" href="style/dashboard-style.css">
    <head>
         <!-- Header -->
        <title>Edit Pages </title>
        <h1 class="header"> <a href="index.php"><img src="img/photos/Inverloch_Logo3.png" alt="Inverloch Logo" id="Logo" /></a> Edit Pages </h1>


    </head>

    <style type="text/css">




    </style>
    <body>
        <div class="grid-container">
        	<div class="menu">
        		<a href= "Dashboard.php"> <img src= "img/icons/bulletin-board.png" alt="Dashboard Logo" /> Dashboard </a> <br>
        		<a href = "Customer.php"> <img src= "img/icons/account-group.png" alt="Customer Logo" />  Customer  </a> <br>
        		<?php setOwnerDashboardPrivilege(); ?>
        		<a href= "Inventory.php"> <img src= "img/icons/bicycle.png" alt="Inventory Logo" />  Inventory </a> <br>
        		<a href="Accessory.php"> <img src="img/icons/accessories.png" alt="Inventory Logo" /> Accessories </a> <br>
        		<a href="BikeTypes.php"> <img src="img/icons/biketypes.png" alt="Bike Types Logo" /> Bike Types </a> <br>
        		<a href="AccessoryTypes.php"> <img src="img/icons/accessorytypes.png" alt="Bike Types Logo" /> Accessory Types </a> <br>
        		<a href= "bookings.php"> <img src= "img/icons/book-open-blank-variant.png" alt="Bookings Logo" /> Bookings </a> <br>
        		<a href= "Block_Out_Date.php"> <img src= "img/icons/calendar.png" alt="Block out date Logo" /> Block Out Dates </a> <br>
        		<a href= "Locations.php"> <img src= "img/icons/earth.png" alt="Locations Logo" /> Locations </a> <br>
        		<a class="active" href= "editpages.php"> <img src= "img/icons/bulletin-board.png" alt="Edit Pages Logo" /> Edit </a> <br>
        		<?php setLogoutButton()?>
        	</div>
        	<div class="main">
                <ul>
                    <li style="font-size: 32px;"><a href="editIndex.php">Home</a></li>
                    <li style="font-size: 32px;">Hire</li>
                    <li style="font-size: 32px;">About Inverloch</li>
                    <li style="font-size: 32px;">About Cycling</li>
                    <li style="font-size: 32px;">Contact Us</li>
                </ul>
        	</div>
        </div>
    </body>
</html>
