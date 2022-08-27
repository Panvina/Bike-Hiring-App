//  Resources:
//      https://www.w3schools.com/php/php_form_url_email.asp

<?php
    include_once "utils.php";
    include_once "accessory-inventory-db.php";
    include_once "bookings-db.php";
    include_once "bike-inventory-db.php";

    session_start();
    $_SESSION['id'] = '123';

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

        $_SESSION["customer"] = $customer;
        $_SESSION["startDate"] = $startDate;
        $_SESSION["startTime"] = $startTime;
        $_SESSION["endDate"] = $endDate;
        $_SESSION["endTime"] = $endTime;
        $_SESSION["pickupLocation"] = $pickUpLocation;
        $_SESSION["dropOffLocation"] = $dropOffLocation;
        $_SESSION["bookingDuration"] = $bookingDuration;

        // echo "Time Diff from: $startTime, $startDate --> $endTime, $endDate<br>";
        // echo "$bookingDuration hours<br>";

        // Validate variables
        // if (!checkEmptyVariables([$customer, $startDate, $startTime, $endDate, $endTime, $pickUpLocation, $dropOffLocation]))
        // {
            header("Location: bookings.php?booking-mode=stage2");
        // }
        // else
        // {
        //     header("Location: bookings.php?booking-mode=empty");
        // }


    }
    // Process submit button press for bikes and accessory selection form
    else if (isset($_POST["add-booking-bike-accessory-submit"]))
    {
        // get bikes and accessories from <select multiple> html tag
        // Both contain arrays
        $bikes        = $_POST["add-booking-bike"];
        $accessories  = $_POST["add-booking-accessory"];

        // Remove descriptions from bike and accessory selections
        for($i = 0; $i < count($bikes); $i++)
        {
            $bikes[$i] = explode(",", $bikes[$i])[0];
        }

        for($i = 0; $i < count($accessories); $i++)
        {
            $accessories[$i] = explode(",", $accessories[$i])[0];
        }

        // verify at least one bike
        if (empty($bikes))
        {
            header("Location: bookings.php?booking-mode=stage2-invalid");
            echo "empty";
        }
        else
        {
            // calculate cost
            // 1. Get number of hours (done)
            // 2. Get cost per hour of bikes (done)
            // 3. Get cost per hour of accessories (done)
            $bookingDuration = $_SESSION["bookingDuration"];                // 1.
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
            $custId = explode(",", $_SESSION["customer"])[0];
            $startDate = $_SESSION["startDate"];
            $startTime = $_SESSION["startTime"];
            $endDate = $_SESSION["endDate"];
            $endTime = $_SESSION["endTime"];
            $pickUpLocation = explode(",", $_SESSION["pickupLocation"])[0];
            $dropOffLocation = explode(",", $_SESSION["dropOffLocation"])[0];

            // echo "$custId<br>";
			// echo "$startDate<br>";
			// echo "$startTime<br>";
			// echo "$endDate<br>";
			// echo "$endTime<br>";
			// echo "$pickUpLocation<br>";
			// echo "$dropOffLocation<br>";
			// echo "$bookingDuration<br>";
			// echo "$totalPrice<br>";
			// echo "<br>";
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

            header("Location: bookings.php?booking-mode=success");
        }


    }
    exit();
?>
