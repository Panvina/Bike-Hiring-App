<?php

date_default_timezone_set('Australia/Melbourne');

include_once("php-scripts/backend-connection.php");

//enabling the user privilege of certain tabs. Added by Vina Touch 101928802
include_once "user-privilege.php";

//Linking utility functions associated with inventory
include("php-scripts/utils.php");

//Establishing database connection using mysqli()
$conn = new mysqli("localhost", "root", "", "bike_hiring_system");
?>

<!DOCTYPE html>
<html>
    <link rel="stylesheet" href="style/Jake_style.css">
    <head>
         <!-- Header -->
        <title> Block Out Dates </title>
        <h1 class="header"> <a href="index.php"><img src="img/photos/Inverloch_Logo3.png" alt="Inverloch Logo" id="Logo" /></a> Block Out Dates </h1>


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
                <a href= "Dashboard.php"> <img src= "img/icons/bulletin-board.png" alt="Dashboard Logo" /> Dashboard </a> <br>
                <a href = "Customer.php"> <img src= "img/icons/account-group.png" alt="Customer Logo" />  Customer  </a> <br>
                <?php  setOwnerDashboardPrivilege(); ?>
            <!--<a href="accounts.php"> <img src="img/icons/account.png" alt="Account logo"/> Accounts </a> <br>-->
                <a href= "Inventory.php"> <img src= "img/icons/bicycle.png" alt="Inventory Logo" />  Inventory </a> <br>
                <a href="Accessory.php"> <img src="img/icons/accessories.png" alt="Inventory Logo" /> Accessories </a> <br>
                <a href="BikeTypes.php"> <img src="img/icons/biketypes.png" alt="Bike Types Logo" /> Bike Types </a> <br>
                <a href="AccessoryTypes.php"> <img src="img/icons/accessorytypes.png" alt="Bike Types Logo" /> Accessory Types </a> <br>
                <a href= "bookings.php"> <img src= "img/icons/book-open-blank-variant.png" alt="Bookings Logo" /> Bookings </a> <br>
                <a class="active" href= "Block_Out_Date.php"> <img src= "img/icons/calendar.png" alt="Block out date Logo" /> Block Out Dates </a> <br>
                <a href= "Locations.php"> <img src= "img/icons/earth.png" alt="Locations Logo" /> Locations </a> <br>
                <a href= "editpages.php"> <img src= "img/icons/bulletin-board.png" alt="Edit Pages Logo" /> Edit </a> <br>
                <?php  setLogoutButton()?>
            </div>
         </nav>
         <div class="Content">
                <div class="month">      
                  <ul>
                    <li class="prev">&#10094;</li>
                    <li class="next">&#10095;</li>
                    <li style="font-size:14px">June<br>
                      <span style="font-size:14px">2022</span>
                    </li>
                  </ul>
                </div>

                <ul class="weekdays" style="font-size:24px;">
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

                  <a class="datetest" style="display: none;" href=""><li><span class="date active">0</span></li></a>
                  <?php 
                  $blockOutDatesSQL = $conn->query("SELECT * FROM block_out_dates");
                  while ($row = $blockOutDatesSQL->fetch_assoc()) {
                      $date_value = $row["date_value"];
                      $date_day = $row["date_day"];
                      $date_blockout = $row["date_blockout"];
                      $date_id = $row["date_id"];
                      $date_month = $row["date_month"];
                      $date_year = $row["date_year"];
                      $date_reason = $row["date_reason"];
                      if ($date_blockout == 0){
                       // echo '<a class="datetest" href="javascript:changeStartDate()"><li><span id="' . $date_value . '" class="date";">' . $date_day .'</span></li></a>';
                        echo '<a style="text-decoration:none;font-size:24px;" class="datetest" href="javascript: manageDate(' . '\'' . $date_id . '\'' . ', ' . '\'' . $date_blockout . '\'' .     ')"><li><span style="color:black;" id="' . $date_value . '" class ="date">' . $date_day . '</a>';

                      }else if ($date_blockout == 1){
                        //echo '<a style="pointer-events: none;" class="datetest" href="javascript:changeStartDate()"><li><span style="color:red;" id="' . $date_value . '" class="date";">' . $date_day .'</span></li></a>';
                        echo '<a style="text-decoration:none;font-size:24px;" class="datetest" href="javascript: manageDate(' . '\'' . $date_id . '\'' . ', ' . '\'' . $date_blockout . '\'' .     ')"><li><span style="color:red;" id="' . $date_value . '" class ="date">' . $date_day . '</a>';
                      }
                      ?>
                  <?php
                    }
                  ?>
                  <br>
                </ul>

                </div>
        <form id="blockOutDateAddForm" style="display: none;" action="block_out_date_add.php" method="post">
        <div id="blockOutDateAddContainer">
        </div>
        <input style="display:none;font-size: 24px;" id="blockDateSubmit" type="submit" value="Block Date">
        </form>

        <form id="blockOutDateRemoveForm" style="display: none;" action="block_out_date_remove.php" method="post">
        <div id="blockOutDateRemoveContainer">
        </div>
        <input style="display:none;font-size: 24px;" id="unblockDateSubmit" type="submit" value="Unblock Date">
        </form>
        <p style="font-size:24px;font-weight: bold;">Current Blockout Dates:</p>
        <?php 
          $blockOutDatesSQL = $conn->query("SELECT * FROM block_out_dates WHERE date_blockout = 1");
          while ($row = $blockOutDatesSQL->fetch_assoc()) {
              $date_value = $row["date_value"];
              $date_day = $row["date_day"];
              $date_blockout = $row["date_blockout"];
              $date_id = $row["date_id"];
              $date_month = $row["date_month"];
              $date_year = $row["date_year"];
              $date_reason = $row["date_reason"];
              echo '<tr> 
                  <td><strong style="font-size:24px;">'.$date_value.'</strong></td> 
              </tr><br>';
            }
          ?>




        </div>

<script type="text/javascript">

/*https://www.codegrepper.com/code-examples/javascript/javascript+add+character+to+string+at+position*/
  function addStr(str, index, stringToAdd){
    return str.substring(0, index) + stringToAdd + str.substring(index, str.length);
  }


  function clearSelect(){
    var deleteAddContainer = document.getElementById("blockOutDateAddContainer");
    var deleteRemoveContainer = document.getElementById("blockOutDateRemoveContainer");
    deleteAddContainer.innerHTML = '';
    deleteRemoveContainer.innerHTML = '';
  }
    
function manageDate(dateid, blockedout){
    clearSelect();
    if (blockedout == 0){
    document.getElementById("blockDateSubmit").style.display = "block";
    document.getElementById("unblockDateSubmit").style.display = "none";
    document.getElementById("blockOutDateAddForm").style.display = "block";
    var blockoutDateInput = document.createElement("input");
    blockoutDateInput.id = dateid;
    blockoutDateInput.name = "blockOutDate";
    blockoutDateInput.value = dateid;
    blockoutDateInput.style.display = "none";
    document.getElementById("blockOutDateAddContainer").appendChild(blockoutDateInput);
    blockoutDateText = document.createElement("h1");
    var blockoutDateTextStringToEdit = dateid;
    var blockoutDateTextFinish = addStr(blockoutDateTextStringToEdit, 4, "/");
    blockoutDateTextFinish = addStr(blockoutDateTextFinish, 7, "/");
    blockoutDateText.innerHTML = blockoutDateTextFinish;
    document.getElementById("blockOutDateAddContainer").appendChild(blockoutDateText);
    } else if (blockedout == 1){
    document.getElementById("blockDateSubmit").style.display = "none";
    document.getElementById("unblockDateSubmit").style.display = "block";
    document.getElementById("blockOutDateRemoveForm").style.display = "block";
    blockoutDateInput = document.createElement("input");
    blockoutDateInput.id = dateid;
    blockoutDateInput.name = "blockOutDate";
    blockoutDateInput.value = dateid;
    blockoutDateInput.style.display = "none";
    document.getElementById("blockOutDateRemoveContainer").appendChild(blockoutDateInput);
    blockoutDateText = document.createElement("h1");
    var blockoutDateTextStringToEdit = dateid;
    var blockoutDateTextFinish = addStr(blockoutDateTextStringToEdit, 4, "/");
    blockoutDateTextFinish = addStr(blockoutDateTextFinish, 7, "/");
    blockoutDateText.innerHTML = blockoutDateTextFinish;
    document.getElementById("blockOutDateRemoveContainer").appendChild(blockoutDateText);
    }
}


</script>


    </body>
</html>
