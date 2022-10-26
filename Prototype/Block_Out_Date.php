<?php

date_default_timezone_set('Australia/Melbourne');

include_once("php-scripts/backend-connection.php");

// dashboard side menu import (Dabin)
include_once("php-scripts/dashboard-menu.php");

//Linking utility functions associated with inventory
include("php-scripts/utils.php");

//Establishing database connection using mysqli()
$conn = new mysqli("localhost", "root", "", "bike_hiring_system");

$_SESSION["CurrentPage"] = "";
?>

<!DOCTYPE html>
<html>
    <link rel="stylesheet" href="style/dashboard-style.css">
    <link rel="stylesheet" href="style/blockoutdates.css">
    <head>
         <!-- Header -->
        <title> Block Out Dates </title>
        <div class ="flexDisplay">
            <h1 class="header"> <a href="index.php"><img src="img/photos/Inverloch_Logo3.png" alt="Inverloch Logo" id="Logo" /></a> Block Out Dates </h1>
            <a id="webpageDirect" name = "webpageDirect" href= 'index.php'> Back to website </a>
        </div>
    </head>

    <body>
        <div class="grid-container">
        	<div class="menu">
        		<?php printMenu("blockoutdate"); ?>
        	</div>
        	<div class="main">
                <div class="month">
                  <ul>
                    <li class="prev">&#10094;</li>
                    <li class="next">&#10095;</li>
                    <li style="font-size:14px;font-family: Arial;">June<br>
                      <span style="font-size:14px;font-family: Arial;">2022</span>
                    </li>
                  </ul>
                </div>

                <ul class="weekdays" style="font-size:24px;font-family: Arial;">
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
                        echo '<a style="text-decoration:none;font-size:24px;" class="datetest" href="javascript: manageDate(' . '\'' . $date_id . '\'' . ', ' . '\'' . $date_blockout . '\'' .     ')"><li><span style="color:black;font-family: Arial;" id="' . $date_value . '" class ="date">' . $date_day . '</a>';

                      }else if ($date_blockout == 1){
                        //echo '<a style="pointer-events: none;" class="datetest" href="javascript:changeStartDate()"><li><span style="color:red;" id="' . $date_value . '" class="date";">' . $date_day .'</span></li></a>';
                        echo '<a style="text-decoration:none;font-size:24px;" class="datetest" href="javascript: manageDate(' . '\'' . $date_id . '\'' . ', ' . '\'' . $date_blockout . '\'' .     ')"><li><span style="font-family: Arial;color:red;" id="' . $date_value . '" class ="date">' . $date_day . '</a>';
                      }
                      ?>
                  <?php
                    }
                  ?>
                  <br>
                </ul>

                </div>




        <div class="rowmain">
          <div class="columnmain">
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
              <p style="font-size:32px;font-weight: bold;font-family: Arial;">Current Blockout Dates:</p>
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
                    $date_day_name = $row["date_day_name"];
                    echo '<tr>
                        <td><strong style="font-size:28px;font-family: Arial;">'.$date_day_name.': '.$date_value.'</strong></td>
                    </tr><br>';
                  }
                ?>
          </div>
          <div class="columnmain">
            <p style="font-size:32px;font-weight: bold;font-family: Arial;">Block Out Functions:</p>
            <p style="font-size:24px;font-weight: bold;font-family: Arial;">Block Out Per Day:</p>

            <table>
              <tr>
                <th>Block</th>
                <th>Unblock</th>
              </tr>
              <tr>
                <td><a href="php-scripts/block_out_date_block_monday.php">Block All Mondays</a></td>
                <td><a href="php-scripts/block_out_date_unblock_monday.php">Unblock All Mondays</a></td>
              </tr>
              <tr>
                <td><a href="php-scripts/block_out_date_block_tuesday.php">Block All Tuesdays</a></td>
                <td><a href="php-scripts/block_out_date_unblock_tuesday.php">Unblock All Tuesdays</a></td>
              </tr>
              <tr>
                <td><a href="php-scripts/block_out_date_block_wednesday.php">Block All Wednesdays</a></td>
                <td><a href="php-scripts/block_out_date_unblock_wednesday.php">Unblock All Wednesdays</a></td>
              </tr>
              <tr>
                <td><a href="php-scripts/block_out_date_block_thursday.php">Block All Thursdays</a></td>
                <td><a href="php-scripts/block_out_date_unblock_thursday.php">Unblock All Thursdays</a></td>
              </tr>
              <tr>
                <td><a href="php-scripts/block_out_date_block_friday.php">Block All Fridays</a></td>
                <td><a href="php-scripts/block_out_date_unblock_friday.php">Unblock All Fridays</a></td>
              </tr>
              <tr>
                <td><a href="php-scripts/block_out_date_block_saturday.php">Block All Saturdays</a></td>
                <td><a href="php-scripts/block_out_date_unblock_saturday.php">Unblock All Saturdays</a></td>
              </tr>
              <tr>
                <td><a href="php-scripts/block_out_date_block_sunday.php">Block All Sundays</a></td>
                <td><a href="php-scripts/block_out_date_unblock_sunday.php">Unblock All Sundays</a></td>
              </tr>
            </table>
            <p style="font-size:24px;font-weight: bold;font-family: Arial;">Block Out Weekends:</p>
            <table>
              <tr>
                <th>Block</th>
                <th>Unblock</th>
              </tr>
              <tr>
                <td><a href="php-scripts/block_out_date_block_weekends.php">Block All Weekends</a></td>
                <td><a href="php-scripts/block_out_date_unblock_weekends.php">Unblock All Weekends</a></td>
              </tr>                
            </table>
            <p style="font-size:24px;font-weight: bold;font-family: Arial;">Block Out Month:</p>
            <table>
              <tr>
                <th>Block</th>
                <th>Unblock</th>
              </tr>
              <tr>
                <td><a href="../Prototype/php-scripts/block_out_date_block_all.php">Block All Month</a></td>
                <td><a href="../Prototype/php-scripts/block_out_date_unblock_all.php">Unblock All Month</a></td>
              </tr>                
            </table>
            <p style="font-size:24px;font-weight: bold;font-family: Arial;">Block All Dates:</p>
            <table>
              <tr>
                <th>Block</th>
                <th>Unblock</th>
              </tr>
              <tr>
                <td><a href="../Prototype/php-scripts/block_out_date_block_all.php">Block All Dates</a></td>
                <td><a href="../Prototype/php-scripts/block_out_date_unblock_all.php">Unblock All Dates</a></td>
              </tr>                
            </table>
          </div>
        </div>


        









        	</div>
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
    blockoutDateText.style.fontFamily = "Arial";
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
    blockoutDateText.style.fontFamily = "Arial";
    document.getElementById("blockOutDateRemoveContainer").appendChild(blockoutDateText);
    }
}


</script>



    </body>
</html>
