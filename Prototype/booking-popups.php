//  Resources:
//      https://www.w3schools.com/php/php_form_url_email.asp

<?php
    require "utils.php";



    session_start();
    $_SESSION['id'] = '123';

    // Get booking duration (hours between 0900 to 1700)
    // NOTE: $startTime and $endTime must be properly constrained to between business hours
    function getBookingDuration($startTime, $startDate, $endTime, $endDate)
    {
        $hours = 0.0;

        // // Create DateTime strings for conversion to PHP DateTime
        // $startDateTimeStr = $startDate . " " . $startTime;
        // $endDateTimeStr = $endDate . " " . $endTime;
        //
        // // Create DateTime objects from previous strings
        // $start = new DateTime($startDateTimeStr);
        // $end = new DateTime($endDateTimeStr);
        //
        // $timeDiff = $start->diff($end);
        //
        // $hours += $timeDiff->days * 24;
        // $hours += $timeDiff->h;
        // $hours += $timeDiff->i / 60.0;

        // Get hour and minutes for start and end times
        $startTime = new DateTime($startTime);
        $endTime = new DateTime($endTime);

        $startDate = new DateTime($startDate);
        $endDate = new DateTime($endDate);

        // [$startTimeHour, $startTimeMin] = $startTime;
        // [$endTimeHour, $endTimeMin] = $endTime;
        //  = $startTime[0];
        // $startTimeMin = $startTime[1];

        // $endTimeHour = $endTime[0];
        // $endTimeMin = $endTime[1];

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
        //
        // // Get year, date, month for start and end dates
        // $startDate = explode("-", $startDate);
        // $endDate = explode("-", $endDate);
        //
        // [$startDateYear, $startDateMonth, $startDateDay] = $startDate;
        // [$endDateYear, $endDateMonth, $endDateDay] = $endDate;

        return $hours;
    }

    //function getBookingCost($)
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
        if (!checkEmptyVariables([$customer, $startDate, $startTime, $endDate, $endTime, $pickUpLocation, $dropOffLocation]))
        {
            header("Location: bookings.php?add-booking=success1");
            exit();
        }
        else
        {
            header("Location: bookings.php?add-booking=empty");
            exit();
        }


    }
    else
    {
        echo "5";
        exit();
    }
    exit();
?>
