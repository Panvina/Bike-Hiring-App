<!--
Project Name: Inverloch Bike Hire
Project Description: A website for hiring bikes. Front-end accompanied
       by an admin dashboard.
File Description: PHP handler for bookings page.
Contributor(s): Dabin Lee @ icelasersparr@gmail.com
-->
<?php
    include_once "utils.php";
    include_once "accessory-inventory-db.php";
    include_once "bookings-db.php";
    include_once "bike-inventory-db.php";

    // get session data
    session_start();

    /**
     * Clears booking variables from the current session.
     */
    function clearSessionVariables()
    {
        unset($_SESSION["addBooking"]);
        unset($_SESSION["changeBooking"]);
    }

    /**
     * Get booking duration (hours between 0900 to 1700)
     * NOTE: $startTime and $endTime must be properly constrained to between business hours
     * Inputs are direct from form POST outputs
     */
    function getBookingDuration($startTime, $startDate, $endTime, $endDate)
    {
        $hours = 0.0;

        // Get hour and minutes for start and end times
        $startTime = new DateTime($startTime);
        $endTime = new DateTime($endTime);

        $startDate = new DateTime($startDate);
        $endDate = new DateTime($endDate);

        // Find difference in times only
        $timeDiff = $endTime->diff($startTime);
        $hours += $timeDiff->h;
        $hours += $timeDiff->i / 60.0;

        // Add difference in date
        if ($startDate != $endDate)
        {
            $timeDiff = $endDate->diff($startDate);

            $hours += $timeDiff->days * 24.0;
        }

        return $hours;
    }

    /**
     * Get hourly rate for an array of bikes (format = [bikeId1,stuff, bikeId2,stuff])
     * Input is POST from form
     */
    function getHourlyRateBikes($bikes)
    {
        $hourlyRate = 0.0;
        $bikeConn = new BikeInventoryDBConnection();

        // columns to retrieve from SQL query to bike_inventory_table
        $colsToRetrieve = "price_ph";
        // initialise conditional statement
        $condition = "";

        // construct conditional to retrieve relevant bikes from DB
        for($i = 0; $i < count($bikes); $i ++)
        {
            $bikeId = explode(",", $bikes[$i])[0];

            $condition .= "bike_id=$bikeId";

            // Add OR
            if ($i < count($bikes) - 1)
            {
                $condition .= " OR ";
            }
        }

        // GET bike pricing information
        $rows = $bikeConn->get($colsToRetrieve, $condition);

        // sum pricing per hour
        for($i = 0; $i < count($rows); $i++)
        {
            $bikeRate = $rows[$i]["price_ph"];
            $hourlyRate += $bikeRate;
        }

        return $hourlyRate;
    }

    /**
     * Get hourly rate for an array of accessories (format = [accessoryId1,stuff, accessoryId2,stuff])
     * Input is POST from form
     */
    function getHourlyRateAccessories($accessories)
    {
        $hourlyRate = 0.0;
        $conn = new AccessoryInventoryDBConnection();

        // columns to retrieve from SQL query to bike_inventory_table
        $colsToRetrieve = "price_ph";
        // initialise conditional statement
        $condition = "";

        // construct query condition for GET function for accessories
        for($i = 0; $i < count($accessories); $i ++)
        {
            $accessoryId = explode(",", $accessories[$i])[0];

            $condition .= "accessory_id=$accessoryId";

            // Add OR
            if ($i < count($accessories) - 1)
            {
                $condition .= " OR ";
            }
        }

        // GET accessory pricing information
        $rows = $conn->get($colsToRetrieve, $condition);

        // Sum total pricing per hour
        for($i = 0; $i < count($rows); $i++)
        {
            $accessoryRate = $rows[$i]["price_ph"];
            $hourlyRate += $accessoryRate;
        }

        return $hourlyRate;
    }

    function addErrorToMode($mode, $errorCode)
    {
        // get current error codes for mode
        $error = "";
        if (checkErrorSet($mode))
        {
            $error = $_SESSION[$mode]["error"];
        }

        // add current error code
        if ($error != "")
        {
            $error .= ",$errorCode";
        }
        else
        {
            $error = $errorCode;
        }

        // write to session
        $_SESSION[$mode]["error"] = $error;
    }

    function checkErrorCustomer($mode, $customer)
    {
        if (empty($customer))
        {
            addErrorToMode($mode, "customerEmpty");
        }
    }

    function checkErrorDateTime($mode, $startDate, $endDate, $startTime, $endTime)
    {
        if (empty($startDate))
        {
            addErrorToMode($mode, "startDateEmpty");
        }

        if (empty($endDate))
        {
            addErrorToMode($mode, "endDateEmpty");
        }

        // convert datetime strings to datetime objects
        $dtStartDate = strtotime($startDate);
        $dtStartTime = strtotime($startTime);
        $dtEndDate = strtotime($endDate);
        $dtEndTime = strtotime($endTime);

        // check that start date is before or equal to end date
        if ($dtStartDate > $dtEndDate)
        {
            addErrorToMode($mode, "dateError");
        }

        // check that time makes sense (i.e. start time is before end time)
        if (($dtStartDate == $dtEndDate) && ($dtStartTime >= $dtEndTime))
        {
             addErrorToMode($mode, "timeError");
        }
    }

    function checkErrorLocations($mode, $pickupLoc, $dropoffLoc)
    {
        if (empty($pickupLoc))
        {
            addErrorToMode($mode, "pickupError");
        }

        if (empty($dropoffLoc))
        {
            addErrorToMode($mode, "dropoffError");
        }
    }

    function checkErrorBikes($mode, $bikes)
    {
        if (empty($bikes))
        {
            addErrorToMode($mode, "bikeError");
            echo "empty";
        }
    }

    function checkErrorSet($mode)
    {
        $errorSet = false;
        if (isset($_SESSION[$mode]))
        {
            if (isset($_SESSION[$mode]["error"]))
            {
                $errorSet = true;
            }
        }

        // print_r($_SESSION[$mode]["error"]);

        return $errorSet;
    }

    function inputErrorSet($mode, $errorCode)
    {
        $errorSet = "";
        if (checkErrorSet($mode))
        {
            $errorCodes = explode(",", $_SESSION[$mode]["error"]);
            $errorSet = in_array($errorCode, $errorCodes);
        }

        echo ($errorSet);

        return $errorSet;
    }
?>

<?php
    // Add booking form submission variables
    $addBookingInfoSubmit = isset($_POST["add-booking-main-submit"]);
    $addBookingBikesSubmit = isset($_POST["add-booking-bike-accessory-submit"]);

    // Change booking form submission variables
    $changeBookingInitSubmit = isset($_POST["change-booking-btn"]);
    $changeBookingInfoSubmit = isset($_POST["change-booking-main-submit"]);
    $changeBookingBikesSubmit = isset($_POST["change-booking-bike-accessory-submit"]);

    // Delete booking button
    $deleteBookingSubmit = isset($_POST["delete-booking-btn"]);
    $deleteBookingConfirm = isset($_POST["delete-booking-confirm-btn"]);

    $searchButtonSubmit = isset($_POST["search-btn"]);

    // Verify button for add booking is pressed
    if ($addBookingInfoSubmit)
    {
        // set current booking mode
        $bookingMode = "addBooking";

        // Get variables
        $customer        = $_POST["add-booking-customer"];
        $startDate       = $_POST["add-booking-start-date"];
        $startTime       = $_POST["add-booking-start-time"];
        $endDate         = $_POST["add-booking-end-date"];
        $endTime         = $_POST["add-booking-end-time"];
        $pickUpLocation  = $_POST["add-booking-pick-up-location"];
        $dropOffLocation = $_POST["add-booking-drop-off-location"];

        // calculate duration of booking
        $bookingDuration = getBookingDuration($startTime, $startDate, $endTime, $endDate);

        // add booking details to session
        $_SESSION[$bookingMode] = array(
            "customer"        => $customer,
            "startDate"       => $startDate,
            "startTime"       => $startTime,
            "endDate"         => $endDate,
            "endTime"         => $endTime,
            "pickupLocation"  => $pickUpLocation,
            "dropOffLocation" => $dropOffLocation,
            "bookingDuration" => $bookingDuration
        );

        checkErrorCustomer("addBooking", $customer);
        checkErrorDateTime("addBooking", $startDate, $endDate, $startTime, $endTime);
        checkErrorLocations("addBooking", $pickUpLocation, $dropOffLocation);

        if (!checkErrorSet($bookingMode))
        {
            header("Location: ..\bookings.php?booking-mode=add2-none");
        }
        else
        {
            header("Location: ..\bookings.php?booking-mode=add1-error");
        }
    }
    // Process submit button press for bikes and accessory selection form
    else if ($addBookingBikesSubmit)
    {
        // get bikes and accessories from <select multiple> html tag
        // Both contain arrays
        $bikes        = comboboxArrayToItemIdArray($_POST["add-booking-bike"]);
        $accessories  = comboboxArrayToItemIdArray($_POST["add-booking-accessory"]);

        $bookingMode = "addBooking";

        unset($_SESSION["addBooking"]["error"]);

        checkErrorBikes($bookingMode, $bikes);

        // verify at least one bike
        if (inputErrorSet($bookingMode, "bikeError") != "")
        {
            header("Location: ..\bookings.php?booking-mode=add2-error");
        }
        else
        {
            // retrieve booking duration from addBooking session variables
            $bookingDuration = $_SESSION[$bookingMode]["bookingDuration"];

            // calculate hourly rate for bikes
            $bikeHourly = getHourlyRateBikes($bikes);

            // calculate hourly rate for accessories
            $accessoryHourly = isset($accessories) ? getHourlyRateAccessories($accessories) : 0;

            // calculate total price of booking (at time of booking)
            $totalPrice = round($bookingDuration * ($bikeHourly + $accessoryHourly), 2);

            // Retrieve data from session variables from previous form
            $custId = explode(",", $_SESSION[$bookingMode]["customer"])[0];
            $startDate = $_SESSION[$bookingMode]["startDate"];
            $startTime = $_SESSION[$bookingMode]["startTime"];
            $endDate = $_SESSION[$bookingMode]["endDate"];
            $endTime = $_SESSION[$bookingMode]["endTime"];
            $pickUpLocation = explode(",", $_SESSION[$bookingMode]["pickupLocation"])[0];
            $dropOffLocation = explode(",", $_SESSION[$bookingMode]["dropOffLocation"])[0];

            // Prepare data and columns for adding booking
            $data = [$custId, "$startDate", "$startTime", "$endDate", "$endTime", $bookingDuration, $pickUpLocation, $dropOffLocation, $totalPrice];
            $cols = "cust_id, start_date, start_time, end_date, expected_end_time, duration_of_booking, pick_up_location, drop_off_location, final_price";

            // perform insertion
            $conn = new BookingsDBConnection();
            $conn->addBooking($data, $bikes, $accessories);

            // clear booking variables and redirect
            clearSessionVariables();
            header("Location: ..\bookings.php?booking-mode=add2-success");
        }
    }
    // check for change booking button being clicked
    else if ($changeBookingInitSubmit)
    {
        // Get booking for ID. Button name is in format: "change,X"
        // where X denotes the booking id
        $buttonName = $_POST["change-booking-btn"];
        $bookingId = explode(",", $buttonName)[1];

        // Retrieve booking for given booking id
        $conn = new BookingsDBConnection();
        $row = $conn->retrieveBookingForChangeBooking($bookingId); // ret from function is always 2D array

        // set session variables
        $_SESSION["changeBooking"] = array(
            "bookingId"   => $bookingId,         // Need this, as it will be overwritten otherwise by this assignment
            "custId"      => $row["user_name"],
            "custName"    => $row["name"],
            "startTime"   => $row["start_time"],
            "endTime"     => $row["expected_end_time"],
            "startDate"   => $row["start_date"],
            "endDate"     => $row["end_date"],
            "pickupId"    => $row["pick_up_location_id"],
            "pickupName"  => $row["pick_up_location"],
            "dropoffId"   => $row["drop_off_location_id"],
            "dropoffName" => $row["drop_off_location"]
        );

        // print_r($_SESSION['changeBooking']);
        // exit();

        header("Location: ..\bookings.php?booking-mode=change1-none");
    }
    else if ($changeBookingInfoSubmit)
    {
        $bookingMode = "changeBooking";

        $startDate = $_POST["change-booking-start-date"];
        $startTime = $_POST["change-booking-start-time"];
        $endDate = $_POST["change-booking-end-date"];
        $endTime = $_POST["change-booking-end-time"];
        $pickupLocation = explode(": ", $_POST["change-booking-pick-up-location"])[0];
        $dropOffLocation = explode(": ", $_POST["change-booking-drop-off-location"])[0];

        // save data into session for next form
        $_SESSION[$bookingMode]["startDate"] = $startDate;
        $_SESSION[$bookingMode]["startTime"] = $startTime;
        $_SESSION[$bookingMode]["endDate"] = $endDate;
        $_SESSION[$bookingMode]["endTime"] = $endTime;
        $_SESSION[$bookingMode]["pickupId"] = $pickupLocation;
        $_SESSION[$bookingMode]["dropoffId"] = $dropOffLocation;

        unset($_SESSION[$bookingMode]["error"]);

        checkErrorDateTime($bookingMode, $startDate, $endDate, $startTime, $endTime);
        checkErrorLocations($bookingMode, $pickupLocation, $dropOffLocation);

        // exit();

        if (!checkErrorSet($bookingMode))
        {
            // all fields are fine
            header("Location: ..\bookings.php?booking-mode=change2-none");
        }
        else
        {
            header("Location: ..\bookings.php?booking-mode=change1-error");
        }
    }
    else if ($changeBookingBikesSubmit)
    {
        $bookingMode = "changeBooking";

        // retrieve bikes and accessories selected from form
        $bikes        = comboboxArrayToItemIdArray($_POST["change-booking-bike"]);
        $accessories  = comboboxArrayToItemIdArray($_POST["change-booking-accessory"]);

        unset($_SESSION[$bookingMode]["error"]);

        checkErrorBikes($bookingMode, $bikes);

        // verify at least one bike
        if (checkErrorSet($bookingMode))
        {
            header("Location: ..\bookings.php?booking-mode=change2-error");
        }
        else
        {
            // retrieve data from previous form
            $custId      = $_SESSION[$bookingMode]["custId"];
            $custName    = $_SESSION[$bookingMode]["custName"];
            $startTime   = $_SESSION["changeBooking"]["startTime"];
            $endTime     = $_SESSION["changeBooking"]["endTime"];
            $startDate   = $_SESSION["changeBooking"]["startDate"];
            $endDate     = $_SESSION["changeBooking"]["endDate"];
            $pickupId    = $_SESSION["changeBooking"]["pickupId"];
            $pickupName  = $_SESSION["changeBooking"]["pickupName"];
            $dropoffId   = $_SESSION["changeBooking"]["dropoffId"];
            $dropoffName = $_SESSION["changeBooking"]["dropoffName"];

            // calculate duration of booking
            $bookingDuration = getBookingDuration($startTime, $startDate, $endTime, $endDate);

            // calculate hourly rate
            $bikeHourly = getHourlyRateBikes($bikes);
            $accessoryHourly = isset($accessories) ? getHourlyRateAccessories($accessories) : 0;

            // calculate total price of booking
            $totalPrice = round($bookingDuration * ($bikeHourly + $accessoryHourly), 2);
            $bookingDuration = round($bookingDuration, 2);

            // public function modifyBooking($bookingId, $bookingData, $bikeData, $accessoryData=array())
            $bookingId = $_SESSION["changeBooking"]["bookingId"];
            $bookingData = array($startDate, $startTime, $endDate, $endTime, $bookingDuration, $pickupId, $dropoffId, $totalPrice);

            // modify booking
            $conn = new BookingsDBConnection();
            $res = $conn->modifyBooking($bookingId, $bookingData, $bikes, $accessories);

            // clear booking variables
            clearSessionVariables();
            // redirect back to main bookings page
            header("Location: ..\bookings.php");
        }
    }
    else if ($deleteBookingSubmit)
    {
        // get booking id to delete
        $buttonName = $_POST["delete-booking-btn"];
        $bookingId = explode(",", $buttonName)[1];
        $_SESSION["deleteBooking"]["bookingId"] = $bookingId;
        header("Location: ..\bookings.php?booking-mode=delete-none");
    }
    else if ($deleteBookingConfirm)
    {
        $bookingId = $_SESSION["deleteBooking"]["bookingId"];

        // Delete booking
        $conn = new BookingsDBConnection();
        $res = $conn->deleteBooking($bookingId);

        header("Location: ..\bookings.php");
    }
    else if ($searchButtonSubmit)
    {
        // text user is searching for
        $searchText = $_POST["search-text"];

        // ensure search is not just whitespace characters
        if (trim($searchText) != "")
        {
            header("Location: ..\bookings.php?search=$searchText");
        }
        else
        {
            header("Location: ..\bookings.php");
        }
    }
    exit();
?>
