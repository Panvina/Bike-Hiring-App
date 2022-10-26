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

//Assigns the session variable used for side nav. Added by Jake Hipworth 102090870
$_SESSION["CurrentPage"] = "";
?>

<!DOCTYPE html>
<html>
    <link rel="stylesheet" href="style/dashboard-style.css">
    <link rel="stylesheet" href="style/editpages.css">
    <head>
         <!-- Header -->
        <title>Edit Pages </title>
        <div class ="flexDisplay">
            <h1 class="header"> <a href="index.php"><img src="img/photos/Inverloch_Logo3.png" alt="Inverloch Logo" id="Logo" /></a> Edit Pages </h1>
            <a id="webpageDirect" name = "webpageDirect" href= 'index.php'> Back to website </a>
        </div>
    </head>
    <body>
        <div class="grid-container">
        	<div class="menu">
        		<?php printMenu("editpage"); ?>
        	</div>
        	<div class="main">
                <div class="grid">
                  <div class="item">
                    <h1 style="">Select a Page:</h1><br>
                    <a href="editIndex.php"><h1 style="text-decoration: underline;">Home Page</h1></a><br>
                    <a href="editIndex.php"><img src="img/editpages/index.png" style="width:500px;"></a>
                  </div>
                </div>
        	</div>
        </div>
    </body>
</html>
