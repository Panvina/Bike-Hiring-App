<?php
    include_once "php-scripts\bookings-db.php";
    include_once "php-scripts\customer-db.php";
    include_once "php-scripts\locations-db.php";
    include_once "php-scripts\accessory-inventory-db.php";
    include_once "php-scripts\bike-inventory-db.php";
    include_once "php-scripts\utils.php";

    // dashboard side menu import (Dabin)
    include_once("php-scripts/dashboard-menu.php");

    if (!isset($_SESSION)){
        session_start();
    }

    $_SESSION['id'] = '123';

    $bookingMode = "none";
    $errorCode = "none";
    $errorText = "";
    $errors = array();

    if (isset($_GET["booking-mode"]))
    {
        $bookingErrorData = explode('-', $_GET["booking-mode"]);
        $bookingMode = $bookingErrorData[0];
        $errorCode = $bookingErrorData[1];

        if ($bookingMode == "add1" or $bookingMode == "add2")
        {
            $dataMode = "addBooking";

            if ($errorCode == "error")
            {
                $errors = explode(",", $_SESSION[$dataMode]["error"]);
            }
            else
            {
                $errors = array();
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
        <h1 class="header"> <a href="index.php"><img src="img/photos/Inverloch_Logo3.png" alt="Inverloch Logo" id="Logo" /></a> Bookings </h1>
    </head>
    <body>
        <!-- Booking Popup (main) -->
        <div id="add-booking-main-modal" class="modal-overlay"
            <?php
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
                            if (in_array("customerEmpty", $errors))
                            {
                                echo "Please ensure at least one customer exists";
                            }
                            echo "Please ensure at least one customer exists";
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
                            if (in_array("startDateEmpty", $errors))
                            {
                                echo "Please select a date";
                            }
                            else if (in_array("dateError", $errors))
                            {
                                echo "Please ensure start date is before the end date";
                            }
                            echo "Please ensure start date is before the end date";
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
                            if (in_array("timeError", $errors))
                            {
                                echo "Please ensure starting time is before the ending time";
                            }
                            echo "Please ensure starting time is before the ending time";
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
                            if (in_array("startDateEmpty", $errors))
                            {
                                echo "Please select a date";
                            }
                            else if (in_array("dateError", $errors))
                            {
                                echo "Please ensure start date is before the end date";
                            }
                            echo "Please ensure start date is before the end date";
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
                        <p class="modal-error">
                            <?php
                                if (in_array("timeError", $errors))
                                {
                                    echo "Please ensure starting time is before the ending time";
                                }
                                echo "Please ensure starting time is before the ending time";
                            ?>
                        </p>
                    </p>

                    <!-- Select pickup and dropoff locations -->
                    <label>Pick-Up Location</label><br>
                    <select name="add-booking-pick-up-location" id="add-booking-pick-up-location"><br><br>
                        <?php
                            // Populate list of pickup locations
                            $conn = new LocationsDBConnection();
                            $pickupLocations = $conn->get("location_id, name", "pick_up_location=1");

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
                            if (in_array("pickupError", $errors))
                            {
                                echo "Please add a pickup location";
                            }
                            echo "Please add a pickup location";
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
                            if (in_array("dropoffError", $errors))
                            {
                                echo "Please add a dropoff location";
                            }
                            echo "Please add a dropoff location";
                        ?>
                    </p>
                    <button type="submit" name="add-booking-main-submit" style=""> Next </button>
                </form>
            </div>
        </div>

        <!-- Form for adding bikes and accessories to bookings -->
        <div id="add-booking-bikes-modal" class="modal-overlay"
        <?php
            if ($bookingMode == "add2" && $errorCode != "success")
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
                    <p>To select multiple values for either bikes or accessories, hold CTRL while clicking.</p>
                    <label>Bikes</label><br>
                    <!-- Get bikes as array (for PHP) -->
                    <select name="add-booking-bike[]" id="add-booking-bike" multiple size="10"><br><br>
                        <?php
                            // Get DB connection object
                            $conn = new BikeInventoryDBConnection();

                            // Populate list of bikes
                            $bikes = $conn->get("bike_id, name");

                            if ($bikes != null)
                            {
                                arrayToComboBoxOptions($bikes, "bike_id");
                            }
                        ?>
                    </select><br>
                    <p class="modal-error">
                        <?php
                            if (in_array("bikeError", $errors))
                            {
                                echo "Please select at least one bike";
                            }
                            // echo "Please select at least one bike";
                        ?>
                    </p>

                    <!-- Accessory list -->
                    <label>Accessories</label><br>
                    <!-- Get accessories as array (for PHP) -->
                    <select name="add-booking-accessory[]" id="add-booking-accessory" multiple size="10" size="10"><br><br>
                        <?php
                            // Get DB connection object
                            $conn = new AccessoryInventoryDBConnection();

                            // Populate list of accessories
                            $accessories = $conn->getUsableItems();

                            if ($accessories != null)
                            {
                                arrayToComboBoxOptions($accessories, "accessory_id");
                            }
                        ?>
                    </select><br>
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
                    <label>Customer <?php echo "[$custId]"; ?></label><br>
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
                    <select name="change-booking-start-time" id="change-booking-start-time">
                    <?php
                        printTimeComboBoxOptions($startTime);
                    ?>
                    </select><br><br>
                    <!-- Select end of booking -->
                    <label>End Date</label><br>
                    <input name="change-booking-end-date" id="change-booking-end-date" type="date" value=<?php echo "$endDate"; ?>><br><br>
                    <label>End Time</label><br>
                    <select name="change-booking-end-time" id="change-booking-end-time"<
                    <?php
                        printTimeComboBoxOptions($endTime);
                    ?>
                    </select><br><br>

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
                    </select><br>
                    <p class="modal-error-message">
                        <?php
                            if ($errorCode != "none")
                            {
                                $errorString = "";
                                switch($errorCode)
                                {
                                    case "emptyError":
                                        $errorString = "Please ensure that all fields are filled.";
                                        break;
                                    case "dateError":
                                        $errorString = "Please ensure starting date is before or equal to end date";
                                        break;
                                    case "timeError":
                                        $errorString = "Please ensure the starting time is before the ending time";
                                        break;
                                    default:
                                        break;
                                }

                                echo "$errorString";
                            }
                        ?>
                    </p>
                    <button type="submit" name="change-booking-main-submit"> Next </button>
                </form>
            </div>
        </div>

        <!-- Form for adding bikes and accessories to bookings -->
        <div id="change-booking-bikes-modal" class="modal-overlay"
        <?php
            if ($bookingMode == "change2" && $errorCode != "success")
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
                    <p>To select multiple values for either bikes or accessories, hold CTRL while clicking.</p>
                    <label>Bikes</label><br>
                    <!-- Get bikes as array (for PHP) -->
                    <select name="change-booking-bike[]" id="change-booking-bike" multiple size="10"><br><br>
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
                    <select name="change-booking-accessory[]" id="change-booking-accessory" multiple size="10"><br><br>
                        <?php
                            // Get DB connection object
                            $conn = new AccessoryInventoryDBConnection();

                            // Populate list of dropoff locations
                            $accessories = $conn->getUsableItems();

                            if ($accessories != null)
                            {
                                arrayToComboBoxOptions($accessories, "accessory_id");
                            }
                        ?>
                    </select><br>
                    <p class="modal-error-message">
                        <?php
                            if ($errorCode != "none")
                            {
                                echo "Please ensure that at least one bike has been selected.";
                            }
                        ?>
                    </p>
                    <button type="submit" name="change-booking-bike-accessory-submit"> Update Booking </button>
                </form>
            </div>
        </div>
        <!-- Form for adding bikes and accessories to bookings -->
        <div id="delete-booking-bikes-modal" class="modal-overlay"
        <?php
            if ($bookingMode == "delete")
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
                <h2 >Booking Delete Confirmation </h2>
                <p> Delete Booking No.<?php $id = $_SESSION["deleteBooking"]["bookingId"]; echo "$id"; ?>? </p>
                <form class="modal-form" action='php-scripts/booking-popups.php' method='POST'>
                    <button type='submit' name='delete-booking-confirm-btn'> Confirm Delete </button>
                </form>
            </div>
        </div>
        <div class="grid-container">
            <div class="menu">
                <?php printMenu("bookings"); ?>
            </div>
            <div class="main">
                <h1 id="content-header"> All Bookings </h1>
                <!-- Add Booking pop up -->
                <button type="button" id="add-booking-btn">+ Add Booking</button>

                <!-- List of available bookings -->
                <table id="data-table" class="TableContent">
                    <tr>
                        <!-- Populate table header -->
                        <?php
                            // Declare columns and create array
                            $conn = new BookingsDBConnection();
                            $cols = $conn->getBookingDisplayColumns();
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
                            echo "
                                <td class='editcolumn'>
                                    <div class='dropdown'>
                                        <button class='dropbtn' disabled>...</button>
                                        <div class='dropdown-content'>
                                            <form class='modal-form' action='php-scripts/booking-popups.php' method='POST'>
                                                <button type='submit' name='change-booking-btn' value='change,$bookingId' class='dropdown-element'> Update </button>
                                            </form>
                                            <form class='modal-form' action='php-scripts/booking-popups.php' method='POST'>
                                                <button type='submit' name='delete-booking-btn' value='delete,$bookingId' class='dropdown-element'> Delete </button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            ";
                            echo "</tr>";
                        }
                    ?>
                </table>
            </div>
        </div>
        <script src="scripts/bookings.js">
        </script>

    </body>
</html>
