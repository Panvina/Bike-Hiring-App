<!--
Project Name: Inverloch Bike Hire
Project Description: A website for hiring bikes. Front-end accompanied
	   by an admin dashboard.
File Description: Show both the functions and locations information
Contributor(s):
	- Clement Cheung @ 103076376@student.swin.edu.au
	- Vina Touch @ 101928802@student.swin.edu.au
	- Jake Hipworth @ 102090870@student.swin.edu.au (Navigation section and Styles)
	- Dabin Lee @ icelasersparr@gmail.com.(the base layout, timetable integration, booking statistics, bike availability status, and date selector)
    - Aadesh Jagannathan @102072344@student.swin.edu.au (Urgent replacements)
-->
<?php
    include_once "php-scripts/backend-connection.php";
    include_once "php-scripts/utils.php";
    include_once "php-scripts/dashboard-script.php";
    include_once "php-scripts/bookings-db.php";
    include_once "php-scripts/bike-inventory-db.php";
    include_once "php-scripts/damaged-item-db.php";

    // dashboard side menu import (Dabin)
    include_once("php-scripts/dashboard-menu.php");

    // set date into URL if not set. Default to current date in server
    if (!isset($_GET["date"]))
    {
        $date = getCurrentDate();
        header("Location: dashboard.php?date=$date");
    }

    // get date from URL
    $date = $_GET["date"];
    
    //Assigns the session variable used for side nav. Added by Jake Hipworth 102090870
    $_SESSION["CurrentPage"] = "";
?>

<!--DOCTYPE html -->
<html>
    <link rel="stylesheet" href="style/dashboard-style.css">
    <link rel="stylesheet" href="style/main-dashboard-style.css">
    <link rel="stylesheet" href="style/timetablejs.css">
    <head>
        <!-- header -->
        <title> Admin dashboard </title>
        <div class ="flexDisplay">
            <h1 class="header"> <a href="index.php"><img src="img/photos/Inverloch_Logo3.png" alt="Inverloch Logo" id="Logo" /></a> Admin Dashboard </h1>
            <a id="webpageDirect" name = "webpageDirect" href= 'index.php'> Back to website </a>
        </div>
    </head>
    <body>
        <div class="grid-container">
        	<div class="menu">
        		<?php printMenu("dashboard"); ?>
        	</div>
        	<div class="main">
                <div class="date-grid">
                    <img class="arrows" id="leftArrow" onclick="decrementDate()" src="img/icons/arrow-left-bold.png"/>
                    <div>
                        <input id="date-picker" class="date-picker" type="date"></input>
                        <label class="date_string" for="dDate">
                            <?php
                                $date = $_GET["date"];
                                $dateStr = getFormattedDate($date);

                                echo "$dateStr";
                            ?>
                        </label>
                    </div>
                    <img class="arrows" id="rightArrow" onclick="incrementDate()" src="img/icons/arrow-right-bold.png"/>
                </div>
                <div class="DashboardInformationContainer">
                    <!-- Booking summary section -->
                    <div class="DashboardInformation dashboard-headers">
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
                                $res = $conn->getNumCheckedBikes();

                                echo $res;
                            ?>
                        </h3>
                        <h3>Pending Inspections:
                            <?php
                                // print number of unavailable bikes
                                $res = $conn->getNumUncheckedBikes();

                                echo $res;
                            ?>
                        </h3>
                    </div>
                </div>

                <!-- Current bookings section (Using open source GPL license timetable schedule, courtesy of Grible and friou) -->
                <h1 style="line-height: 0px; margin-bottom: 1.5%; margin-top: 2em; "><strong> Current Bookings: </strong></h1>
    			<div class="timetable"></div>
        	</div>
        </div>

        <?php
            $conn = new BookingsDBConnection();

            // create new DB connection and fetch rows for a given date
            $ymdDate = DateTime::createFromFormat("d-m-Y", $date);
            $strDate = $ymdDate->format("Y-m-d");
            $rows = $conn->getBookingRows("start_date='$strDate'");

            $numRows = count($rows);

            $customerNames = array();
            $tmpCustNames = array();
            $times = array();
            // print bookings
            $custCount = 0;
            for($i = 0; $i < $numRows; $i++)
            {
                // get current row
                $row = $rows[$i];

                $startTime = $row["start_time"];
                $endTime = $row["expected_end_time"];

                $startDate = $row["start_date"];
                $endDate = $row["end_date"];

                $custName = $row['name'];
                // if (!in_array($custName, $tmpCustNames))
                // {
                $custCount++;
                array_push($customerNames, "$custCount,$custName");
                array_push($tmpCustNames, "$custName");
                // }

                $startHour = substr($startTime, 0, 2);
                $startMinutes = substr($startTime, 3, 2);

                $endHour = substr($endTime, 0, 2);
                $endMinutes = substr($endTime, 3, 2);

                array_push($times, array(
                    "startHour" => $startHour,
                    "startMin" => $startMinutes,
                    "endHour" => $endHour,
                    "endMin" => $endMinutes,
                    "custId" => $custCount,
                    "startDate" => $startDate,
                    "endDate" => $endDate
                ));
            }

            // print_r($customerNames);
        ?>
    </body>
    <script src="scripts/dashboard.js"></script>
    <script src="scripts/timetable.js"></script>

    <script>
        // credit to https://github.com/friou/timetable.js
        var timetable = new Timetable();

        timetable.setScope(9, 17);

        timetable.addLocations([
            <?php
                // print customer names
                $numCustomers = count($customerNames);
                if ($numCustomers > 0)
                {
                    for($i = 0; $i < $numCustomers; $i++)
                    {
                        $cust = explode(',', $customerNames[$i]);
                        $id = $cust[0];
                        $name = $cust[1];
                        echo "{'id' : '$id', 'name' : '$name'}";
                        if ($i != $numCustomers - 1)
                        {
                            echo ", ";
                        }
                    }
                }
                else
                {
                    echo "{'id' : '1', 'name' : 'none'}";
                }
            ?>
        ]);

        <?php
            $today = date("Y/m/d");
            $year = substr("$today", 0, 4);
            $month = substr("$today", 5, 2);
            $day = substr("$today", 8, 2);

            $numBookings = count($times);
            if ($numBookings > 0)
            {
                for($i = 0; $i < $numBookings; $i++)
                {
                    $time = $times[$i];
                    $startHour = $time["startHour"];
                    $startMin = $time["startMin"];
                    $endHour = $time["endHour"];
                    $endMin = $time["endMin"];
                    $custId = $time["custId"];

                    if ($time["endDate"] != $time["startDate"]) {
                        $endHour = "17";
                        $endMin = "00";
                    }

                    echo "timetable.addEvent('$startHour:$startMin - $endHour:$endMin', '$custId', new Date($year, $month, $day, $startHour, $startMin), new Date($year, $month, $day, $endHour, $endMin));";
                }
            }
            else
            {
                echo "timetable.addEvent('No Bookings Founds', '1', new Date($year, $month, $day, 9), new Date($year, $month, $day, 17));";
            }
        ?>

        var renderer = new Timetable.Renderer(timetable);
        renderer.draw('.timetable');

        // Dabin's custom edge to edge timetable code
        var timeScope = document.getElementsByClassName("syncscroll").getElementsByTagName("header").getElementsByTagName("ul")[0];
        var timeScopeWidth = timeScope.offsetWidth;
        var timeScopeDiff = (17.0 - 9.0);
        var timeScopeSectionWidth = timeScopeWidth / timeScopeDiff;

        // add CSS styling into HTML
        var styleElem = document.head.appendChild(document.createElement("style"));
        styleElem.innerHTML =
            `.timetable > section > header li {
                flex: none;
                display: block;
                position: relative;
                width: ${timeScopeSectionWidth};
            }
            .timetable ul.room-timeline li:before {
                background-image: linear-gradient(90deg, #e5e5e5 1px, transparent 0);
                background-size: ${timeScopeSectionWidth/4}px auto;
            }
            .timetable ul.room-timeline li:after {
                background-image: linear-gradient(90deg, #e5e5e5, #e5e5e5 1px, #f4f4f4 0, #f4f4f4 2px, #e5e5e5 0, #e5e5e5 3px, transparent 0, transparent);
                background-size: ${timeScopeSectionWidth}px auto;
                background-position: -2px 0;
            }`;

        function decrementDate()
        {
            <?php
                // https://stackoverflow.com/questions/660501/simplest-way-to-increment-a-date-in-php
                $prevDay=strftime("%d-%m-%Y", strtotime("$date -1 day"));
            ?>
            window.location.replace("dashboard.php?date=<?php echo $prevDay ?>");
        }

        function incrementDate()
        {
            <?php
                $nextDay=strftime("%d-%m-%Y", strtotime("$date +1 day"));
            ?>
            window.location.replace("dashboard.php?date=<?php echo $nextDay ?>");
        }
    </script>
</html>
