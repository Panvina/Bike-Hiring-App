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
    <link rel="stylesheet" href="style/timetablejs.css">
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
            <div style="display: inline-block; ">
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
            <br>
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
            <h1 style="line-height: 0px; margin-bottom: 1.5%; margin-top: 2em; "><strong> Current Bookings: </strong></h1>
			<div class="timetable"></div>
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

                $custName = $row['name'];
                if (!in_array($custName, $tmpCustNames))
                {
                    $custCount++;
                    array_push($customerNames, "$custCount,$custName");
                    array_push($tmpCustNames, "$custName");
                }

                $startHour = substr($startTime, 0, 2);
                $startMinutes = substr($startTime, 3, 2);

                $endHour = substr($endTime, 0, 2);
                $endMinutes = substr($endTime, 3, 2);

                array_push($times, array(
                    "startHour" => $startHour,
                    "startMin" => $startMinutes,
                    "endHour" => $endHour,
                    "endMin" => $endMinutes,
                    "custId" => $custCount
                ));
            }

            // print_r($customerNames);
        ?>
    </body>
    <script src="scripts/timetable.js"></script>

    <script>
        var timetable = new Timetable();

        timetable.setScope(8, 18);

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
                    echo "{'id' : '1', 'name' : 'null'}";
                }
            ?>
        ]);

        // Date format = YYYY, MM, DD, HH, MM
        // timetable.addEvent('Sightseeing', 'Rotterdam', new Date(2015,7,17,9,00), new Date(2015,7,17,11,30));
        // timetable.addEvent('Zumba', 'Madrid', new Date(2015,7,17,12), new Date(2015,7,17,13));
        // timetable.addEvent('Zumbu', 'Madrid', new Date(2015,7,17,13,30), new Date(2015,7,17,15));
        // timetable.addEvent('Lasergaming', 'London', new Date(2015,7,17,17,45), new Date(2015,7,17,19,30));
        // timetable.addEvent('All-you-can-eat grill', 'New York', new Date(2015,7,17,21), new Date(2015,7,18,1,30));
        // timetable.addEvent('Hackathon', 'Tokyo', new Date(2015,7,17,11,30), new Date(2015,7,17,20));
        // timetable.addEvent('Tokyo Hackathon Livestream', 'Los Angeles', new Date(2015,7,17,12,30), new Date(2015,7,17,16,15));
        // timetable.addEvent('Lunch', 'Jakarta', new Date(2015,7,17,9,30), new Date(2015,7,17,11,45));
        // timetable.addEvent('Cocktails', 'Rotterdam', new Date(2015,7,18,00,00), new Date(2015,7,18,02,00));

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

                    echo "timetable.addEvent('$startHour:$startMin-$endHour:$endMin', '$custId', new Date($year, $month, $day, $startHour, $startMin), new Date($year, $month, $day, $endHour, $endMin));";
                }
            }
            else
            {
                echo "timetable.addEvent('No Bookings Founds', '1', new Date($year, $month, $day, 9), new Date($year, $month, $day, 17));";
            }
        ?>

        var renderer = new Timetable.Renderer(timetable);
        renderer.draw('.timetable');

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
    <script>
      (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
      function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
      e=o.createElement(i);r=o.getElementsByTagName(i)[0];
      e.src='//www.google-analytics.com/analytics.js';
      r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
      ga('create','UA-37417680-5');ga('send','pageview');
    </script>
</html>
