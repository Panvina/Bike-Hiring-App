<?php
    include_once "bookings-db.php";
    include_once "customer-db.php";
    include_once "locations-db.php";
    include_once "utils.php";

    session_start();
    $_SESSION['id'] = '123';
?>

<!DOCTYPE html>
<html>
    <link rel="stylesheet" href="style/Jake_style.css">
    <head>
        <!-- Header -->
        <title> Bookings </title>
        <h1 class="header"> <img src="img/photos/Inverloch_Logo3.png" alt="Inverloch Logo" id="Logo"/> Bookings </h1>
    </head>
    <body>
        <!-- Booking Popup (main) -->
        <div id="add-booking-main-modal" class="add-booking-modal" style="display: none;">
            <div class="add-booking-modal-content">
                <!-- booking form -->
                <form action="booking-popups.php" method="POST">
                    <!-- Select customer -->
                    <label>Customer:</label><br>
                    <select name="add-booking-customer" id="add-booking-customer"><br><br>
                        <?php
                            // Populate customer combo box with all customers
                            $conn = new CustomerDBConnection();
                    		$customerList = $conn->get("cust_id, name");

                    		if ($customerList != null)
                    		{
                                arrayToComboBoxOptions($customerList, "cust_id");
                    		}
                        ?>
                    </select><br><br>

                    <!-- Select start of booking -->
                    <label>Start Date</label><br>
                    <input name="add-booking-start-date" id="add-booking-start-date" type="date"><br><br>
                    <label>Start Time</label><br>
                    <input name="add-booking-start-time" id="add-booking-start-time" type="time" min="09:00" max="17:00"><br><br>

                    <!-- Select end of booking -->
                    <label>End Date</label><br>
                    <input name="add-booking-end-date" id="add-booking-end-date" type="date"><br><br>
                    <label>End Time</label><br>
                    <input name="add-booking-end-time" id="add-booking-end-time" type="time" min="09:00" max="17:00"><br><br>

                    <!-- Select pickup and dropoff locations -->
                    <label>Pick-Up Location</label><br>
                    <select name="add-booking-pick-up-location" id="add-booking-pick-up-location"><br><br>
                        <?php
                            // Populate list of pickup locations
                            $conn = new LocationsDBConnection();
                            $pickupLocations = $conn->get("location_id, name", "pick_up_location=1");

                            if ($pickupLocations != null)
                            {
                                arrayToComboBoxOptions($pickupLocations, "location_id");
                            }
                        ?>
                    </select><br><br>
                    <label>Drop-off Location</label><br>
                    <select name="add-booking-drop-off-location" id="add-booking-drop-off-location"><br><br>
                        <?php
                            // Populate list of dropoff locations
                            $pickupLocations = $conn->get("location_id, name", "drop_off_location=1");

                            if ($pickupLocations != null)
                            {
                                arrayToComboBoxOptions($pickupLocations, "location_id");
                            }
                        ?>
                    </select><br><br>

                    <button type="submit" name="add-booking-main-submit"> Select Bikes </button>
                </form>
            </div>
        </div>
        <div id="add-booking-bike-modal" class="add-booking-modal">
            <div id="add-booking-bike-modal-content" class="add-booking-bike-modal-content" style="display: block;">
                <form action="booking-popups.php" method="POST">

                    <button type="submit" name="add-booking-bike-submit"> Add Booking </button>
                </form>
            </div>
        </div>
        <!-- Side navigation -->
        <nav>
            <div class = "sideNavigation">
                <a href = "Dashboard.php"> <img src= "img/icons/bulletin-board.png" alt="Dashboard Logo" /> Dashboard </a> <br>
                <a href = "Customer.php"> <img src= "img/icons/account-group.png" alt="Customer Logo" />  Customer  </a> <br>
                <a href="staff.php"> <img src="img/icons/staff.png" alt="Staff Logo" /> Staff </a> <br>   
                <a href= "Inventory.php"> <img src= "img/icons/bicycle.png" alt="Inventory Logo" />  Inventory </a> <br>
                <a class="active" href= "Bookings.php"> <img src= "img/icons/book-open-blank-variant.png" alt="Bookings Logo" /> Bookings </a> <br>
                <a href= "Block_Out_Date.php"> <img src= "img/icons/calendar.png" alt="Block out date Logo" /> Block Out Dates </a> <br>
                <a href= "Locations.php"> <img src= "img/icons/earth.png" alt="Locations Logo" /> Locations </a> <br>
            </div>
         </nav>
         <!-- Block of content in center -->
         <div class="Content">
            <h1> All Bookings </h1>

            <!-- Search bar with icons -->
            <img src="img/icons/account-search.png" alt="Customer Search Logo"/>
            <input type="text"  placeholder="Search">

            <!-- Add Booking pop up -->
            <button type="button">+ Add Booking</button>

            <!-- List of available bookings -->
            <table class="TableContent">
                <tr>
                    <!-- Populate table header -->
                    <?php
                        // Declare columns and create array
                        $cols = "Booking ID,Bike Name,Customer Name,Start Date,Start Time,End Date,End Time,Duration,Pick Up,Drop Off,Price($)";
                        $cols = explode(',', $cols);

                        // Get number of columns
                        $count = count($cols);

                        // print_r($cols);
                        // echo "<br>";

                        // Print data as a HTML table header
                        for($x = 0; $x < $count; $x++)
                        {
                            $col = trim($cols[$x]);
                            echo "<th> $col </th>";
                        }
                    ?>
                </tr>

                <!-- Populate table data rows -->
                <?php
                    // create new DB connection and fetch rows
                   $conn = new BookingsDBConnection();
                   $rows = $conn->getBookingRows();

                   // if no rows are returned, create a null row as a placeholder
                   if ($rows == null)
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
    </body>
</html>
<script></script>
