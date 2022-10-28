<?php
    include_once "php-scripts\bookings-db.php";
    include_once "php-scripts\customer-db.php";
    include_once "php-scripts\locations-db.php";
    include_once "php-scripts\accessory-inventory-db.php";
    include_once "php-scripts\bike-inventory-db.php";
    include_once "php-scripts\utils.php";
    include_once "php-scripts\booking-popups.php";

    // dashboard side menu import (Dabin)
    include_once("php-scripts/dashboard-menu.php");

    if (!isset($_SESSION)){
        session_start();
    }

     //Assigns the session variable used for side nav. Added by Jake Hipworth 102090870
    $_SESSION["CurrentPage"] = "";

    $_SESSION['id'] = '123';

    $bookingMode = "none";  // direct booking-mode variable from GET
    $opMode = "none";       // operation being performed (bookingMode is usually subset of this)
    $rescode = "none";      // result code (send with booking-mode from server)
    $rescodes = array();    // result code array (list of all codes from server)

    // these are to determine what booking modes belong to add, change, or delete
    $addBookingModes = array("add1", "add2", "addBooking");
    $changeBookingModes = array("change1", "change2", "changeBooking");
    $deleteBookingModes = array("delete", "deleteBooking");

    // get data from current booking mode for error handling
    if (isset($_GET["booking-mode"]))
    {
        $bookingErrorData = explode('-', $_GET["booking-mode"]);
        $bookingMode = $bookingErrorData[0];
        $rescode = $bookingErrorData[1];

        if ($rescode == "success")
        {
            $rescodes = array("success");
        }

        if (in_array($bookingMode, $addBookingModes))
        {
            $opMode = "addBooking";

            if ($rescode == "error")
            {
                $rescodes = explode(",", $_SESSION[$opMode]["error"]);
            }
        }
        else if (in_array($bookingMode, $changeBookingModes))
        {
            $opMode = "changeBooking";

            if ($rescode == "error")
            {
                // print_r( $_SESSION[$opMode]["error"]);
                $rescodes = explode(",", $_SESSION[$opMode]["error"]);
            }
        }
        else if (in_array($bookingMode, $deleteBookingModes))
        {
            $opMode = "deleteBooking";

            if ($rescode == "error")
            {
                // print_r( $_SESSION[$opMode]["error"]);
                $rescodes = explode(",", $_SESSION[$opMode]["error"]);
            }
        }
    }
?>

<html>
    <link rel="stylesheet" href="style/dashboard-style.css">
    <link rel="stylesheet" href="style/popup.css">
    <head>
        <!-- Header -->
        <title> Bookings </title>
        <div class ="flexDisplay">
        <h1 class="header"> <a href="index.php"><img src="img/photos/Inverloch_Logo3.png" alt="Inverloch Logo" id="Logo" /></a> Bookings </h1>
        <a id="webpageDirect" name = "webpageDirect" href= 'index.php'> Back to website </a>
    </div>
    </head>
    <body>
        <div class="grid-container">
            <div class="menu">
                <?php printMenu("bookings"); ?>
            </div>
            <div class="main">
                <?php
                    // get operation string
                    $opStr = "none";
                    switch($opMode)
                    {
                        case "addBooking":
                            $opStr = "created";
                            break;
                        case "changeBooking":
                            $opStr = "updated";
                            break;
                        case "deleteBooking":
                            $opStr = "deleted";
                            break;
                    }

                    // print success message
                    if (in_array("success", $rescodes))
                    {
                        echo "<p class='echo'>Record successfully $opStr</p>";
                    }
                ?>
                <h1 id="content-header"> All Bookings </h1>
                <div class="midbar">
                    <form id="midbar-form" action='php-scripts/booking-popups.php' method='POST'>
                        <input type="text" name="search-text" placeholder="Search (Customer Name)"></input>
                        <button type="submit" name="search-btn"> Search </button>
                    </form>
                    <button type="button" id="add-booking-btn">+ Add Booking</button>
                </div>
                <!-- List of available bookings -->
                <table id="data-table" class="TableContent">
                    <tr>
                        <!-- Populate table header -->
                        <?php
                            // Declare columns and create array
                            $conn = new BookingsDBConnection();
                            $cols = "Booking ID,Bike Name,Customer Name,Start Date,Start Time,End Date,End Time,Duration<br>(Hours),Pick Up,Drop Off,Price($)";
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
                            echo "<th> Edit </th>";
                        ?>
                    </tr>

                    <!-- Populate table data rows -->
                    <?php
                        // create new DB connection and fetch rows
                        $condition = 0;
                        if (isset($_GET["search"]))
                        {
                            $searchText = $_GET['search'];
                            $condition = "customer_table.name LIKE '%$searchText%'";
                        }
                        $rows = $conn->getBookingRows($condition);

                        // if no rows are returned, create a null row as a placeholder
                        $nullRows = ($rows == null);
                        if ($nullRows)
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
                            $bookingId = 0;
                            for($y = 0; $y < count($keys); $y++)
                            {
                                // get row and key
                                $row = $rows[$x];
                                $key = $keys[$y];

                                // retrieve data from above row for given key
                                $data = $row[$key];

                                if ($key == "booking_id")
                                {
                                    $bookingId = $data;
                                }
                                echo "<td> $data </td>";
                            }
                            echo "<td class='editcolumn'>";

                            // default if no rows in bookings
                            if ($nullRows)
                            {
                                echo "    <div class='dropdown-disabled'>";
                            }
                            else
                            {
                                echo "    <div class='dropdown'>";
                            }
                            echo "        <button class='dropbtn' disabled>...</button>";
                            echo "        <div class='dropdown-content'>";
                            echo "            <form class='' action='php-scripts/booking-popups.php' method='POST'>";
                            echo "                <button type='submit' name='change-booking-btn' value='change,$bookingId' class='dropdown-element'> Update </button>";
                            echo "            </form>";
                            echo "            <form class='' action='php-scripts/booking-popups.php' method='POST'>";
                            echo "                <button type='submit' name='delete-booking-btn' value='delete,$bookingId' class='dropdown-element'> Delete </button>";
                            echo "            </form>";
                            echo "        </div>";
                            echo "    </div>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    ?>
                </table>
            </div>
        </div>
        <!-- Booking Popup (main) -->
        <div id="add-booking-main-modal" class="modal-overlay"
            <?php
                // hide popup if not in specific booking mode
                if ($bookingMode == "add1")
                {
                    echo "style='display: block';";
                }
                else
                {
                    echo "style='display: none';";
                }
            ?>
            >
            <div class="modal-content">
                <span class="close-btn">&times;</span>
                <h2> Add Booking - Booking Details </h2>
                <!-- booking form -->
                <form class="modal-form" action="php-scripts\booking-popups.php" method="POST">
                    <!-- Select customer -->
                    <label>Customer</label><br>
                    <select name="add-booking-customer" id="add-booking-customer"><br><br>
                        <?php
                            // Populate customer combo box with all customers
                            $conn = new CustomerDBConnection();
                    		$customerList = $conn->get("user_name, name");

                            $selectedId = null;
                            if (isset($_SESSION["addBooking"]))
                            {
                                // get selected customer id
                                $selected = explode(',', $_SESSION["addBooking"]["customer"])[0];
                            }
                    		if ($customerList != null)
                    		{
                                arrayToComboBoxOptions($customerList, "user_name", $selected);
                    		}
                        ?>
                    </select><br>
                    <p class="modal-error">
                        <?php
                            if (in_array("customerEmpty", $rescodes))
                            {
                                echo "Please ensure at least one customer exists";
                            }
                            // echo "Please ensure at least one customer exists";
                        ?>
                    </p>

                    <!-- Select start of booking -->
                    <label>Start Date</label><br>
                    <input name="add-booking-start-date" id="add-booking-start-date" type="date"
                        <?php
                            if (isset($_SESSION["addBooking"]))
                            {
                                // get selected start date
                                $bookingStartDateValue = $_SESSION["addBooking"]["startDate"];
                                echo "value='$bookingStartDateValue'";
                            }
                        ?>
                    ><br>
                    <p class="modal-error">
                        <?php
                            if (in_array("startDateEmpty", $rescodes))
                            {
                                echo "Please select a date";
                            }
                            else if (in_array("dateError", $rescodes))
                            {
                                echo "Please ensure start date is before the end date";
                            }
                            // echo "Please ensure start date is before the end date";
                        ?>
                    </p>

                    <label>Start Time</label><br>
                    <select name="add-booking-start-time" id="add-booking-start-time">
                    <?php
                        $selectTime = -1;
                        if (isset($_SESSION["addBooking"]))
                        {
                            // get selected start date
                            $selectTime = $_SESSION["addBooking"]["startTime"];
                        }
                        printTimeComboBoxOptions($selectTime);
                    ?>
                    </select><br>
                    <p class="modal-error">
                        <?php
                            if (in_array("timeError", $rescodes))
                            {
                                echo "Please ensure starting time is before the ending time";
                            }
                            // echo "Please ensure starting time is before the ending time";
                        ?>
                    </p>

                    <!-- Select end of booking -->
                    <label>End Date</label><br>
                    <input name="add-booking-end-date" id="add-booking-end-date" type="date"
                    <?php
                        if (isset($_SESSION["addBooking"]))
                        {
                            // get selected start date
                            $bookingEndDateValue = $_SESSION["addBooking"]["endDate"];
                            echo "value='$bookingEndDateValue'";
                        }
                    ?>
                    ><br>
                    <p class="modal-error">
                        <?php
                            if (in_array("endDateEmpty", $rescodes))
                            {
                                echo "Please select a date";
                            }
                            else if (in_array("dateError", $rescodes))
                            {
                                echo "Please ensure start date is before the end date";
                            }
                            // echo "Please ensure start date is before the end date";
                        ?>
                    </p>

                    <label>End Time</label><br>
                    <select name="add-booking-end-time" id="add-booking-end-time">
                    <?php
                        $selectTime = -1;
                        if (isset($_SESSION["addBooking"]))
                        {
                            // get selected start date
                            $selectTime = $_SESSION["addBooking"]["endTime"];
                        }
                        printTimeComboBoxOptions($selectTime);
                    ?>
                    </select><br>
                    <p class="modal-error">
                        <?php
                            if (in_array("timeError", $rescodes))
                            {
                                echo "Please ensure starting time is before the ending time";
                            }
                            // echo "Please ensure starting time is before the ending time";
                        ?>
                    </p>

                    <!-- Select pickup and dropoff locations -->
                    <label>Pick-Up Location</label><br>
                    <select name="add-booking-pick-up-location" id="add-booking-pick-up-location"><br><br>
                        <?php
                            // Populate list of pickup locations
                            $conn = new LocationsDBConnection();
                            $pickupLocations = $conn->get("location_id, name", "pick_up_location=1");

                            // print selection dropdown
                            $selectedId = null;
                            if (isset($_SESSION["addBooking"]))
                            {
                                // get selected customer id
                                $selected = explode(',', $_SESSION["addBooking"]["pickupLocation"])[0];
                            }
                            if ($pickupLocations != null)
                            {
                                arrayToComboBoxOptions($pickupLocations, "location_id", $selectedId);
                            }
                        ?>
                    </select><br>
                    <p class="modal-error">
                        <?php
                            if (in_array("pickupError", $rescodes))
                            {
                                echo "Please add a pickup location";
                            }
                            // echo "Please add a pickup location";
                        ?>
                    </p>

                    <label>Drop-off Location</label><br>
                    <select name="add-booking-drop-off-location" id="add-booking-drop-off-location"><br><br>
                        <?php
                            // Populate list of dropoff locations
                            $dropoffLocations = $conn->get("location_id, name", "drop_off_location=1");

                            $selectedId = null;
                            if (isset($_SESSION["addBooking"]))
                            {
                                // get selected customer id
                                $selected = explode(',', $_SESSION["addBooking"]["pickupLocation"])[0];
                            }
                            if ($dropoffLocations != null)
                            {
                                arrayToComboBoxOptions($dropoffLocations, "location_id", $selectedId);
                            }
                        ?>
                    </select>
                    <p class="modal-error">
                        <?php
                            // print error for drop off location
                            if (in_array("dropoffError", $rescodes))
                            {
                                echo "Please add a dropoff location";
                            }
                            // echo "Please add a dropoff location";
                        ?>
                    </p>
                    <button type="submit" name="add-booking-main-submit" style=""> Next </button>
                </form>
            </div>
        </div>

        <!-- Form for adding bikes and accessories to bookings -->
        <div id="add-booking-bikes-modal" class="modal-overlay"
        <?php
            // hide popup depending on current booking mode
            if ($bookingMode == "add2" && $rescode != "success")
            {
                echo "style='display: block';";
            }
            else
            {
                echo "style='display: none';";
            }
        ?>
        >
            <!-- Modal content for bikes and accessories -->
            <div class="modal-content">
                <span class="close-btn">&times;</span>
                <h2> Add Booking - Bikes and Accessories </h2>
                <!-- Form for submitting selections to PHP -->
                <form class="modal-form" action="php-scripts\booking-popups.php" method="POST">
                    <!-- Bike list -->
                    <label>Bikes</label><br>
                    <!-- Get bikes as array -->
                    <div class="select-div">
                        <?php printAvailableBikes("addBooking"); ?>
                    </div>
                    <p class="modal-error">
                        <?php
                            // print error for bike list
                            if (in_array("bikeError", $rescodes))
                            {
                                echo "Please select at least one bike";
                            }
                            // echo "Please select at least one bike";
                        ?>
                    </p>

                    <!-- Accessory list -->
                    <label>Accessories</label><br>
                    <!-- Get accessories as array (for PHP) -->
                    <div class="select-div">
                        <?php printAvailableAccessories("addBooking"); ?>
                    </div><br>
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
                // hide popup based on current booking mode
                if ($bookingMode == "change1")
                {
                    echo "style='display: block';";
                }
                else
                {
                    echo "style='display: none';";
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
                <form class="modal-form" action="php-scripts\booking-popups.php" method="POST">
                    <!-- Display customer (non-modifiable) -->
                    <label>Customer</label><br>
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
                    </select><br>
                    <p class="modal-error">
                        <?php
                            // print error if no customers exist
                            if (in_array("customerEmpty", $rescodes))
                            {
                                echo "Please ensure at least one customer exists";
                            }
                            // echo "Please ensure at least one customer exists";
                        ?>
                    </p>

                    <!-- Select start of booking -->
                    <label>Start Date</label><br>
                    <input name="change-booking-start-date" id="change-booking-start-date" type="date" value=<?php if (isset($startDate)) {echo "$startDate";} ?>><br>
                    <p class="modal-error">
                        <?php
                            // print error if dates are improperly constrained
                            if (in_array("startDateEmpty", $rescodes))
                            {
                                echo "Please select a date";
                            }
                            else if (in_array("dateError", $rescodes))
                            {
                                echo "Please ensure start date is before the end date";
                            }
                            // echo "Please ensure start date is before the end date";
                        ?>
                    </p>
                    <label>Start Time</label><br>
                    <select name="change-booking-start-time" id="change-booking-start-time">
                    <?php
                        printTimeComboBoxOptions($startTime);
                    ?>
                    </select><br>
                    <p class="modal-error">
                        <?php
                            // print error if time is improperly constrained
                            if (in_array("timeError", $rescodes))
                            {
                                echo "Please ensure starting time is before the ending time";
                            }
                            // echo "Please ensure starting time is before the ending time";
                        ?>
                    </p>

                    <!-- Select end of booking -->
                    <label>End Date</label><br>
                    <input name="change-booking-end-date" id="change-booking-end-date" type="date" value=<?php if (isset($endDate)) {echo "$endDate";} ?>><br>
                    <p class="modal-error">
                        <?php
                            // print errror if dates are empty or are improperly constrained
                            if (in_array("endDateEmpty", $rescodes))
                            {
                                echo "Please select a date";
                            }
                            else if (in_array("dateError", $rescodes))
                            {
                                echo "Please ensure start date is before the end date";
                            }
                            // echo "Please ensure start date is before the end date";
                        ?>
                    </p>

                    <label>End Time</label><br>
                    <select name="change-booking-end-time" id="change-booking-end-time"<
                    <?php
                        printTimeComboBoxOptions($endTime);
                    ?>
                    </select><br>
                    <p class="modal-error">
                        <?php
                            // print error if time inputs are not properly constrained
                            if (in_array("timeError", $rescodes))
                            {
                                echo "Please ensure starting time is before the ending time";
                            }
                            // echo "Please ensure starting time is before the ending time";
                        ?>
                    </p>

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
                    </select><br>
                    <p class="modal-error">
                        <?php
                            // print error if no pickup locations have been added
                            if (in_array("pickupError", $rescodes))
                            {
                                echo "Please add a pickup location";
                            }
                            // echo "Please add a pickup location";
                        ?>
                    </p>

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
                    </select><br>
                    <p class="modal-error">
                        <?php
                            // print error if no dropoff locations have been added
                            if (in_array("dropoffError", $rescodes))
                            {
                                echo "Please add a dropoff location";
                            }
                            // echo "Please add a dropoff location";
                        ?>
                    </p>
                    <button type="submit" name="change-booking-main-submit"> Next </button>
                </form>
            </div>
        </div>

        <!-- Form for adding bikes and accessories to bookings -->
        <div id="change-booking-bikes-modal" class="modal-overlay"
        <?php
            // hide popup based on current booking mode
            if ($bookingMode == "change2" && $rescode != "success")
            {
                echo "style='display: block';";
            }
            else
            {
                echo "style='display: none';";
            }
        ?>
        >
            <!-- Modal content for bikes and accessories -->
            <div class="modal-content">
                <span class="close-btn">&times;</span>
                <h2 >Modify Booking - Bikes and Accessories </h2>
                <!-- Form for submitting selections to PHP -->
                <form class="modal-form" action="php-scripts\booking-popups.php" method="POST">
                    <!-- Bike list -->
                    <label>Bikes</label><br>
                    <!-- Get bikes as array -->
                    <div class="select-div">
                        <?php printAvailableBikes("changeBooking", $_SESSION["changeBooking"]["bookingId"]); ?>
                    </div>
                    <p class="modal-error">
                        <?php
                            // print error if no bikes are selected
                            if (in_array("bikeError", $rescodes))
                            {
                                echo "Please select at least one bike";
                            }
                        ?>
                    </p>

                    <!-- Accessory list -->
                    <label>Accessories</label><br>
                    <!-- Get accessories as array (for PHP) -->
                    <div class="select-div">
                        <?php printAvailableAccessories("changeBooking", $_SESSION["changeBooking"]["bookingId"]); ?>
                    </div><br>
                    <button type="submit" name="change-booking-bike-accessory-submit"> Update Booking </button>
                </form>
            </div>
        </div>
        <!-- Form for adding bikes and accessories to bookings -->
        <div id="delete-booking-bikes-modal" class="modal-overlay"
        <?php
            // show delete confirm modal only if booking mode is delete and no result codes are found
            if ($bookingMode == "delete" && count($rescodes) == 0)
            {
                echo "style='display: block';";
            }
            else
            {
                echo "style='display: none';";
            }
        ?>
        >
            <!-- Modal content for delete booking confirmation -->
            <div class="modal-content">
                <span class="close-btn">&times;</span>
                <h2 >Booking Delete Confirmation </h2>
                <p> Delete Booking No.
                    <?php
                        if (isset($_SESSION["deleteBooking"]) && isset($_SESSION["deleteBooking"]["bookingId"]))
                        {
                            $id = $_SESSION["deleteBooking"]["bookingId"];
                            echo "$id";
                        }
                    ?>?
                </p>
                <form class="modal-form" action='php-scripts/booking-popups.php' method='POST'>
                    <button type='submit' name='delete-booking-confirm-btn'> Confirm Delete </button>
                </form>
            </div>
        </div>
        <script src="scripts/bookings.js">
        </script>

    </body>
</html>
