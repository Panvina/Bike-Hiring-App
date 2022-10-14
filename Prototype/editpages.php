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
    <link rel="stylesheet" href="style/editpages.css">
    <head>
         <!-- Header -->
        <title>Edit Pages </title>
        <h1 class="header"> <a href="index.php"><img src="img/photos/Inverloch_Logo3.png" alt="Inverloch Logo" id="Logo" /></a> Edit Pages </h1>
    </head>
    <body>
        <div class="grid-container">
        	<div class="menu">
        		<?php printMenu("editpage"); ?>
        	</div>
        	<div class="main">
                <div class="grid">
                  <div class="item">
                    <a href="editIndex.php"><h1 style="text-decoration: underline;">Edit Home Page</h1></a>
                    <a href="editIndex.php"><img src="img/editpages/index.png" style="width:500px;"></a>
                  </div>
                </div>
        	</div>
        </div>
    </body>
</html>
