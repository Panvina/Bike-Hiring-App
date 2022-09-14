<?php
session_start();

date_default_timezone_set('Australia/Melbourne');

include_once("php-scripts/backend-connection.php");

//Linking utility functions associated with inventory
include("php-scripts/utils.php");

//Establishing database connection using mysqli()
$conn = new mysqli("localhost", "root", "", "bike_hiring_system");
?>
<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="./style/style.css">
    <link rel="stylesheet" href="https://unpkg.com/flickity@2/dist/flickity.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title>Make a Booking</title>
</head>
<style type="text/css">    

.mainheader {
    position: relative; 
    height: 150px;
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.mainheader::before {    
      content: "";
      background-image: url('../img/mainheaderimg.jpg');
      background-size: cover;
      position: absolute;
      top: 0px;
      right: 0px;
      bottom: 0px;
      left: 0px;
      opacity: 0.5;
}

.mainheader p {
  position: relative;
  color: black;  
  font-size: 40px;
  line-height: 0.9;
  text-align: center;
  font-family: calibri;
}


/* Main Container */

.maincontainer{
    padding-left: 10%;
    padding-right: 10%;
    padding-top: 10px;
}

#dateContainer{
    box-sizing: border-box;
}


/* Bike Columns */

#dualContainer {
    width: 100%;
    margin: 0 auto;
    background-color: white;
    height: 1000px;
}

#dualColumn1 {
    float: left;
    width: 75%;
}

#dualColumn2 {
    float: left;
    width: 25%;
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
  width: 12%;
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
  width: 12%;
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
    <?php include 'header.php' ?>    
    <div id = "main">
        <div class="banner">
            <div id="bannertext">
                <h1>MAKE A BOOKING</h1>
            </div>
            <div class ="NavContainer">
                    <ul class="Breadcrumbs">
                        <li class="BreadcrumbsItem">
                            <a href="Index.php" class="BreadcrumbsURL">Home</a>
                        </li>
                        <li class="BreadcrumbsItem">
                            <a href="javascript:window.location.href=window.location.href" class="BreadcrumbsURL BreadcrumbsURLactive">Hire</a>
                        </li>
                        <li class="BreadcrumbsItem">
                            <a href="javascript:window.location.href=window.location.href" class="BreadcrumbsURL BreadcrumbsURLactive">Mountain</a>
                        </li>
                        <li class="BreadcrumbsItem">
                            <a href="javascript:window.location.href=window.location.href" class="BreadcrumbsURL BreadcrumbsURLactive">MERIDA Big 7</a>
                        </li>
                        <li class="BreadcrumbsItem">
                            <a href="javascript:window.location.href=window.location.href" class="BreadcrumbsURL BreadcrumbsURLactive">Book</a>
                        </li>
                    </ul>
            </div>
        </div>
        
        <div class="maincontainer">
        <div id="dualContainer">
            <div id="dualColumn1">
              <?php
            $accessoryType = $conn->query("SELECT * FROM bike_type_table");
            while ($row = $accessoryType->fetch_assoc()) {
                $bikeName = $row["name"];
                $bikeTypeId = $row["bike_type_id"];  
            ?>
            <h1><strong><?php echo $row["name"]; ?></strong></h1>
                <img src="img/photos/4.jpg" style="width:50%;">
                <p><?php echo $row["description"]; ?></p>
                <?php echo '<a style="font-size:24px;font-family: Comfortaa;color:black;" href="javascript: addBike(' . '\'' . $bikeName . '\'' . ', ' . '\'' . $bikeTypeId . '\'' .     ')">Add Bike</a>';?>
            <?php
            }
            ?>
            </div>
            <div id="dualColumn2">
                <p><strong>Select Date/s:</strong></p>
                <div class="month">      
                  <ul>
                    <li class="prev">&#10094;</li>
                    <li class="next">&#10095;</li>
                    <li style="font-size:14px">June<br>
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

                  <a class="datetest" style="display: none;" href=""><li><span class="date active">0</span></li></a>
                  <?php 
                  $blockOutDatesSQL = $conn->query("SELECT * FROM block_out_dates");
                  while ($row = $blockOutDatesSQL->fetch_assoc()) {
                      $date_value = $row["date_value"];
                      $date_day = $row["date_day"];
                      $date_blockout = $row["date_blockout"];
                      if ($date_blockout == 0){
                        echo '<a class="datetest" href="javascript:changeStartDate()"><li><span id="' . $date_value . '" class="date";">' . $date_day .'</span></li></a>';
                      }else if ($date_blockout == 1){
                        echo '<a style="pointer-events: none;" class="datetest" href="javascript:changeStartDate()"><li><span style="color:red;" id="' . $date_value . '" class="date";">' . $date_day .'</span></li></a>';
                      }
                      ?>
                  <?php
                    }
                  ?>
                  <br>
                </ul>

                </div>

                <br>
                <form action="makeabookinginsert.php" method="post">
                  <label for="timeValue">Start Date:</label>
                  <input class="startDateInput" type="text" id="startDateValue" name="startDateValue" value="" readonly>
                  <br><br>
                  <div style="display:none;" id="endDateContainer">
                    <label for="timeValue">End Date:</label>
                    <input class="endDateInput" type="text" id="endDateValue" name="endDateValue" value="" readonly>
                    <br><br>
                  </div>
                  <label for="pickupTimeValue">Pickup Time:</label>
                  <select id="pickupTimeValue" name="pickupTimeValue">
                    <option value="none"></option>
                    <option value="9:00:00">9:00 AM</option>
                    <option value="10:00:00">10:00 AM</option>
                    <option value="11:00:00">11:00 AM</option>
                    <option value="12:00:00">12:00 PM</option>
                    <option value="13:00:00">1:00 PM</option>
                    <option value="14:00:00">2:00 PM</option>
                    <option value="15:00:00">3:00 PM</option>
                    <option value="16:00:00">4:00 PM</option>
                  </select>
                  <br><br>
                  <label for="dropoffTimeValue">Dropoff Time:</label>
                  <select id="dropoffTimeValue" name="dropoffTimeValue">
                    <option value="none"></option>
                    <option value="9:00:00">9:00 AM</option>
                    <option value="10:00:00">10:00 AM</option>
                    <option value="11:00:00">11:00 AM</option>
                    <option value="12:00:00">12:00 PM</option>
                    <option value="13:00:00">1:00 PM</option>
                    <option value="14:00:00">2:00 PM</option>
                    <option value="15:00:00">3:00 PM</option>
                    <option value="16:00:00">4:00 PM</option>
                  </select>
                  <br><br>
                  <label for="pickupLocationValue">Pick-Up Location:</label>
                  <select id="pickupLocationValue" name="pickupLocationValue">
                    <option value="none"></option>
                  <?php
                    $locationQuery = $conn->query("SELECT * FROM location_table WHERE pick_up_location=1");
                    while ($row = $locationQuery->fetch_assoc()) {
                        
                        $locationName = $row["name"];
                        $locationId = $row["location_id"];  
                    ?>
                    
                    <?php echo '<option value="' . $locationId . '"> ' . $locationName . '</option>'?>
                    <?php
                    }
                    ?>
                  </select>
                  <br><br>
                  <label for="dropoffLocationValue">Drop-Off Location:</label>
                  <select id="dropoffLocationValue" name="dropoffLocationValue">
                    <option value="none"></option>
                  <?php
                    $locationQuery = $conn->query("SELECT * FROM location_table WHERE drop_off_location=1");
                    while ($row = $locationQuery->fetch_assoc()) {
                        $locationName = $row["name"];
                        $locationId = $row["location_id"];  
                    ?>
                    
                    <?php echo '<option value="' . $locationId . '">' . $locationName . '</option>'?>
                    <?php
                    }
                    ?>
                  </select>
                  <br>
                <p style="font-size: 24px;display: inline-block;">Add Accessory:</p>
                <br>
                <?php
                $accessoryType = $conn->query("SELECT * FROM accessory_type_table");

                while ($row = $accessoryType->fetch_assoc()) {
                    $accessoryTypeId = $row["accessory_type_id"];
                    $accessoryTypeName = $row["name"];
                ?>
                <?php echo '<a style="font-size:18px;font-family: Comfortaa;color:black;" href="javascript: addAccessory(' . '\'' . $accessoryTypeName . '\'' . ', ' . '\'' . $accessoryTypeId . '\'' .     ')">Add ' . $accessoryTypeName . '</a>';?>
                <br>
                <?php
                }
                ?>
                    <p style="font-size: 24px;">Item List:</p>
                    <div id="itemListContainer" style="display: inline-block;">
                    
                  </div>
                  <br>
                  
                  <label style="" id="" for="custId">Customer Info:</label>
                  <input style="font-size: 14px;" class="" type="text" id="userName" name="userName" value="11" readonly> 
                  <br><br>
                  <label for="timeValue">Total Price:</label>
                  <input style="font-size: 14px;" class="" type="text" id="totalPriceInput" name="totalPriceInput" value="0" readonly>
                  <br><br>
                  <input type="checkbox" id="termsValue" name="termsValue" value="">
                  <label for="termsValue"> I have read and agreed to the <a href="">terms and conditions.</a></label>
                  <br>
                  <br>
                  <center><input type="submit" value="BOOK NOW" style="background-color:black;color:white;padding: 10px;text-align: center;font-size:24px;width: 100%;"></center>
                </form>


            </div>
        </div>
    </div>
        <script src="https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js"></script>
        <script type = "text/javascript">
        $('.main-carousel').flickity({
        cellAlign: 'left',
        wrapAround:true,
        freeScroll:true
        });</script>
    </div>
    <?php include 'footer.php' ?>

<script type="text/javascript">
  

</script>


<script type="text/javascript">
 function addBike(bikeName, bikeTypeId){
  newTextInput = document.createElement("input");
  bikeNameText = "bike";
  newTextInput.name = bikeNameText.concat(bikeTypeId);
  newTextInput.id = bikeNameText.concat(bikeTypeId);
  newTextInput.type = "text";
  newTextInput.value = bikeTypeId;
  newTextInput.readOnly = true;
  newTextInput.style.visibility = "hidden";
  newBikeText = document.createElement("p");
  newBikeText.innerHTML = bikeName;
  document.getElementById("itemListContainer").appendChild(newTextInput);
  document.getElementById("itemListContainer").appendChild(newBikeText);
  newSelectText = document.createElement("p");
  newSelectText.innerHTML =  bikeName + " Quantity:";
  document.getElementById("itemListContainer").appendChild(newSelectText);
  var newArray = ["1","2","3","4"];
  var newSelectList = document.createElement("select");
  newSelectText1 = "bike";
  newSelectText2 = "quantity";
  newSelectIDName1 = newSelectText1.concat(bikeTypeId);
  newSelectIDName2 = newSelectIDName1.concat(newSelectText2);
  newSelectList.id = newSelectIDName2;
  newSelectList.name = newSelectIDName2;
  for (var i = 0; i < newArray.length; i++) {
      var option = document.createElement("option");
      option.value = newArray[i];
      option.text = newArray[i];
      newSelectList.appendChild(option);
  }
  document.getElementById("itemListContainer").appendChild(newSelectList);

 }



 function addAccessory(accessoryName, accessoryTypeId){
  newTextInput = document.createElement("input");
  newAccessoryText = "accessory";
  newTextInput.id = newAccessoryText.concat(accessoryTypeId);
  newTextInput.name = newAccessoryText.concat(accessoryTypeId);
  newTextInput.type = "text";
  newTextInput.value = accessoryTypeId;
  newTextInput.readOnly = true;
  newTextInput.style.visibility = "hidden";
  newAccessoryText = document.createElement("p");  
  newAccessoryText.innerHTML = accessoryName;
  document.getElementById("itemListContainer").appendChild(newTextInput);
  document.getElementById("itemListContainer").appendChild(newAccessoryText);
  /*
  newSelectText = document.createElement("p");
  newSelectText.innerHTML =  accessoryName + " Quantity:";
  document.getElementById("itemListContainer").appendChild(newSelectText);
  var newArray = ["1","2","3","4"];
  var newSelectList = document.createElement("select");
  newSelectText1 = "bike";
  newSelectText2 = "quantity";
  newSelectIDName1 = newSelectText1.concat(bikeTypeId);
  newSelectIDName2 = newSelectIDName1.concat(newSelectText2);
  newSelectList.id = newSelectIDName2;
  newSelectList.name = newSelectIDName2;
  for (var i = 0; i < newArray.length; i++) {
      var option = document.createElement("option");
      option.value = newArray[i];
      option.text = newArray[i];
      newSelectList.appendChild(option);
  }
    document.getElementById("itemListContainer").appendChild(newSelectList);
    */

 }

</script>



<script type="text/javascript">
// Run function on load 
document.onload = initaliseCalendar();

function setEnd(){
      $(".datetest[href]").attr("href", "javascript:changeEndDate()");
      document.getElementsByClassName("active")[0].style.backgroundColor = "green";
      document.getElementsByClassName("active")[0].style.color = "white";
      document.getElementsByClassName("active")[0].parentNode.parentNode.href = "javascript:resetDates()";
}

function setStart(){
      $(".datetest[href]").attr("href", "javascript:changeStartDate()");
      //document.getElementsByClassName("active")[0].style.backgroundColor = "red";
      //document.getElementsByClassName("active")[0].style.color = "white";
}

function finaliseCalendar(){
      $(".datetest[href]").attr("href", "javascript:resetDates()");
      document.getElementsByClassName("active")[0].style.backgroundColor = "red";
      document.getElementsByClassName("active")[0].style.color = "white";


}


function resetDates(){
      var dateContainer = document.getElementById("dateContainer");
      var allDates = dateContainer.getElementsByClassName("date");
      // Loop through the buttons and add the active class to the clicked date
      for (var i = 0; i < allDates.length; i++) {
        allDates[i].style.backgroundColor = "";
        allDates[i].style.color = "";
      }
      document.getElementById("endDateContainer").style.display = "none";
      document.getElementById("endDateValue").value = document.getElementById("startDateValue").value;
      document.getElementById("startDateValue").value = "";
      document.getElementById("endDateValue").value = "";
      setStart();
      changeStartDate();
      setEnd();
 


}


function initaliseCalendar(){
  // Set variables
var dateContainer = document.getElementById("dateContainer");
var allDates = dateContainer.getElementsByClassName("date");
// Loop through the buttons and add the active class to the clicked date
for (var i = 0; i < allDates.length; i++) {
  allDates[i].addEventListener("click", function() {
    var currentDates = document.getElementsByClassName("active");
    currentDates[0].className = currentDates[0].className.replace(" active", "");
    this.className += " active";
    // Set form value for date to clicked date
  });
  document.getElementById("startDateValue").value = document.getElementsByClassName("active")[0].id;
  document.getElementById("endDateValue").value = document.getElementsByClassName("active")[0].id;
}
}


function changeStartDate(){
// Set variables
var dateContainer = document.getElementById("dateContainer");
var allDates = dateContainer.getElementsByClassName("date");
// Loop through the buttons and add the active class to the clicked date
for (var i = 0; i < allDates.length; i++) {
  allDates[i].addEventListener("click", function() {
    var currentDates = document.getElementsByClassName("active");
    currentDates[0].className = currentDates[0].className.replace(" active", "");
    this.className += " active";
    // Set form value for date to clicked date
  });
  document.getElementById("startDateValue").value = document.getElementsByClassName("active")[0].id;
  document.getElementById("endDateValue").value = document.getElementsByClassName("active")[0].id;
}
  setEnd();
}

function changeEndDate(){
// Set variables
var dateContainer = document.getElementById("dateContainer");
var allDates = dateContainer.getElementsByClassName("date");
// Loop through the buttons and add the active class to the clicked date
for (var i = 0; i < allDates.length; i++) {
  allDates[i].addEventListener("click", function() {
    var currentDates = document.getElementsByClassName("active");
    currentDates[0].className = currentDates[0].className.replace(" active", "");
    this.className += " active";
    // Set form value for date to clicked date
  });
  document.getElementById("endDateContainer").style.display = "block";
  document.getElementById("endDateValue").value = document.getElementsByClassName("active")[0].id;
}
setDuration();
finaliseCalendar();
}


function setDuration(){
  var start = document.getElementById("startDateValue").value;
  var end = document.getElementById("startDateValue").value;
  if (start === end){
    $('#durationValue').val('Overnight');
  }
}




</script>    
</body>
</html>