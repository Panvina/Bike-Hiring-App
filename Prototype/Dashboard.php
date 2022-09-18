<!--
Project Name: Inverloch Bike Hire
Project Description: A website for hiring bikes. Front-end accompanied
	   by an admin dashboard.
File Description: Show both the functions and locations information
Contributor(s):
	- Clement Cheung @ 103076376@student.swin.edu.au
	- Vina Touch @ 101928802@student.swin.edu.au
	- Jake Hipworth @ 102090870@student.swin.edu.au (Navigation section and Styles)
	- Dabin Lee @ icelasersparr@gmail.com.
    - Aadesh Jagannathan @102072344@student.swin.edu.au (Urgent replacements)
-->
<?php
    include_once "php-scripts/backend-connection.php";
    include_once "php-scripts/utils.php";
    include_once "php-scripts/dashboard-script.php";
    include_once "php-scripts/bookings-db.php";
    include_once "php-scripts/bike-inventory-db.php";
    include_once "php-scripts/damaged-item-db.php";

    //enabling the user privilege of certain tabs. Added by Vina Touch 101928802
    include_once "user-privilege.php";

    // set date into URL if not set. Default to current date in server
    if (!isset($_GET["date"]))
    {
        $date = getCurrentDate();
        header("Location: dashboard.php?date=$date");
    }

    // get date from URL
    $date = $_GET["date"];
?>

<!--DOCTYPE html -->
<html>
    <link rel="stylesheet" href="style/Jake_style.css">
    <link rel="stylesheet" href="style/scheduleTimetableStyle.css">
    <head>
        <!-- header -->
        <title> Admin dashboard </title>
        <h1 class="header"> <a href="index.php"><img src="img/photos/Inverloch_Logo3.png" alt="Inverloch Logo" id="Logo" /></a> Admin Dashboard </h1>
    </head>
    <body>
        <!-- Side navigation -->
        <nav>
            <div class = "sideNavigation">
                <a class="active" href= "Dashboard.php"> <img src= "img/icons/bulletin-board.png" alt="Dashboard Logo" /> Dashboard </a> <br>
                <a href = "Customer.php"> <img src= "img/icons/account-group.png" alt="Customer Logo" />  Customer  </a> <br>
                <!-- <a href='staff.php'> <img src='img/icons/staff.png' alt='Staff Logo' /> Staff </a> <br>
                <a href="accounts.php"> <img src="img/icons/account.png" alt="Account logo"/> Accounts </a> <br> -->
                <?php setOwnerDashboardPrivilege(); ?>
                <a href= "Inventory.php"> <img src= "img/icons/bicycle.png" alt="Inventory Logo" />  Inventory </a> <br>
                <a href="Accessory.php"> <img src="img/icons/accessories.png" alt="Inventory Logo" /> Accessories </a> <br>
                <a href="BikeTypes.php"> <img src="img/icons/biketypes.png" alt="Bike Types Logo" /> Bike Types </a> <br>
                <a href="AccessoryTypes.php"> <img src="img/icons/accessorytypes.png" alt="Bike Types Logo" /> Accessory Types </a> <br>
                <a href= "bookings.php"> <img src= "img/icons/book-open-blank-variant.png" alt="Bookings Logo" /> Bookings </a> <br>
                <a href= "Block_Out_Date.php"> <img src= "img/icons/calendar.png" alt="Block out date Logo" /> Block Out Dates </a> <br>
                <a href= "Locations.php"> <img src= "img/icons/earth.png" alt="Locations Logo" /> Locations </a> <br>
                <a href= "editpages.php"> <img src= "img/icons/bulletin-board.png" alt="Edit Pages Logo" /> Edit </a> <br>
               <?php setLogoutButton(); ?>
            </div>
         </nav>
        <!-- Block of content in center -->
        <div class="Content">
            <div style="display: inline-block;">
                <label class="Date" for="dDate">
                    <?php
                        $date = $_GET["date"];
                        $dateStr = getFormattedDate($date);

                        echo "$dateStr";
                    ?>
                </label>
                <img id="rightArrow" onclick="incrementDate()" src="img/icons/arrow-right-bold.png"/>
                <!-- <img id="calendar" src="img/icons/calendar-blank.png"/> -->
                <img id="leftArrow" onclick="decrementDate()" src="img/icons/arrow-left-bold.png"/>
                <br>
             </div>
            <br>
            <!-- Section headings -->
            <h1 class="Headings"> Booking Summary </h1>
            <h1 class="Headings"> Urgent </h1>
            <h1 class="Headings"> Inventory Summary </h1>

            <div class="DashboardInformationContainer">
                <!-- Booking summary section -->
                <div class="DashboardInformation">
                    <h2> Booking Summary </h2>
                    <h3> Total Bookings:
                        <?php
                            // get total bookings for the day
                            $ymdDate = DateTime::createFromFormat("d-m-Y", $date);
                            $strDate = $ymdDate->format("Y-m-d");
                            $conn = new BookingsDBConnection();
                            $res = $conn->get("booking_id", "start_date='$strDate'");

                            echo count($res);
                        ?>
                    </h3>
                    <h3> Total Cancellations: 0</h3>
                </div>

                <!-- Urgent section -->
                <div class="DashboardInformation">
                    <h2>Urgent Replacements</h2>
                    <h3>Bikes: 
                    <?php
                            // print number of available accessories
                            $conn = new DamagedItemsDBConnection();
                            $res = $conn->getDamagedBikes();

                            echo count($res);
                        ?>
                    <h3>
                    <h3>Accessories: 
                    <?php
                            // print number of damaged accessories
                            $conn = new DamagedItemsDBConnection();
                            $res = $conn->getDamagedAccessories();

                            echo count($res);
                        ?>    
                    <h3>
                </div>
                <!-- Inventory Summary section -->
                <div class="DashboardInformation">
                    <h2>Inventory Summary</h2>
                    <h3>Available Bikes:
                        <?php
                            // print number of available bikes
                            $conn = new BikeInventoryDBConnection();
                            $res = $conn->getAvailableBikes();

                            echo count($res);
                        ?>
                    </h3>
                    <h3>Pending Inspections:
                        <?php
                            // print number of unavailable bikes
                            $res = $conn->getUnavailableBikes();

                            echo count($res);
                        ?>
                    </h3>
                </div>
            </div>
            <br>

            <!--This calendar section is done by Clement where it is showing the current bookings as an event scheduler and it is hard code since it is to demonstrate the potential type of thing-->
            <!-- Current bookings section -->
            <h1 style="line-height: 50px;"><strong> Current Bookings: </strong></h1>
			<div class="background">
    			<pre>
    			<!--keeping the schedule inside it-->
    			<div class="scheduleContainer">
    				<!-- TIMES -->
    				<div class="time start-900">9:00</div>
    				<div class="time start-930">9:30</div>
    				<div class="time start-1000">10:00</div>
    				<div class="time start-1030">10:30</div>
    				<div class="time start-1100">11:00</div>
    				<div class="time start-1130">11:30</div>
    				<div class="time start-1200">12:00</div>
    				<div class="time start-1230">12:30</div>
    				<div class="time start-1300">13:00</div>
    				<div class="time start-1330">13:30</div>
    				<div class="time start-1400">14:00</div>
    				<div class="time start-1430">14:30</div>
    				<div class="time start-1500">15:00</div>
    				<div class="time start-1530">15:30</div>
    				<div class="time start-1600">16:00</div>
    				<div class="time start-1630">16:30</div>
    				<div class="time start-1700">17:00</div>

    				<!-- EVENTS -->
    				<!--This is to sort in order of time start so the it can be shown cleanly-->


    				<!--Given the scenario where there is a lot of booking on this day-->
                    <?php
                        function intTimeToStringTime($hours, $minutes)
                        {
                            $leadingZeroHour = "";
                            // if ($hours < 10)
                            // {
                            //     $leadingZeroHour = "0";
                            // }

                            $leadingZeroMinute = "";
                            if ($minutes < 10)
                            {
                                $leadingZeroMinute = "0";
                            }

                            $hours = "$leadingZeroHour$hours";
                            $minutes = "$leadingZeroMinute$minutes";

                            $ret = "$hours:$minutes";
                            return $ret;
                        }

                        function constraintToThirty($time)
                        {
                            $hours = (int)(substr($time, 0, 2));
                            $minutes = (int)(substr($time, 3, 2));

                            if ($minutes < 15)
                            {
                                // round XX:14 or less down to XX:00
                                $minutes = 0;
                            }
                            else if ($minutes >= 15 && $minutes < 45)
                            {
                                // round (XX:15 - XX:44) to XX:30
                                $minutes = 30;
                            }
                            else
                            {
                                // round XX:45 or above to XX+1:00
                                $hours++;
                                $minutes = 0;
                            }

                            $ret = intTimeToStringTime($hours, $minutes);

                            return $ret;
                        }

                        $conn = new BookingsDBConnection();

                        // create new DB connection and fetch rows for a given date
                        $ymdDate = DateTime::createFromFormat("d-m-Y", $date);
                        $strDate = $ymdDate->format("Y-m-d");
                        $rows = $conn->getBookingRows("start_date='$strDate'");

                        $numRows = count($rows);
                        // print bookings
                        for($i = 0; $i < $numRows; $i++)
                        {
                            echo "";
                            // get current row
                            $row = $rows[$i];

                            $startTime = constraintToThirty($row["start_time"]);
                            $endTime = constraintToThirty($row["expected_end_time"]);
                            $startDate = $row["start_date"];
                            $endDate = $row["end_date"];

                            if ($startDate != $endDate)
                            {
                                $endTime = "17:00";
                            }
                            else if ($startTime == $endTime)
                            {
                                $endTimeHour = (int)substr($endTime, 0, 2);
                                $endTimeMinute = (int)substr($endTime, 3, 2);

                                if ($endTimeMinute == 0)
                                {
                                    $endTimeMinute = 30;
                                }
                                else
                                {
                                    $endTimeMinute = 0;
                                    $endTimeHour++;
                                }

                                $endTime = intTimeToStringTime($endTimeHour, $endTimeMinute);
                            }
                            $custName = $row['name'];

                            $startTimeNoColon = str_replace(":", "", $startTime);
                            $endTimeNoColon = str_replace(":", "", $endTime);
                            echo "<div class='event stage-bookings start-$startTimeNoColon end-$endTimeNoColon length-1'>$custName<br/>$startTime-<br/>$endTime</div>";
                        }
                    ?>
    			</div>
            </pre>
		</div>

    </body>
    <script>
        function decrementDate()
        {
            // alert("Test");
            <?php
                // https://stackoverflow.com/questions/660501/simplest-way-to-increment-a-date-in-php
                $prevDay=strftime("%d-%m-%Y", strtotime("$date -1 day"));
            ?>
            window.location.replace("dashboard.php?date=<?php echo $prevDay ?>");
            // window.location.load(true);
        }

        function incrementDate()
        {
            // alert("Test");
            <?php
                $nextDay=strftime("%d-%m-%Y", strtotime("$date +1 day"));
            ?>
            window.location.replace("dashboard.php?date=<?php echo $nextDay ?>");
        }
    </script>
</html>
