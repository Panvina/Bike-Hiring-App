//  Resources:
//      https://www.w3schools.com/php/php_form_url_email.asp

<?php
    include_once "utils.php";
    include_once "accessory-inventory-db.php";
    include_once "bookings-db.php";
    include_once "bike-inventory-db.php";

    session_start();
    $_SESSION['id'] = '123';

    print_r($_POST);

    // Get booking duration (hours between 0900 to 1700)
    // NOTE: $startTime and $endTime must be properly constrained to between business hours
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

    // Get hourly rate for an array of bikes (format = [bikeId1,stuff, bikeId2,stuff])
    function getHourlyRateBikes($bikes)
    {
        $hourlyRate = 0.0;
        $conn = new BikeInventoryDBConnection();

        // columns to retrieve from SQL query to bike_inventory_table
        $colsToRetrieve = "price_ph";
        // initialise conditional statement
        $condition = "";

        // loop through all bikes in array
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
        $rows = $conn->get($colsToRetrieve, $condition);

        // Add total pricing per hour
        for($i = 0; $i < count($rows); $i++)
        {
            $bikeRate = $rows[$i]["price_ph"];
            $hourlyRate += $bikeRate;
        }

        return $hourlyRate;
    }

    // Get hourly rate for an array of accessories (format = [accessoryId1,stuff, accessoryId2,stuff])
    function getHourlyRateAccessories($accessories)
    {
        $hourlyRate = 0.0;
        $conn = new AccessoryInventoryDBConnection();

        // columns to retrieve from SQL query to bike_inventory_table
        $colsToRetrieve = "price_ph";
        // initialise conditional statement
        $condition = "";

        // loop through all bikes in array
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

        // GET bike pricing information
        $rows = $conn->get($colsToRetrieve, $condition);

        // Add total pricing per hour
        for($i = 0; $i < count($rows); $i++)
        {
            $accessoryRate = $rows[$i]["price_ph"];
            $hourlyRate += $accessoryRate;
        }

        return $hourlyRate;
    }
?>

<?php
    /**
     * 1. Get the following fields
     *      - Customer name
     *      - Start and end datetimes
     *      - pickup and dropoff locations
     * 2. Calculate booking duration
     * 3. Save above data (via session)
     * 4. Select bikes (via return to bike selection window)
     * 5. Select accessories (via return to accessory selection window)
     * 6. Collate hourly rate of every bike and accessory
     * 7. Calculate final cost
     * 8. INSERT into DB
     */
    // Verify button for add booking is pressed
    if (isset($_POST["add-booking-main-submit"]))
    {
        // Get variables
        $customer        = $_POST["add-booking-customer"];
        $startDate       = $_POST["add-booking-start-date"];
        $startTime       = $_POST["add-booking-start-time"];
        $endDate         = $_POST["add-booking-end-date"];
        $endTime         = $_POST["add-booking-end-time"];
        $pickUpLocation  = $_POST["add-booking-pick-up-location"];
        $dropOffLocation = $_POST["add-booking-drop-off-location"];

        $bookingDuration = getBookingDuration($startTime, $startDate, $endTime, $endDate);

        $_SESSION["addBooking"] = array(
            "customer"        => $customer,
            "startDate"       => $startDate,
            "startTime"       => $startTime,
            "endDate"         => $endDate,
            "endTime"         => $endTime,
            "pickupLocation"  => $pickUpLocation,
            "dropOffLocation" => $dropOffLocation,
            "bookingDuration" => $bookingDuration
        );

        // echo "Time Diff from: $startTime, $startDate --> $endTime, $endDate<br>";
        // echo "$bookingDuration hours<br>";

        // Validate variables
        if (!emptyArr([$customer, $startDate, $startTime, $endDate, $endTime, $pickUpLocation, $dropOffLocation]))
        {
            header("Location: ..\bookings.php?booking-mode=stage2");
        }
        else
        {
            header("Location: ..\bookings.php?booking-mode=empty");
        }
    }
    // Process submit button press for bikes and accessory selection form
    else if (isset($_POST["add-booking-bike-accessory-submit"]))
    {
        // get bikes and accessories from <select multiple> html tag
        // Both contain arrays
        $bikes        = comboboxArrayToItemIdArray($_POST["add-booking-bike"]);
        $accessories  = comboboxArrayToItemIdArray($_POST["add-booking-accessory"]);

        // verify at least one bike
        if (empty($bikes))
        {
            echo "empty";
            header("Location: ..\bookings.php?booking-mode=stage2-invalid");
        }
        else
        {
            // calculate cost
            // 1. Get number of hours (done)
            // 2. Get cost per hour of bikes (done)
            // 3. Get cost per hour of accessories (done)
            $bookingDuration = $_SESSION["addBooking"]["bookingDuration"];  // 1.
            $bikeHourly = getHourlyRateBikes($bikes);                       // 2.
            $accessoryHourly = 0;
            if (isset($accessories))
            {
                $accessoryHourly = getHourlyRateAccessories($accessories);  // 3.
            }

            // calculate total price of booking (at time of booking)
            $totalPrice = round($bookingDuration * ($bikeHourly + $accessoryHourly), 2);

            // insert into booking_table the columns:
            // (cust_id, start_date, start_time, end_date, end_time, duration_of_booking, pick_up_location, drop_off_location, final_price)
            // Retrieve data from session
            $custId = explode(",", $_SESSION["addBooking"]["customer"])[0];
            $startDate = $_SESSION["addBooking"]["startDate"];
            $startTime = $_SESSION["addBooking"]["startTime"];
            $endDate = $_SESSION["addBooking"]["endDate"];
            $endTime = $_SESSION["addBooking"]["endTime"];
            $pickUpLocation = explode(",", $_SESSION["addBooking"]["pickupLocation"])[0];
            $dropOffLocation = explode(",", $_SESSION["addBooking"]["dropOffLocation"])[0];

            // booking duration set above
            // total price calculated above
            $data = [$custId, "$startDate", "$startTime", "$endDate", "$endTime", $bookingDuration, $pickUpLocation, $dropOffLocation, $totalPrice];
            // echo $data;
            $cols = "cust_id, start_date, start_time, end_date, expected_end_time, duration_of_booking, pick_up_location, drop_off_location, final_price";

            // // perform INSERT operation into Bookings
            // $conn = new BookingsDBConnection();
            // $conn->insert($cols, $data);
            $conn = new BookingsDBConnection();
            $conn->addBooking($data, $bikes, $accessories);

            header("Location: ..\bookings.php?booking-mode=success");
        }
    }
    // check for change booking button being clicked
    else if (isset($_POST["change-booking-btn"]))
    {
        // Get booking for ID. Button name is in format: "change,X"
        // where X denotes the booking id
        $buttonName = $_POST["change-booking-btn"];
        $bookingId = explode(",", $buttonName)[1];

        // Retrieve booking
        $conn = new BookingsDBConnection();
        $row = $conn->retrieveBookingForChangeBooking($bookingId); // ret from function is always 2D array

        // set session variables
        $_SESSION["changeBooking"] += array(
            "bookingId"   => $bookingId,         // Need this, as it will be overwritten
            "custId"      => $row["cust_id"],
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

        // echo "<br><br><br>";
        // echo print_r($_SESSION["changeBooking"]);
        // echo "<br><br><br>";
        // exit();

        header("Location: ..\bookings.php?booking-mode=change");
    }
    else if (isset($_POST["change-booking-main-submit"]))
    {
        // Select new start/end dates/times -> select all new accessories and bikes.
        // Same start/end dates/times -> Retrieve current bookings/accessories

        // 1. Verify if changes to date/times have been made.
        $pickupLocation = explode(": ", $_POST["change-booking-pick-up-location"]);
        $dropOffLocation = explode(": ", $_POST["change-booking-drop-off-location"]);

        // get original variables and potentially changed variables
        $preVariables = $_SESSION["changeBooking"];
        $postVariables = array(
            "startTime"  => $_POST["change-booking-start-time"],
            "endTime"    => $_POST["change-booking-end-time"],
            "startDate"  => $_POST["change-booking-start-date"],
            "endDate"    => $_POST["change-booking-end-date"],
            "pickupStr"  => $_POST["change-booking-pick-up-location"],
            "dropoffStr" => $_POST["change-booking-drop-off-location"]
        );
        $keys = array_keys($postVariables);

        $changed = false;
        for($i = 0; $i < count($keys); $i++)
        {
            $key = $keys[$i];
            $change |= ($preVariables[$key] != $postVariables[$key]);
        }

        $_SESSION["changeBooking"]["startDate"] = $_POST["change-booking-start-date"];
        $_SESSION["changeBooking"]["startTime"] = $_POST["change-booking-start-time"];
        $_SESSION["changeBooking"]["endDate"] = $_POST["change-booking-end-date"];
        $_SESSION["changeBooking"]["endTime"] = $_POST["change-booking-end-time"];
        $_SESSION["changeBooking"]["pickupId"] = explode(": ", $_POST["change-booking-pick-up-location"])[0];
        $_SESSION["changeBooking"]["dropoffId"] = explode(": ", $_POST["change-booking-drop-off-location"])[0];

        if ($changed)
        {
            header("Location: ..\bookings.php?booking-mode=change-stage2");
        }
        else
        {
            header("Location: ..\bookings.php?booking-mode=change-stage2");
        }
    }
    else if (isset($_POST["change-booking-bike-accessory-submit"]))
    {
        $bikes        = comboboxArrayToItemIdArray($_POST["change-booking-bike"]);
        $accessories  = comboboxArrayToItemIdArray($_POST["change-booking-accessory"]);

        // verify at least one bike
        if (empty($bikes))
        {
            echo "empty";
            exit();
            header("Location: ..\bookings.php?booking-mode=stage2-invalid");
        }
        else
        {
            echo "<br><br>";
            print_r($_SESSION["changeBooking"]);
            $custId      = $_SESSION["changeBooking"]["custId"];
            $custName    = $_SESSION["changeBooking"]["custName"];
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

            // exit();
            header("Location: ..\bookings.php");
        }
    }
    else if (isset($_POST["delete-booking-btn"]))
    {
        // get booking id to delete
        $buttonName = $_POST["delete-booking-btn"];
        $bookingId = explode(",", $buttonName)[1];

        // Delete booking
        $conn = new BookingsDBConnection();
        $res = $conn->deleteBooking($bookingId);

        // exit();
        header("Location: ..\bookings.php");
    }
    exit();
?>
