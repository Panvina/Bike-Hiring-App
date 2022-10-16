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
