
 <!--
 Project Name: Inverloch Bike Hire
 Project Description: A website for hiring bikes. Front-end accompanied
		by an admin dashboard.
 File Description: HTML description for bookings page in administrator dashboard.
 Contributor(s): Dabin Lee @ icelasersparr@gmail.com (PHP), Jake Hipworth (HTML)
-->


<?php
    include_once "php-scripts\bookings-db.php";
    include_once "php-scripts\customer-db.php";
    include_once "php-scripts\locations-db.php";
    include_once "php-scripts\accessory-inventory-db.php";
    include_once "php-scripts\bike-inventory-db.php";
    include_once "php-scripts\utils.php";

    session_start();
    $_SESSION['id'] = '123';

    $bookingMode = "none";
    if (isset($_GET["booking-mode"]))
    {
        $bookingMode = $_GET["booking-mode"];
    }
?>

<!DOCTYPE html>
<html>
    <link rel="stylesheet" href="style/Jake_style.css">
    <link rel="stylesheet" href="style/popup.css">
    <head>
        <!-- Header -->
        <title> Bookings </title>
        <h1 class="header"> <img src="img/photos/Inverloch_Logo3.png" alt="Inverloch Logo" id="Logo"/> Bookings </h1>
    </head>
    <body>
        <!-- Booking Popup (main) -->
        <div id="add-booking-main-modal" class="modal-overlay"
            <?php
                $mainModalBookingModes = ["invalid"];
                if (!in_array($bookingMode, $mainModalBookingModes))
                {
                    echo "style='display: none';";
                }
                else
                {
                    echo "style='display: block';";
                }
            ?>
            >
            <div class="modal-content">
                <span class="close-btn">&times;</span>
                <h2> Add Booking - Booking Details </h2>
                <!-- booking form -->
                <form action="php-scripts\booking-popups.php" method="POST">
                    <!-- Select customer -->
                    <label>Customer:</label><br>
                    <select name="add-booking-customer" id="add-booking-customer"><br><br>
                        <?php
                            // Populate customer combo box with all customers
                            $conn = new CustomerDBConnection();
                    		$customerList = $conn->get("user_name, name");

                    		if ($customerList != null)
                    		{
                                arrayToComboBoxOptions($customerList, "user_name");
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

        <!-- Form for adding bikes and accessories to bookings -->
        <div id="add-booking-bikes-modal" class="modal-overlay"
        <?php
            if ($bookingMode != "stage2")
            {
                echo "style='display: none';";
            }
            else
            {
                echo "style='display: block';";
            }
        ?>
        >
            <!-- Modal content for bikes and accessories -->
            <div class="modal-content">
                <span class="close-btn">&times;</span>
                <h2> Add Booking - Bikes and Accessories </h2>
                <!-- Form for submitting selections to PHP -->
                <form action="php-scripts\booking-popups.php" method="POST">
                    <!-- Bike list -->
                    <p>To select multiple values for either bikes or accessories, hold CTRL while clicking.</p>
                    <label>Bikes</label><br>
                    <!-- Get bikes as array (for PHP) -->
                    <select name="add-booking-bike[]" id="add-booking-bike" multiple><br><br>
                        <?php
                            // Get DB connection object
                            $conn = new BikeInventoryDBConnection();

                            // Populate list of dropoff locations
                            $bikes = $conn->get("bike_id, name");

                            if ($bikes != null)
                            {
                                arrayToComboBoxOptions($bikes, "bike_id");
                            }
                        ?>
                    </select><br><br>
                    <!-- Accessory list -->
                    <label>Accessories</label><br>
                    <!-- Get accessories as array (for PHP) -->
                    <select name="add-booking-accessory[]" id="add-booking-accessory" multiple><br><br>
                        <?php
                            // Get DB connection object
                            $conn = new AccessoryInventoryDBConnection();

                            // Populate list of dropoff locations
                            $accessories = $conn->get("accessory_id, name");

                            if ($accessories != null)
                            {
                                arrayToComboBoxOptions($accessories, "accessory_id");
                            }
                        ?>
                    </select><br><br>
                    <button type="submit" name="add-booking-bike-accessory-submit"> Add Booking </button>
                </form>
            </div>
        </div>

        <!--
            Change Booking Popup (main)

            Workflow:
                Select new start/end dates/times -> select all new accessories and bikes.
                Same start/end dates/times -> Retrieve current bookings/accessories
        -->
        <div id="change-booking-main-modal" class="modal-overlay"
            <?php
                $mainModalBookingModes = ["change"];
                if (!in_array($bookingMode, $mainModalBookingModes))
                {
                    echo "style='display: none';";
                }
                else
                {
                    echo "style='display: block';";
                }
            ?>
            >
            <div class="modal-content">
                <span class="close-btn">&times;</span>
                <h2> Modify Booking - Booking Details </h2>

                <?php
                    // Retrieve booking information to pre-populate form
                    if (isset($_SESSION["changeBooking"]))
                    {
                        // customer data
                        $custId =      $_SESSION["changeBooking"]["custId"];
                        $custName =    $_SESSION["changeBooking"]["custName"];

                        // booking time and date
                        $startTime =   $_SESSION["changeBooking"]["startTime"];
                        $endTime =     $_SESSION["changeBooking"]["endTime"];
                        $startDate =   $_SESSION["changeBooking"]["startDate"];
                        $endDate =     $_SESSION["changeBooking"]["endDate"];

                        // pick-up and drop-off location information
                        $pickupId =    $_SESSION["changeBooking"]["pickupId"];
                        $pickupName =  $_SESSION["changeBooking"]["pickupName"];
                        $dropoffId =   $_SESSION["changeBooking"]["dropoffId"];
                        $dropoffName = $_SESSION["changeBooking"]["dropoffName"];
                    }
                ?>

                <!-- booking form -->
                <form action="php-scripts\booking-popups.php" method="POST">
                    <!-- Display customer (non-modifiable) -->
                    <label>Customer:</label><br>
                    <select name="add-booking-customer" id="add-booking-customer" disabled>
                        <?php
                            // Populate customer combo box with all customers
                            $conn = new CustomerDBConnection();
                    		$customerList = $conn->get("user_name, name");

                    		if ($customerList != null)
                    		{
                                arrayToComboBoxOptions($customerList, "user_name", $custId);
                    		}
                        ?>
                    </select><br><br>

                    <!-- Select start of booking -->
                    <label>Start Date</label><br>
                    <input name="change-booking-start-date" id="change-booking-start-date" type="date" value=<?php echo "$startDate"; ?>><br><br>
                    <label>Start Time</label><br>
                    <input name="change-booking-start-time" id="change-booking-start-time" type="time" min="09:00" max="17:00" value=<?php echo "$startTime"; ?>><br><br>

                    <!-- Select end of booking -->
                    <label>End Date</label><br>
                    <input name="change-booking-end-date" id="change-booking-end-date" type="date" value=<?php echo "$endDate"; ?>><br><br>
                    <label>End Time</label><br>
                    <input name="change-booking-end-time" id="change-booking-end-time" type="time" min="09:00" max="17:00" value=<?php echo "$endTime"; ?>><br><br>

                    <!-- Select pickup and dropoff locations -->
                    <label>Pick-Up Location</label><br>
                    <select name="change-booking-pick-up-location" id="change-booking-pick-up-location"><br><br>
                        <?php
                            // Populate list of pickup locations
                            $conn = new LocationsDBConnection();
                            $pickupLocations = $conn->get("location_id, name", "pick_up_location=1");

                            if ($pickupLocations != null)
                            {
                                arrayToComboBoxOptions($pickupLocations, "location_id", $pickupId);
                            }
                        ?>
                    </select><br><br>
                    <label>Drop-off Location</label><br>
                    <select name="change-booking-drop-off-location" id="change-booking-drop-off-location"><br><br>
                        <?php
                            // Populate list of dropoff locations
                            $pickupLocations = $conn->get("location_id, name", "drop_off_location=1");

                            if ($pickupLocations != null)
                            {
                                arrayToComboBoxOptions($pickupLocations, "location_id", $dropoffId);
                            }
                        ?>
                    </select><br><br>
                    <button type="submit" name="change-booking-main-submit"> Select Bikes </button>
                </form>
            </div>
        </div>

        <!-- Form for adding bikes and accessories to bookings -->
        <div id="change-booking-bikes-modal" class="modal-overlay"
        <?php
            if ($bookingMode != "change-stage2")
            {
                echo "style='display: none';";
            }
            else
            {
                echo "style='display: block';";
            }
        ?>
        >
            <!-- Modal content for bikes and accessories -->
            <div class="modal-content">
                <span class="close-btn">&times;</span>
                <h2 >Modify Booking - Bikes and Accessories </h2>
                <!-- Form for submitting selections to PHP -->
                <form action="php-scripts\booking-popups.php" method="POST">
                    <!-- Bike list -->
                    <p>To select multiple values for either bikes or accessories, hold CTRL while clicking.</p>
                    <label>Bikes</label><br>
                    <!-- Get bikes as array (for PHP) -->
                    <select name="change-booking-bike[]" id="change-booking-bike" multiple><br><br>
                        <?php
                            // Get DB connection object
                            $conn = new BikeInventoryDBConnection();

                            // Populate list of dropoff locations
                            $bikes = $conn->get("bike_id, name");

                            if ($bikes != null)
                            {
                                arrayToComboBoxOptions($bikes, "bike_id");
                            }
                        ?>
                    </select><br><br>
                    <!-- Accessory list -->
                    <label>Accessories</label><br>
                    <!-- Get accessories as array (for PHP) -->
                    <select name="change-booking-accessory[]" id="change-booking-accessory" multiple><br><br>
                        <?php
                            // Get DB connection object
                            $conn = new AccessoryInventoryDBConnection();

                            // Populate list of dropoff locations
                            $accessories = $conn->get("accessory_id, name");

                            if ($accessories != null)
                            {
                                arrayToComboBoxOptions($accessories, "accessory_id");
                            }
                        ?>
                    </select><br><br>
                    <button type="submit" name="change-booking-bike-accessory-submit"> Submit Changes </button>
                </form>
            </div>
        </div>
        <!-- Side navigation -->
        <nav>
            <div class = "sideNavigation">
                <a href = "Dashboard.php"> <img src= "img/icons/bulletin-board.png" alt="Dashboard Logo" /> Dashboard </a> <br>
                <a href = "Customer.php"> <img src= "img/icons/account-group.png" alt="Customer Logo" />  Customer  </a> <br>
                <a href="staff.php"> <img src="img/icons/staff.png" alt="Staff Logo" /> Staff </a> <br>   
                <a href="accounts.php"> <img src="img/icons/account.png" alt="Account logo"/> Accounts </a> <br> 
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

            <div>
                <!-- Add Booking pop up -->
                <button type="button" id="add-booking-btn">+ Add Booking</button>

                <!-- Change Booking pop up -->
                <form action="php-scripts\booking-popups.php" method="POST">
                    <button type="submit" name="change-booking-btn" value="change,27">Modify Booking</button>
                </form>
                <!-- Delete booking button -->
                <form action="php-scripts\booking-popups.php" method="POST">
                    <button type="submit" name="delete-booking-btn" value="delete,27">Delete Booking</button>
                </form>
            </div>

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
        <script src="scripts/bookings.js"></script>
    </body>
</html>
