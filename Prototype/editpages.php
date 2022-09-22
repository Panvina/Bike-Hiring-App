<?php
session_start();

date_default_timezone_set('Australia/Melbourne');

include_once("php-scripts/backend-connection.php");

//Linking utility functions associated with inventory
include("php-scripts/utils.php");

// dashboard side menu import (Dabin)
include_once("php-scripts/dashboard-menu.php");

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
        		<?php printMenu("editpage"); ?>
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
