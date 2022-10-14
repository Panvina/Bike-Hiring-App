<?php
session_start();

date_default_timezone_set('Australia/Melbourne');

include_once("php-scripts/backend-connection.php");

//Linking utility functions associated with inventory
include("php-scripts/utils.php");

//Establishing database connection using mysqli()
$conn = new mysqli("localhost", "root", "", "bike_hiring_system");
?>


<?php 
    $sql = "UPDATE block_out_dates SET date_blockout = 1 WHERE date_day_name = 'Wednesday'";
  if(mysqli_query($conn, $sql)){
  } else{
  // Echo error if failed query fails
      echo "ERROR: $sql. " 
          . mysqli_error($conn);
  }
  // Close connection
  mysqli_close($conn);
  header("Location: ../Block_Out_Date.php");

?>

<!DOCTYPE html>
<html>
    <link rel="stylesheet" href="style/Jake_style.css">
    <head>
         <!-- Header -->
        <title> Block Out Dates </title>
        <h1 class="header"> <img src="img/photos/Inverloch_Logo3.png" alt="Inverloch Logo" id="Logo"/> Block Out Dates </h1>


    </head>

    <style type="text/css">
       #dateContainer{
    box-sizing: border-box;
}


ul {list-style-type: none;}


.month {
  padding: 10px 25px;
  text-align: center;
  color:black;
  border-top:1px solid black;
  border-left:1px solid black;
  border-right:1px solid black;
}

.month ul {
  margin: 0;
  padding: 0;
  color:black;
}

.month ul li {
  color: black;
  font-size: 20px;
}

.month .prev {
  float: left;
  padding-top: 10px;
}

.month .next {
  float: right;
  padding-top: 10px;
}

.weekdays {
  margin: 0;
  padding: 10px 0;
  background-color: white;
  padding-left: 10px;
  border-left:1px solid black;
  border-right:1px solid black;
}

.weekdays li {
  display: inline-block;
  width: 13.7%;
  color: black;
  text-align: center;
}

.days {
  padding: 10px 0;
  background: white;
  margin: 0;
  padding-left: 10px;
  border-left:1px solid black;
  border-right:1px solid black;
  border-bottom:1px solid black;
}

.days li {
  list-style-type: none;
  display: inline-block;
  width: 14%;
  text-align: center;
  margin-bottom: 5px;
  font-size:12px;
  color: black;
}

.days li .blockout {
  color: grey !important
}

.date {
  border: none;
  outline: none;
  cursor: pointer;
  padding: 5px;
}

.active, .date:hover {
  background-color: #666;
  color: white;
}
 




    </style>
    <body>
        <!-- Side navigation -->
        <nav>
            <div class = "sideNavigation">
                <a href = "Dashboard.php"> <img src= "img/icons/bulletin-board.png" alt="Dashboard Logo" /> Dashboard </a> <br>
                <a href = "Customer.php"> <img src= "img/icons/account-group.png" alt="Customer Logo" />  Customer  </a> <br>
                <a href="staff.php"> <img src="img/icons/staff.png" alt="Staff Logo" /> Staff </a> <br>
                <a href= "Inventory.php"> <img src= "img/icons/bicycle.png" alt="Inventory Logo" />  Inventory </a> <br>
                <a href="Accessory.php"> <img src="img/icons/accessories.png" alt="Inventory Logo" /> Accessories </a> <br>
                <a href="BikeTypes.php"> <img src="img/icons/biketypes.png" alt="Bike Types Logo" /> Bike Types </a> <br>
                <a href="AccessoryTypes.php"> <img src="img/icons/accessorytypes.png" alt="Bike Types Logo" /> Accessory Types </a> <br>
                <a href= "bookings.php"> <img src= "img/icons/book-open-blank-variant.png" alt="Bookings Logo" /> Bookings </a> <br>
                <a class="active" href= "Block_Out_Date.php"> <img src= "img/icons/calendar.png" alt="Block out date Logo" /> Block Out Dates </a> <br>
                <a href= "Locations.php"> <img src= "img/icons/earth.png" alt="Locations Logo" /> Locations </a> <br>
            </div>
         </nav>
         <div class="Content">
            <h1> Block Out Dates </h1>
            <p><strong>Select Date/s:</strong></p>
                <div class="month">      
                  <ul>
                    <li class="prev">&#10094;</li>
                    <li class="next">&#10095;</li>
                    <li style="font-size:14px">JUNE<br>
                      <span style="font-size:14px">2022</span>
                    </li>
                  </ul>
                </div>

                <ul class="weekdays">
                  <li>M</li>
                  <li>T</li>
                  <li>W</li>
                  <li>T</li>
                  <li>F</li>
                  <li>S</li>
                  <li>S</li>
                </ul>
                <div id="dateContainer">
                <ul class="days">
                    
                  
        
        <form id="blockOutDateAddForm" style="display: none;" action="block_out_date_add.php" method="post">
        <div id="blockOutDateAddContainer">

        </div>
        <input id="blockOutDateRemoveForm" type="submit" value="Block Date">
        </form>

        <form style="display: none;" action="block_out_date_remove.php" method="post">
        <div id="blockOutDateRemoveContainer">

        </div>
        <input type="submit" value="Unblock Date">
        </form>



        </div>



    </body>
</html>
