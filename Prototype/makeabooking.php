<?php

// Make a Booking Page - Created by Eamon Kearney 102093549 //

//added a session to store an active state of which page has been clicked by the user - Vina Touch
if (!isset($_SESSION)){
        session_start();
}
$_SESSION['active']="hire"; 
/**************************/

$_SESSION['id'] = '123';
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

/* Terms and Condtions Pop Up */

/*https://www.w3schools.com/howto/howto_css_modals.asp */

.modal {
  display: none; 
  position: fixed;
   overflow: auto;
  background-color: rgb(0,0,0);
  background-color: rgba(0,0,0,0.5);
  z-index: 1; 
  padding-top: 100px; 
  left: 0;
  top: 0;
  width: 100%; 
  height: 100%;
 
}

.modal-content {
  background-color: black;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 100%;
}

.close {
  color: black;
  float: right;
  font-size: 50px;
  font-weight: bold;
  margin-left: 10px;
}

.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}


/*  Scrollbar CSS */

::-webkit-scrollbar {
  width: 10px;
}

::-webkit-scrollbar-track {
  background: #f1f1f1; 
}
 
::-webkit-scrollbar-thumb {
  background: #888; 
}

::-webkit-scrollbar-thumb:hover {
  background: #555; 
}

/* Header CSS */

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

#columnContainer {
    width: 100%;
    margin: 0 auto;
    background-color: white;
    height: 1000px;
}

#Column1 {
    float: left;
    width: 45%;
}

#Column2 {
    float: left;
    width: 30%;
}
#Column3 {
    float: left;
    width: 20%;
}

/* Calender CSS */

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
                    </ul>
            </div>
        </div>
        <!-- Available Bikes Column -->
        <div class="maincontainer">
        <div id="columnContainer">
            <div style="" id="Column1">
            	<h1>Available Bikes:</h1>
            	<div style="overflow-y: scroll;height: 1000px;">
              <?php
              //Get all available bikes
            $bikeType = $conn->query("SELECT * FROM bike_type_table");
            while ($row = $bikeType->fetch_assoc()) {
              //Assign values
                $bikeName = $row["name"];
                $bikeTypeId = $row["bike_type_id"];  
                $bikeDescription = $row["description"];
                $bikeImage = $row["picture_id"];
            ?>
            <!-- Display Bike Information -->
            <h1><strong><?php echo $bikeName; ?></strong></h1>
                <?php echo '<img src="img/bike-type/'; echo $bikeImage; echo'.jpg" style="width:300px;">'; ?>
                <?php echo '<p style="font-size:24px;">Description: ' . $bikeDescription . '</p>'; ?>
                <?php 
                //Check if bike is available in inventory
                  $bikeInventoryAvailable = $conn->query("SELECT bike_type_id, bike_id, price_ph FROM bike_inventory_table where bike_type_id = $bikeTypeId");
                  $bikeInventoryNum = mysqli_num_rows($bikeInventoryAvailable);
                  //If available
                  if ($bikeInventoryNum > 0){
                    while ($row = $bikeInventoryAvailable->fetch_assoc()) {
                    //Assign values
                    $bikeInventoryBikeBikeId = $row["bike_id"];
                    $bikePrice = $row["price_ph"];
                    //Check is bike is currently booked
                    $bookingBikeTableAvailability = $conn->query("SELECT * FROM booking_bike_table");
                      while ($row = $bookingBikeTableAvailability->fetch_assoc()) {
                        $bookingBikeTableBikeId = $row["bike_id"];
                        //Check if bike is booked
                        if ($bookingBikeTableBikeId == $bikeInventoryBikeBikeId){
                          $bikeInventoryNum = $bikeInventoryNum - 1;
                        }
                      }
                    }
                    // Display bike information
                    echo '<p style="font-size:24px;">Price Per Hour: $' . $bikePrice . '</p>';
                    echo '<p style="font-size:24px;">Available Bikes: ' . $bikeInventoryNum . '</p>';
                    //If Bike is avaiable and not booked print information and quantity
                    if ($bikeInventoryNum > 0){
                    echo '<div id="addBikeContainer'. $bikeTypeId .'">';
                    echo '<a style="font-size:24px;font-family: Comfortaa;color:black;font-weight:bold;" href="javascript: addBike(' . '\'' . $bikeName . '\'' . ', ' . '\'' . $bikeTypeId . '\'' .  ', ' . '\'' . $bikeInventoryNum . '\'' .    ')">Select Bike</a>';
                    echo '</div>';
                    echo '<br>';
                    echo '<hr>';
                    //Print if unavailable  
                    }else{
                    echo '<p style="font-size:24px;">Bike Unavailable</p>';
                    }
                  }else {
                    //Print if no quantity
                    echo '<p style="font-size:24px;">Available Bikes: 0</p>';
                    echo '<p style="font-size:24px;">Bike Unavailable</p>';
                  }
                ?>
            <?php
            }
            ?>
            <br>
            <br>
            <br>
            <br>
        	</div>
            </div>
            <!-- Booking Details Section -->
            <div id="Column2">
            	 <h1>Booking Details:</h1>
            	 <div style="overflow-y: scroll;height: 1000px;padding-right: 50px;padding-left: 50px;">
                <!-- Calender Selection -->
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
                  // Get all blockout dates
                  $blockOutDatesSQL = $conn->query("SELECT * FROM block_out_dates");
                  while ($row = $blockOutDatesSQL->fetch_assoc()) {
                      $date_value = $row["date_value"];
                      $date_day = $row["date_day"];
                      $date_blockout = $row["date_blockout"];
                      // Sort blockout dates by block status
                      if ($date_blockout == 0){
                        echo '<a class="datetest" href="javascript:changeStartDate()"><li><span id="' . $date_value . '" class="date";">' . $date_day .'</span></li></a>';
                        //If blocked disable pointer events
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
                <!-- Form Details -->
                <form action="makeabookingconfirm.php" method="post">
                	<div style="display:none;" id="startDateContainer">
                  <label style="font-family: Comfortaa;" for="timeValue">Start Date:</label>
                  <br>
                  <input class="startDateInput" type="text" id="startDateValue" name="startDateValue" value="" readonly>
                  <br><br>
              		</div>
                  <div style="display:none;" id="endDateContainer">
                    <label style="font-family: Comfortaa;" for="timeValue">End Date:</label>
                    <br>
                    <input class="endDateInput" type="text" id="endDateValue" name="endDateValue" value="" readonly>
                    <br><br>
                  </div>
                  <label style="font-family: Comfortaa;" for="pickupTimeValue">Pickup Time:</label>
                  <br>
                  <select id="pickupTimeValue" name="pickupTimeValue" style="font-size: 18px;">
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
                  <label style="font-family: Comfortaa;" for="dropoffTimeValue">Dropoff Time:</label>
                  <br>
                  <select id="dropoffTimeValue" name="dropoffTimeValue" style="font-size: 18px;">
                    <option value="none"></option>
                    <option value="9:00:00">9:00 AM</option>
                    <option value="10:00:00">10:00 AM</option>
                    <option value="11:00:00">11:00 AM</option>
                    <option value="12:00:00">12:00 PM</option>
                    <option value="13:00:00">1:00 PM</option>
                    <option value="14:00:00">2:00 PM</option>
                    <option value="15:00:00">3:00 PM</option>
                    <option value="16:00:00">4:00 PM</option>
                    <option value="17:00:00">5:00 PM</option>
                  </select>
                  <br><br>
                  <label style="font-family: Comfortaa;" for="pickupLocationValue">Pick-Up Location:</label>
                  <br>
                  <select id="pickupLocationValue" name="pickupLocationValue" style="font-size:18px;">
                    <option value="none"></option>
                  <?php
                  //Get current pick up locations
                    $locationQuery = $conn->query("SELECT * FROM location_table WHERE pick_up_location=1");
                    while ($row = $locationQuery->fetch_assoc()) {
                        
                        $locationName = $row["name"];
                        $locationId = $row["location_id"];  
                    ?>
                    <!-- Loop and echo options into select -->
                    <?php echo '<option value="' . $locationId . '"> ' . $locationName . '</option>'?>
                    <?php
                    }
                    ?>
                  </select>
                  <br><br>
                  <label style="font-family: Comfortaa;" for="dropoffLocationValue">Drop-Off Location:</label>
                  <br>
                  <select id="dropoffLocationValue" name="dropoffLocationValue" style="font-size:18px;">
                    <option value="none"></option>
                  <?php
                    //Get current drop off locations
                    $locationQuery = $conn->query("SELECT * FROM location_table WHERE drop_off_location=1");
                    while ($row = $locationQuery->fetch_assoc()) {
                        $locationName = $row["name"];
                        $locationId = $row["location_id"];  
                    ?>
                    <!-- Loop and echo options into select -->
                    <?php echo '<option value="' . $locationId . '">' . $locationName . '</option>'?>
                    <?php
                    }
                    ?>
                  </select>
                  <br>
                <p style="font-size: 24px;display: inline-block;">Add Accessory:</p>
                <?php
                //Get accessory types
                $accessoryType = $conn->query("SELECT * FROM accessory_type_table");
                while ($row = $accessoryType->fetch_assoc()) {
                    $accessoryTypeId = $row["accessory_type_id"];
                    $accessoryTypeName = $row["name"];
                ?>
                <br>
                <?php 
                //Loop and echo all available accessory types
                  echo '<div id="addAccessoryContainer'. $accessoryTypeId .'">';
                  echo '<a style="font-size:18px;font-family: Comfortaa;color:black;font-weight:bold;" href="javascript: addAccessory(' . '\'' . $accessoryTypeName . '\'' . ', ' . '\'' . $accessoryTypeId . '\'' .     ')">Add ' . $accessoryTypeName . '</a>';
                  echo '</div>';
                ?>
                <?php
                }
                ?>
                <br>
                <!-- Empty containers to be filled by items -->
                    <p style="font-size: 24px;">Item List:</p>
                    <div id="itemListContainer" style="">
                      <p style="font-size: 20px;font-weight: bold;">Bikes:</p>
                      <div id="bikeListContainer" style="">
                      </div>
                     <p style="font-size: 20px;font-weight: bold;">Accessories:</p>
                      <div id="accessoryListContainer" style="">
                      </div>
                    </div>
					         <a style="font-size: 18px;color:black;" href="javascript:clearItems()"><p>Clear Items</p></a>                  
                  <input required type="checkbox" id="termsValue" name="termsValue" value="">
                  <label for="termsValue"> I have read and agreed to the <a href="javascript:openTerms()">terms and conditions.</a></label>
                  <br>
                  <center><input id="bookNowButton" type="submit" value="BOOK NOW" style="background-color:black;color:white;padding: 10px;text-align: center;font-size:24px;width: 100%;display:none"></center>
					       <br><br><br>
                </form>
            </div>
        </div>
        <!-- Current Cart Section -->
	        <div id="Column3">
	        	<h1>Current Cart:</h1>
	        	<div style="overflow-y: scroll;height: 1000px;padding-left: 10px;padding-right: 50px;">
                    <!-- Empty containers to be filled by items -->
                    <div id="cartContainer" style="">
                      <p style="font-size: 20px;font-weight: bold;">Bikes:</p>
                      <div id="bikeCart" style="">
                      </div>
                      <p style="font-size: 20px;font-weight: bold;">Accessories:</p>
                      <div id="accessoryCart" style="">
                      </div>
                    </div> 
	          </div>
	        </div>
        </div>
    </div>
    <br>
    <br>
    <br>
    <br>
    <!-- Terms and Conditions Pop Up - https://www.w3schools.com/howto/howto_css_modals.asp -->
    <div id="myModal" class="modal">
    <!-- Modal content -->
    <div class="modal-content" style="width: 75%;background-color: black;">
      <span class="close">&times;</span>
      <div style="background-color: white; overflow-y: scroll;padding: 50px;">
      <br><br>
      <center><h3><strong>INVERLOCH BIKE HIRE PTY LTD</strong></h3></center>
      <center><h3><strong> WAIVER &amp; RELEASE</strong></h3></center>
      <center><h3><em>ABN: 46 657 404 030</em></h3></center>
      <p><strong>Please read the following Bike Hire Agreement containing the Waiver &amp; Release, Rules, Terms &amp; Conditions of use carefully before signing this agreement. Your signature hereon is confirmation that you agree to adhere to the attached rules, terms and conditions of use and that you are indemnifying Inverloch Bike Hire, its representatives and agents from all claims, liabilities or actions. </strong></p>
      <p>1. I agree that I will adhere to all Rules, Terms &amp; Conditions of use detailed herein and in the Bike Hire Agreement. I further agree that I am liable and responsible for the actions of any third party named on this agreement who is under my care and supervision during the hire period. I will further ensure that any third party who is under my care and supervision during the hire period also adheres to all the Rules, Terms &amp; Conditions of use detailed herein. I acknowledge that I am responsible for the use and return of all bicycles and equipment supplied by Inverloch Bike Hire during the hire period. </p>
      <p>2.  I agree that I will adhere to all Victorian Laws, Road Rules and Road Regulations, including but not limited to <em> The Road Safety Act, Road Safety Rules, Road Regulations, Local Laws and Local By-Laws </em> during the hire period. I will also ensure that any third party who is under my care and supervision during the hire period will adhere to all Victorian Laws, Road Rules and Road Regulations, including but not limited to The Road Safety Act, Road Safety Rules, Road Regulations, Local Laws and Local By-Laws.</p>
      <p>3. For the purpose of this agreement, a <em>bicycle</em> refers to a bicycle, electric powered bicycle, scooter and electric powered scooter supplied by Inverloch Bike Hire during the hire period. For the purpose of this agreement, <em>equipment</em> refers to any item supplied by Inverloch Bike Hire including but not limited to helmets, locks, lights and any other item. For the purpose of this agreement, the <em>hire agreement</em> refers to the actual agreed times and dates of hire and return, of any bicycles and equipment supplied by Inverloch Bike Hire. For the purpose of this agreement, the <em>hire period</em> refers to the actual duration in possession, custody or control of bicycles or equipment supplied by Inverloch Bike Hire, notwithstanding the terms of the hire agreement. For the purposes of this agreement, a <em>third party</em> refers to a person aged between 13 years and 17 years referred to on the attached hire agreement, who is under my care and supervision during the hire period. </p>
      <p>4. I acknowledge that I am responsible for and will reimburse in full, the cost of any unreasonable damage, either accidental or intentional, caused to Inverloch Bike Hire bicycles or equipment during the hire period. <em><strong>I acknowledge that I am responsible for and will reimburse Inverloch Bike Hire in full, the replacement cost of any bicycles or equipment which are lost, sold, misappropriated or stolen during the hire period.</strong></em> </p>
      <p>5. I agree that I will <em><strong>not allow any other person, other than those named on this hire agreement, to use, ride or take possession of any bicycle or equipment belonging to Inverloch Bike Hire during the hire period.</strong></em></p>
      <p>6. <strong> I acknowledge that there are risks associated with the use of a bicycle, both foreseen and unforeseen, to myself and third parties including any third party under my care and supervision during the hire period.  These risks include the risk of injury, death and damage to property.</strong> By signing this waiver &amp; release I acknowledge that I am aware that these risks exist and having considered the seriousness of these risks, I voluntarily agree to participate in this activity at my own risk, and at risk to third parties, including any third party under my care and supervision. I agree that I will ride in a safe, responsible and lawful manner at all times, in order to minimise these risks. I agree that I will supervise and monitor any third party under my care and supervision, to ensure that they will ride in a safe, responsible and lawful manner at all times, in order to minimise these risks.</p>
      <p>7. By signing this waiver &amp; release, I unconditionally and irrevocably waive and indemnify Inverloch Bike Hire, its agents and representatives from all claims, liabilities or actions of any kind arising from or in any way related to my/our voluntary participation in the activities and services provided by Inverloch Bike Hire.  I acknowledge that Inverloch Bike Hire are acting in good faith, and that its agents and representatives are in no way liable for my actions, or the actions of any third party under my care and supervision, which may result in injury, death or damage to any person or property during the hire period.</p>
      <p>8. I acknowledge that <em><strong>I and any third party under my care and supervision will not ride in an unlawful, reckless, dangerous or careless manner during the hire period. If at any time during the hire period I believe the circumstances to ride a bicycle become unsafe, I and any third party under my care and supervision, will immediately discontinue the activity and contact Inverloch Bike Hire.</strong></em></p>
      <p>9. The lawful application of this waiver &amp; release, rules, terms and conditions remain in full force and effect throughout the duration of the hire period.</p>
      <p>10. I have read and understood the attached rules, terms, conditions, waiver &amp; release. I wilfully agree to adhere to all of these rules, terms, conditions, waiver &amp; release.</p>
      <p>11. I have signed this agreement freely and voluntarily, without duress, threat, inducement or promise. </p>
      <center><h3><strong>INVERLOCH BIKE HIRE AGREEMENT</strong></h3></center>
      <center><h3><strong><u>RULES, TERMS &amp; CONDITIONS</u></strong></h3></center>
      <p>I WILFULLY CONSENT AND AGREE TO THE FOLLOWING RULES, TERMS AND CONDITIONS:</p>
      <p>1. <strong>The terms of the Waiver &amp; release Agreement are incorporated into this Agreement.</strong></p>
      <p>2. <strong>I have entirely read, understand and agree to the attached rules, terms &amp; conditions of use.</strong></p>
      <p>3. Prior to the hire period commencing, I conducted an inspection of the bicycles and equipment supplied by Inverloch Bike Hire.  As a result of that inspection, I am satisfied that the bicycles and equipment are in safe working order. If at any stage during the hire period the condition of the bicycles or equipment changes or becomes unsafe, I will immediately stop and contact Inverloch Bike Hire.</p>
      <p>3. Prior to the hire period commencing, I conducted an inspection of the bicycles and equipment supplied by Inverloch Bike Hire.  As a result of that inspection, I am satisfied that the bicycles and equipment are in safe working order. If at any stage during the hire period the condition of the bicycles or equipment changes or becomes unsafe, I will immediately stop and contact Inverloch Bike Hire.</p>
      <p>5. Failure to return bicycles and equipment at the agreed time will incur a late fee of $55 per hour per bicycle until such time the bicycle and equipment are returned to Inverloch Bike Hire for inspection. </p>
      <p>6. I am capable of riding a bicycle safely and independently.</p>
      <p>7. I will adhere to all Victorian laws, road rules, road regulations and by-laws at all times during the hire period.</p>
      <p>8. I will wear the approved helmet provided, at all times whilst riding a bicycle during the hire period.</p>
      <p>9. <strong><em>I will not allow any other person to use, ride or take possession of a bicycle and/or equipment provided, at any time during the hire period.</em></strong> </p>
      <p>10.  I will not ride in an unlawful, reckless, dangerous or careless manner.</p>
      <p>11.  I will not ride on the beach or through salt water. </p>
      <p>12.  I will incur and reimburse Inverloch Bike Hire the cost of any repairs, damage, replacement, disassembly or comprehensive cleaning as result of riding on the beach, through sand or salt water.</p>
      <p>13.  I will incur and reimburse Inverloch Bike Hire, the cost in full of any lost, sold, stolen or misappropriated bicycles and equipment. </p>
      <p>14.  I will incur and reimburse any third-party costs of any claims, injury or damage caused as a result of my actions, or the actions of a third party under my care and supervision, either intentional, accidental or negligent, during the hire period. </p>
      <p style="color:red;">15.  ALCOHOL/DRUGS – I agree that I and any third party authorised by me to ride a hired bicycle shall not ride the bike whilst under the influence of drugs or alcohol. I shall accept full responsibility for any injury or damages incurred as a result of myself or any other party breaking this provision and indemnify Inverloch Bike Hire in respect to any liability incurred or loss or damage to the bike hired.</p>
      <p>16.  I acknowledge and accept that under NO circumstances am I or the nominated 3rd party to consent or authorise another 3rd party to use or ride a bike, a bike the subject of this agreement and both the nominated and authorised 3rd party shall indemnify Inverloch Bike Hire from any liability resulting from such an unauthorised use of a bike.</p>
      <p>17.  I will pay the costs of any infringement, fines or impoundments incurred during the agreed hire period. </p>
      <p>18.  EBike Hire: rider must be over above 18 years of age or over - proof of age required.</p>
      <p>19.  Bicycle Hire: must be 13 years of age or over - proof of age required.</p>
      <p><strong><u>THIRD PARTY ACKNOWLEDGEMENT</u></strong></p>
      <p>20.  I am the parent/guardian of third party participant/s.</p>
      <p>21.  I confirm that third party/parties are capable of riding a bicycle safely and independently.</p>
      <p>22.  I will maintain vigilance, care and supervision of any third party under my care or supervision at all times throughout the duration of the hire period.</p>
      <p>23.  I will ensure that any third party under my care and supervision will adhere to all rules, terms &amp; conditions as set out above.</p>
      <p>24.  I accept full responsibility and liability for the actions of the third party named hereon, whether unlawful, intentional, accidental or negligent, throughout the hire period.</p>
      <p><u>25. I will ensure that the third party wears the approved helmet provided, at all times whilst riding a bicycle during the hire period.</u></p>
      <br>
      <br>
      <br>
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
  // Function to clear current items in cart
  function clearItems(){
    //Get Values
    var bikeListContainer = document.getElementById("bikeListContainer");
    var accessoryListContainer = document.getElementById("accessoryListContainer");
    var bikeCart = document.getElementById("bikeCart");
    var accessoryCart = document.getElementById("accessoryCart");
    //Clear Values
    bikeCart.innerHTML = '';
    bikeListContainer.innerHTML = '';
    accessoryListContainer.innerHTML = '';
  }

</script>


<script type="text/javascript">
// Function to calculate duration
function calculateDuration(){
  //Get Values
  var pickUpTimeVar = document.getElementById("pickupTimeValue");
  var pickUpTimeText = pickUpTimeVar.options[pickUpTimeVar.selectedIndex].text;
  var pickUpTimeValue;
  //Assign values per time
  if (pickUpTimeText == "9:00 AM"){
    pickUpTimeValue = 1;
  }else if (pickUpTimeText == "10:00 AM"){
    pickUpTimeValue = 2;
  }else if (pickUpTimeText == "11:00 AM"){
    pickUpTimeValue = 3;
  }else if (pickUpTimeText == "12:00 PM"){
    pickUpTimeValue = 4;
  }else if (pickUpTimeText == "1:00 PM"){
    pickUpTimeValue = 5;
  }else if (pickUpTimeText == "2:00 PM"){
    pickUpTimeValue = 6;
  }else if (pickUpTimeText == "3:00 PM"){
    pickUpTimeValue = 7;
  }else if (pickUpTimeText == "4:00 PM"){
    pickUpTimeValue = 8;
  }
    //Get Values
  var dropOffTimeVar = document.getElementById("dropoffTimeValue");
  var dropOffTimeText = dropOffTimeVar.options[dropOffTimeVar.selectedIndex].text;
  var dropOffTimeValue;
    //Assign values per time
  if (dropOffTimeText == "9:00 AM"){
    dropOffTimeValue = 1;
  }else if (dropOffTimeText == "10:00 AM"){
    dropOffTimeValue = 2;
  }else if (dropOffTimeText == "11:00 AM"){
    dropOffTimeValue = 3;
  }else if (dropOffTimeText == "12:00 PM"){
    dropOffTimeValue = 4;
  }else if (dropOffTimeText == "1:00 PM"){
    dropOffTimeValue = 5;
  }else if (dropOffTimeText == "2:00 PM"){
    dropOffTimeValue = 6;
  }else if (dropOffTimeText == "3:00 PM"){
    dropOffTimeValue = 7;
  }else if (dropOffTimeText == "4:00 PM"){
    dropOffTimeValue = 8;
  }
  var durationValueTimes = dropOffTimeValue - pickUpTimeValue;
  var startDateValue = document.getElementById("startDateValue").value;
  var endDateValue = document.getElementById("endDateValue").value;
  // Remove AM/PM
  startDateValueDays = startDateValue.slice(-2);
  endDateValueDays = endDateValue.slice(-2);
  startDateValueDays = parseInt(startDateValueDays);
  endDateValueDays = parseInt(endDateValueDays);
  //Calculate Value
  var durationValueDates = endDateValueDays - startDateValueDays;
  var durationDatesTotalValueHours = durationValueDates * 24;
  var totalDuration = durationDatesTotalValueHours + durationValueTimes;
  //Function no longer used
  //return totalDuration;
}  

</script>


<script type="text/javascript">
  //Function to remove individual bike
  function removeBike(bikeTypeId){
    //Concat function call with bike ID variable
    var removeText = "remove";
    var removeCartText = "removecart";
    var removeId = removeText.concat(bikeTypeId);
    var removeCartId = removeCartText.concat(bikeTypeId);
    var bikeRemove = document.getElementById(removeId);
    var bikeCartRemove = document.getElementById(removeCartId);
    //Remove Values
    bikeRemove.innerHTML = '';
    bikeCartRemove.innerHTML = '';
    bikeRemove.remove();
    bikeCartRemove.remove();
  }

  //Function to remove individual accessory
  function removeAccessory(accessoryTypeId){
    //Concat function call with accessory id variable
    var removeText = "remove";
    var removeCartText = "removecart";
    var removeId = removeText.concat(accessoryTypeId);
    var removeCartId = removeCartText.concat(accessoryTypeId);
    var accesoryRemove = document.getElementById(removeId);
    var accessoryCartRemove = document.getElementById(removeCartId);
    //Remove Values
    accesoryRemove.innerHTML = '';
    accessoryCartRemove.innerHTML = '';
    accesoryRemove.remove();
    accessoryCartRemove.remove();
  }



</script>

<script type="text/javascript">

//Function to add bike 
 function addBike(bikeName, bikeTypeId, bikeInventoryCount){
  //Create bike data variables
  var bikeListContainer = document.getElementById("bikeListContainer");
  var testText = "bike";
  //Create bike id value to test 
  var testNum = testText.concat(bikeTypeId);
  //Get cart items in div for bike id
  var hasChild = bikeListContainer.querySelector("p#" + CSS.escape(testNum) + "") != null;
  var countInDiv = document.querySelectorAll("p#" + CSS.escape(testNum) + "").length;
  //Check if cart is empty, if in cart ignore
  if (hasChild == 1){
  }else{
    //Create and hide input to be submitted to the booking form
      var newTextInput = document.createElement("input");
      var bikeNameText = "bike";
      newTextInput.name = bikeNameText.concat(bikeTypeId);
      newTextInput.id = bikeNameText.concat(bikeTypeId);
      newTextInput.type = "text";
      newTextInput.value = bikeTypeId;
      newTextInput.readOnly = true;
      newTextInput.style.display = "none";
      //Create div to display item information to customer
      var bikeCartDiv = document.createElement("div");
      bikeCartDivText = bikeNameText.concat(bikeTypeId);
      bikeCartDivText2 = "removecart";
      bikeCartDiv.id = bikeCartDivText2.concat(bikeCartDivText);
      var cartText = document.createElement("p");
      cartText.innerHTML = bikeName;
      cartText.style.fontSize = "18px";
      //Append Input and Text to cart
      bikeCart.appendChild(bikeCartDiv);
      bikeCartDiv.appendChild(cartText);
      //Create remove bike button
      var bikeCartRemoveButton = document.createElement("a");
      //Concat function call
      bikeCartRemoveButton.innerHTML = "Remove";
      bikeCartRemoveButtonText = "bike";
      bikeCartRemoveButtonText2 = bikeCartRemoveButtonText.concat(bikeTypeId);
      bikeCartRemoveButtonText3 = "javascript:removeBike('";
      bikeCartRemoveButtonText4 = bikeCartRemoveButtonText3.concat(bikeCartRemoveButtonText2);
      bikeCartRemoveButtonText5 = "')";
      bikeCartRemoveButtonText6 = bikeCartRemoveButtonText4.concat(bikeCartRemoveButtonText5);
      bikeCartRemoveButton.href = bikeCartRemoveButtonText6;
      //Append function call button
      bikeCartDiv.appendChild(bikeCartRemoveButton);
      //Concat bike id to remove function call
      var bikeDiv = document.createElement("div");
      bikeDivText = bikeNameText.concat(bikeTypeId);
      bikeDivText2 = "remove";
      bikeDiv.id = bikeDivText2.concat(bikeDivText);
      //Create text to display information to customers
      var newBikeText = document.createElement("p");
      newBikeText.innerHTML = bikeName;
      var newBikeTextText = "bike";
      newBikeText.id = newBikeTextText.concat(bikeTypeId);
      //Append information and inputs to cart container
      bikeListContainer.appendChild(bikeDiv);
      bikeDiv.appendChild(newTextInput);
      bikeDiv.appendChild(newBikeText);
      //Create quantity select text
      newSelectText = document.createElement("p");
      newSelectText.innerHTML = "Quantity:&nbsp;";
      newSelectText.style.display = "inline-block";
      bikeDiv.appendChild(newSelectText);
      //Create array of quantity numbers
      var newArray = [];
      //Add inventory count to array
      for (var i = 1; i <= bikeInventoryCount; i++) {
          newArray.push([i]);
      }
      //Create quantity select field
      var newSelectList = document.createElement("select");
      newSelectText1 = "bike";
      newSelectText2 = "quantity";
      newSelectIDName1 = newSelectText1.concat(bikeTypeId);
      newSelectIDName2 = newSelectIDName1.concat(newSelectText2);
      newSelectList.id = newSelectIDName2;
      newSelectList.name = newSelectIDName2;
      //Loop through quantity array and add array values to select
      for (var i = 0; i < newArray.length; i++) {
          var option = document.createElement("option");
          option.value = newArray[i];
          option.text = newArray[i];
          newSelectList.appendChild(option);
      }
      //Append select to form with quantity
      bikeDiv.appendChild(newSelectList);
      //Create remove button
      var bikeRemoveButton = document.createElement("a");
      //Concat function call based on ID
      bikeRemoveButton.innerHTML = "Remove";
      bikeRemoveButtonText = "bike";
      bikeRemoveButtonText2 = bikeRemoveButtonText.concat(bikeTypeId);
      bikeRemoveButtonText3 = "javascript:removeBike('";
      bikeRemoveButtonText4 = bikeRemoveButtonText3.concat(bikeRemoveButtonText2);
      bikeRemoveButtonText5 = "')";
      bikeRemoveButtonText6 = bikeRemoveButtonText4.concat(bikeRemoveButtonText5);
      bikeRemoveButton.href = bikeRemoveButtonText6;
      //Append values to form and cart
      bikeDivBreak = document.createElement("br");
      bikeDiv.appendChild(bikeDivBreak);
      bikeDiv.appendChild(bikeRemoveButton);
    }
 }

//Function to add accessory to cart
 function addAccessory(accessoryName, accessoryTypeId){
  //Get accessory cart container
  var accessoryListContainer = document.getElementById("accessoryListContainer");
  var testText = "accessory";
  //Create accessory id value to test 
  var testNum = testText.concat(accessoryTypeId);
  //See if cart contains accessory
  var hasChild = accessoryListContainer.querySelector("p#" + CSS.escape(testNum) + "") != null;
  //If already in cart ignore
  if (hasChild == 1){
  }else{
    //Create input to add to form
  var newTextInput = document.createElement("input");
  var newAccessoryText = "accessory";
  newTextInput.id = newAccessoryText.concat(accessoryTypeId);
  newTextInput.name = newAccessoryText.concat(accessoryTypeId);
  newTextInput.type = "text";
  newTextInput.value = accessoryTypeId;
  newTextInput.readOnly = true;
  newTextInput.style.display = "none";
  //Create div to add accessory to
  var accessoryCartDiv = document.createElement("div");
  //Concat function call to remove from cart
  accessoryCartDivText = newAccessoryText.concat(accessoryTypeId);
  accessoryCartDivText2 = "removecart";
  accessoryCartDiv.id = accessoryCartDivText2.concat(accessoryCartDivText);
  //Create text to display to customer about accessory
  var cartText = document.createElement("p");
  cartText.innerHTML = accessoryName;
  cartText.style.fontSize = "18px";
  //Append to cart div
  accessoryCart.appendChild(accessoryCartDiv);
  accessoryCartDiv.appendChild(cartText);
  //Create link to remove from cart
  var accessoryCartRemoveButton = document.createElement("a");
  accessoryCartRemoveButton.innerHTML = "Remove";
  //Concat function call to remove accessory item
  accessoryCartRemoveButtonText = "accessory";
  accessoryCartRemoveButtonText2 = accessoryCartRemoveButtonText.concat(accessoryTypeId);
  accessoryCartRemoveButtonText3 = "javascript:removeAccessory('";
  accessoryCartRemoveButtonText4 = accessoryCartRemoveButtonText3.concat(accessoryCartRemoveButtonText2);
  accessoryCartRemoveButtonText5 = "')";
  accessoryCartRemoveButtonText6 = accessoryCartRemoveButtonText4.concat(accessoryCartRemoveButtonText5);
  accessoryCartRemoveButton.href = accessoryCartRemoveButtonText6;
  //Append remove from cart function call link
  accessoryCartDiv.appendChild(accessoryCartRemoveButton);

  //Create div for cart
  var accessoryDiv = document.createElement("div");
  accessoryDivText = newAccessoryText.concat(accessoryTypeId);
  //Concat function call to remove accessory item
  accessoryDivText2 = "remove";
  accessoryDiv.id = accessoryDivText2.concat(accessoryDivText);

  //Create text to display to customer about accessory
  var newAccessoryText = document.createElement("p");  
  newAccessoryText.innerHTML = accessoryName;
  newAccessoryText.style.fontSize = "20px";
  var newAccessoryTextText = "accessory"
  newAccessoryText.id = newAccessoryTextText.concat(accessoryTypeId);
  //Append input and text to accessory cart div
  document.getElementById("accessoryListContainer").appendChild(accessoryDiv);
  accessoryDiv.appendChild(newTextInput);
  accessoryDiv.appendChild(newAccessoryText);
  //Create remove button for accessory
  var accessoryRemoveButton = document.createElement("a");
  accessoryRemoveButton.innerHTML = "Remove";
  //Concat function call to remove accessory
  accessoryRemoveButtonText = "accessory";
  accessoryRemoveButtonText2 = accessoryRemoveButtonText.concat(accessoryTypeId);
  accessoryRemoveButtonText3 = "javascript:removeAccessory('";
  accessoryRemoveButtonText4 = accessoryRemoveButtonText3.concat(accessoryRemoveButtonText2);
  accessoryRemoveButtonText5 = "')";
  accessoryRemoveButtonText6 = accessoryRemoveButtonText4.concat(accessoryRemoveButtonText5);
  accessoryRemoveButton.href = accessoryRemoveButtonText6;
  //Append remove button to cart
  accessoryDiv.appendChild(accessoryRemoveButton);
  }
 }

</script>
<script type="text/javascript">
// Run calendar on load 
document.onload = initaliseCalendar();

//Function to set end date
function setEnd(){
      //Set second clicked date to change the end date
      $(".datetest[href]").attr("href", "javascript:changeEndDate()");
      //Change start date to green
      document.getElementsByClassName("active")[0].style.backgroundColor = "green";
      document.getElementsByClassName("active")[0].style.color = "white";
      //Set next click to reset
      document.getElementsByClassName("active")[0].parentNode.parentNode.href = "javascript:resetDates()";
}

//Function to set start date
function setStart(){
      //Set first cliked date to change the start date
      $(".datetest[href]").attr("href", "javascript:changeStartDate()");
}

//Function to set start and end dates
function finaliseCalendar(){
      //Aftter end date is changed make all calendar buttons reset calendar on click
      $(".datetest[href]").attr("href", "javascript:resetDates()");
      //change end date to red
      document.getElementsByClassName("active")[0].style.backgroundColor = "red";
      document.getElementsByClassName("active")[0].style.color = "white";
}


function resetDates(){
    //Get calendar values
      var dateContainer = document.getElementById("dateContainer");
      var allDates = dateContainer.getElementsByClassName("date");
      // Loop through the buttons and add the active class to the clicked date
      for (var i = 0; i < allDates.length; i++) {
        allDates[i].style.backgroundColor = "";
        allDates[i].style.color = "";
      }
      //Clear start and end date from form
      document.getElementById("endDateValue").value = document.getElementById("startDateValue").value;
      document.getElementById("startDateValue").value = "";
      document.getElementById("endDateValue").value = "";
      //Reset Calendar by calling functions allowing dates to be selected without reseting calendar 
      setStart();
      changeStartDate();
      setEnd();
}


function initaliseCalendar(){
  // Get variables
var dateContainer = document.getElementById("dateContainer");
var allDates = dateContainer.getElementsByClassName("date");
// Loop through the buttons and add the active class to the clicked date
for (var i = 0; i < allDates.length; i++) {
  allDates[i].addEventListener("click", function() {
    //Get curent active date
    var currentDates = document.getElementsByClassName("active");
    //Remove current active date
    currentDates[0].className = currentDates[0].className.replace(" active", "");
    // Add new active date 
    this.className += " active";
  });
  document.getElementById("startDateValue").value = document.getElementsByClassName("active")[0].id;
  document.getElementById("endDateValue").value = document.getElementsByClassName("active")[0].id;
}
}


function changeStartDate(){
// Display form values for start and end date
document.getElementById("startDateContainer").style.display = "block";
document.getElementById("endDateContainer").style.display = "block";
//Get variables
var dateContainer = document.getElementById("dateContainer");
var allDates = dateContainer.getElementsByClassName("date");
// Loop through the buttons and add the active class to the clicked date
for (var i = 0; i < allDates.length; i++) {
  allDates[i].addEventListener("click", function() {
        //Get curent active date
    var currentDates = document.getElementsByClassName("active");
        //Remove current active date
    currentDates[0].className = currentDates[0].className.replace(" active", "");
        // Add new active date 
    this.className += " active";
  });
  //Set values in form
  document.getElementById("startDateValue").value = document.getElementsByClassName("active")[0].id;
  document.getElementById("endDateValue").value = document.getElementsByClassName("active")[0].id;
}
  setEnd();
}

function changeEndDate(){
// Get variables
var dateContainer = document.getElementById("dateContainer");
var allDates = dateContainer.getElementsByClassName("date");
// Loop through the buttons and add the active class to the clicked date
for (var i = 0; i < allDates.length; i++) {
  allDates[i].addEventListener("click", function() {
            //Get curent active date
    var currentDates = document.getElementsByClassName("active");
            //Remove current active date
    currentDates[0].className = currentDates[0].className.replace(" active", "");
            // Add new active date 
    this.className += " active";
  });
    //Set values in form
  document.getElementById("startDateContainer").style.display = "block";
  document.getElementById("endDateContainer").style.display = "block";
  document.getElementById("endDateValue").value = document.getElementsByClassName("active")[0].id;
}
//Set Duration
setDuration();
finaliseCalendar();
}

//Function to set duration to 'overnight' when selecting multiple dates
function setDuration(){
  var start = document.getElementById("startDateValue").value;
  var end = document.getElementById("startDateValue").value;
  if (start === end){
    $('#durationValue').val('Overnight');
  }
}

</script>    
<script type="text/javascript">
  
/* https://www.w3schools.com/howto/howto_css_modals.asp */

// Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
function openTerms() {
  modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
</script>
</body>
</html>
<?php
if (isset($_SESSION['login-email'])) {
	echo '<script type="text/javascript">' . 
      'document.getElementById("bookNowButton").style.display = "block";' .
      '</script>';
    }
 ?>