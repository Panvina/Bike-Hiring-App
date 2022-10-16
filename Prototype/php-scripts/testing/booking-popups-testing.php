<?php
    /**
     * Testing for booking-popups functions. Not testing main body.
     * By Dabin Lee
     */
    include_once "../booking-popups.php";

    try {
        // test: clearSessionVariables
        {
            // NA. Uses built-in PHP functions
        }

        // test: getBookingDuration
        echo "testing getBookingDuration<br>";
        {
            $testStartTime = "09:00";
            $testEndTime = "09:00";
            $testStartDate = "16-10-2022";
            $testEndDate = "16-10-2022";

            $expectedDuration = 0;
            $duration = getBookingDuration($testStartTime, $testStartDate, $testEndTime, $testEndDate);
            if ($expectedDuration != $duration) {
                echo "Duration: $duration hours. Expected $expectedDuration hours.<br>";
                exit();
            }

            $testStartTime = "09:00";
            $testEndTime = "17:00";
            $testStartDate = "16-10-2022";
            $testEndDate = "16-10-2022";

            $expectedDuration = 8;
            $duration = getBookingDuration($testStartTime, $testStartDate, $testEndTime, $testEndDate);
            if ($expectedDuration != $duration) {
                echo "Duration: $duration hours. Expected $expectedDuration hours.<br>";
                exit();
            }

            $testStartTime = "09:00";
            $testEndTime = "09:00";
            $testStartDate = "16-10-2022";
            $testEndDate = "17-10-2022";

            $expectedDuration = 24;
            $duration = getBookingDuration($testStartTime, $testStartDate, $testEndTime, $testEndDate);
            if ($expectedDuration != $duration) {
                echo "Duration: $duration hours. Expected $expectedDuration hours.<br>";
                exit();
            }

            $testStartTime = "09:00";
            $testEndTime = "17:00";
            $testStartDate = "16-10-2022";
            $testEndDate = "17-10-2022";

            $expectedDuration = 32;
            $duration = getBookingDuration($testStartTime, $testStartDate, $testEndTime, $testEndDate);
            if ($expectedDuration != $duration) {
                echo "Duration: $duration hours. Expected $expectedDuration hours.<br>";
                exit();
            }

            echo "getBookingDuration success<br>";
        }

        echo "<br>testing getHourlyRateAccessories<br>";
        // test: getHourlyRateAccessories
        {
            $accessoryConn = new DBConnection("accessory_inventory_table");
            $accessoryTypeConn = new DBConnection("accessory_type_table");

            $accessoryTypeConn->insert("accessory_type_id,name,description", "99999,'accessorytypetest','accessorytypedesc'");
            $accessoryConn->insert("accessory_id,name,accessory_type_id,price_ph,safety_inspect", "99999,'accessorytest',99999,10000000000,1");

            $accessories = $accessoryConn->get("*", "accessory_id=99999");
            $accessories = array($accessories[0]["accessory_id"]);

            $expectedHourlyRate = 10000000000;
            // print_r($accessories);
            $actualHourlyRate = getHourlyRateAccessories($accessories);

            if ($expectedHourlyRate == $actualHourlyRate) {
                echo "Test getHourlyRateAccessories success<br>";
            }
            else {
                echo "HourlyRate: $$actualHourlyRate. Expected $$expectedHourlyRate.<br>";
                cleanup();
            }
        }

        echo "<br>testing getHourlyRateBikes<br>";
        // test: getHourlyRateBikes
        {
            $bikeConn = new DBConnection("bike_inventory_table");
            $bikeTypeConn = new DBConnection("bike_type_table");

            $bikeTypeConn->insert("bike_type_id,name,picture_id,description", "99999, 'biketypetest', 1, 'biketypedesctest'");
            $bikeConn->insert("bike_id,bike_type_id,name,helmet_id,price_ph,safety_inspect,description", "99999,99999,'biketest',99999,3579480,1,'bikedesc'");

            $bikes = $bikeConn->get("*", "bike_id=99999");
            $bikes = array($bikes[0]["bike_id"]);

            $expectedHourlyRate = 3579480;
            $actualHourlyRate = getHourlyRateBikes($bikes);

            if ($expectedHourlyRate == $actualHourlyRate) {
                echo "Test getHourlyRateBikes success<br>";
            }
            else {
                echo "HourlyRate: $$actualHourlyRate. Expected $$expectedHourlyRate.<br>";
                cleanup();
            }
        }

        // leaving out session variable functions out for now.
    }
    catch (Exception $e) {
        $msg = $e->getMessage();
        echo $msg;
    }
    finally {
        cleanup();
    }

    function cleanup() {
        $sql = new mysqli("localhost", "root", "", "bike_hiring_system");

        // delete bike
        $sql->query("DELETE FROM bike_inventory_table WHERE bike_id=99999");
		$sql->query("DELETE FROM bike_type_table WHERE bike_type_id=99999");

        // delete accessory
		$sql->query("DELETE FROM accessory_inventory_table WHERE accessory_id=99999");
		$sql->query("DELETE FROM accessory_type_table WHERE accessory_type_id=99999");
        echo "<br>Finished cleanup.";
        exit();
    }
?>

<?php

// function addErrorToMode($mode, $errorCode)
// {
//     // get current error codes for mode
//     $error = "";
//     if (checkErrorSet($mode))
//     {
//         $error = $_SESSION[$mode]["error"];
//     }
//
//     // add current error code
//     if ($error != "")
//     {
//         $error .= ",$errorCode";
//     }
//     else
//     {
//         $error = $errorCode;
//     }
//
//     // write to session
//     $_SESSION[$mode]["error"] = $error;
// }
//
// function checkErrorCustomer($mode, $customer)
// {
//     if (empty($customer))
//     {
//         addErrorToMode($mode, "customerEmpty");
//     }
// }
//
// function checkErrorDateTime($mode, $startDate, $endDate, $startTime, $endTime)
// {
//     if (empty($startDate))
//     {
//         addErrorToMode($mode, "startDateEmpty");
//     }
//
//     if (empty($endDate))
//     {
//         addErrorToMode($mode, "endDateEmpty");
//     }
//
//     // convert datetime strings to datetime objects
//     $dtStartDate = strtotime($startDate);
//     $dtStartTime = strtotime($startTime);
//     $dtEndDate = strtotime($endDate);
//     $dtEndTime = strtotime($endTime);
//
//     // check that start date is before or equal to end date
//     if ($dtStartDate > $dtEndDate)
//     {
//         addErrorToMode($mode, "dateError");
//     }
//
//     // check that time makes sense (i.e. start time is before end time)
//     if (($dtStartDate == $dtEndDate) && ($dtStartTime >= $dtEndTime))
//     {
//          addErrorToMode($mode, "timeError");
//     }
// }
//
// function checkErrorLocations($mode, $pickupLoc, $dropoffLoc)
// {
//     if (empty($pickupLoc))
//     {
//         addErrorToMode($mode, "pickupError");
//     }
//
//     if (empty($dropoffLoc))
//     {
//         addErrorToMode($mode, "dropoffError");
//     }
// }
//
// function checkErrorBikes($mode, $bikes)
// {
//     if (empty($bikes))
//     {
//         addErrorToMode($mode, "bikeError");
//         // echo "empty - $bikes";
//         // exit();
//     }
// }
//
// function checkErrorSet($mode)
// {
//     $errorSet = false;
//     if (isset($_SESSION[$mode]))
//     {
//         if (isset($_SESSION[$mode]["error"]))
//         {
//             $errorSet = true;
//         }
//     }
//
//     // print_r($_SESSION[$mode]["error"]);
//
//     return $errorSet;
// }
//
// function inputErrorSet($mode, $errorCode)
// {
//     $errorSet = "";
//     if (checkErrorSet($mode))
//     {
//         $errorCodes = explode(",", $_SESSION[$mode]["error"]);
//         $errorSet = in_array($errorCode, $errorCodes);
//     }
//
//     // echo ($errorSet);
//
//     return $errorSet;
// }
?>
