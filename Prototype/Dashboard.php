<?php
    session_start();

    include_once "php-scripts/backend-connection.php";
    include_once "php-scripts/utils.php";
    include_once "php-scripts/dashboard-script.php";
    include_once "php-scripts/bookings-db.php";
    include_once "php-scripts/bike-inventory-db.php";

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
    <head>
        <!-- header -->
        <title> Admin dashboard </title>
        <h1 class="header"> <img src="img/photos/Inverloch_Logo3.png" alt="Inverloch Logo" id="Logo" /> Admin Dashboard </h1>
    </head>
    <body>
        <!-- Side navigation -->
        <nav>
            <div class = "sideNavigation">
                <a class="active" href= "Dashboard.php"> <img src= "img/icons/bulletin-board.png" alt="Dashboard Logo" /> Dashboard </a> <br>
                <a href = "Customer.php"> <img src= "img/icons/account-group.png" alt="Customer Logo" />  Customer  </a> <br>
                <a href="staff.php"> <img src="img/icons/staff.png" alt="Staff Logo" /> Staff </a> <br>
                <a href= "Inventory.php"> <img src= "img/icons/bicycle.png" alt="Inventory Logo" />  Inventory </a> <br>
                <a href="Accessory.php"> <img src="img/icons/accessories.png" alt="Inventory Logo" /> Accessories </a> <br>
                <a href="BikeTypes.php"> <img src="img/icons/biketypes.png" alt="Bike Types Logo" /> Bike Types </a> <br>
                <a href="AccessoryTypes.php"> <img src="img/icons/accessorytypes.png" alt="Bike Types Logo" /> Accessory Types </a> <br>
                <a href= "bookings.php"> <img src= "img/icons/book-open-blank-variant.png" alt="Bookings Logo" /> Bookings </a> <br>
                <a href= "Block_Out_Date.php"> <img src= "img/icons/calendar.png" alt="Block out date Logo" /> Block Out Dates </a> <br>
                <a href= "Locations.php"> <img src= "img/icons/earth.png" alt="Locations Logo" /> Locations </a> <br>
                <a href= "editpages.php"> <img src= "img/icons/bulletin-board.png" alt="Edit Pages Logo" /> Edit </a> <br>
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
                    <h2>URGENT</h2>
                    <h3>Needing Replacement:

                    </h3>
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

            <!-- Current bookings section -->
            <h1 style="line-height: 100px;"> Current Bookings: </h1>
            <div>
                <table>
                    <?php
                        $conn = new BookingsDBConnection();
                        // Print table header
                        // Declare columns and create array
                        $cols = $conn->getBookingDisplayColumns();
                        $cols = explode(',', $cols);

                        // Get number of columns
                        $count = count($cols);

                        // Print data as a HTML table header
                        for($x = 0; $x < $count; $x++)
                        {
                            $col = trim($cols[$x]);
                            echo "<th> $col </th>";
                        }

                        // create new DB connection and fetch rows
                        $ymdDate = DateTime::createFromFormat("d-m-Y", $date);
                        $strDate = $ymdDate->format("Y-m-d");
                        $rows = $conn->getBookingRows("start_date='$strDate'");

                        // if no rows are returned, create a null row as a placeholder
                        if (count($rows) == 0)
                        {
                            $rows = array();
                            $tmp = array();
                            for($x = 0; $x < count($cols); $x++)
                            {
                                array_push($tmp, "null");
                            }
                            array_push($rows, $tmp);
                        }

                        // get keys for each row
                        // at least one row exists due to if-statement above
                        $keys = array_keys($rows[0]);
                        for($x = 0; $x < count($rows); $x++)
                        {
                            // create data row
                            echo "<tr>";
                            for($y = 0; $y < count($keys); $y++)
                            {
                                // get row and key
                                $row = $rows[$x];
                                $key = $keys[$y];

                                // retrieve data from above row for given key
                                $data = $row[$key];
                                echo "<td> $data </td>";
                            }
                            echo "</tr>";
                        }
                    ?>
                </table>
            </div>
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
