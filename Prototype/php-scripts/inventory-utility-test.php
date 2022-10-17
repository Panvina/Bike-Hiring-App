<?php
/* Code completed by Aadesh Jagannathan - 102072344*/
/* This file carries out the unit testing for utility functions associated with Inventory bikes/accessories */

// Linking utility functions associated with inventory
include("inventory-util.php");

//Initialising results and test case variables
$actual_result = array("");
$expected_result = array("");
$test_case = array("");
$result = array("");

//Calling to all test functions
test_safety_check(); //Testing safety status function
test_availabilty_colour(); //Testing availability status colour returned
test_safety_colour(); //Testing safety status colour returned
test_availability_status_1(); //Testing availability status for bikes/accessories - No booking
test_availability_status_2(); //Testing availability status for bikes/accessories - Ongoing booking
test_availability_status_3(); //Testing availability status for bikes/accessories - Completed booking 
test_availability_status_4(); //Testing availability status for bikes/accessories - Multiple booking
test_availability_status_5(); //Testing availability status for bikes/accessories - Damaged item booking


//Custom function comparing actual and expected results
function assert_match($expected, $actual)
{
    if($expected == $actual)
    {
        return "Passed!";
    }
    else
    {
        return "Failed!";
    }
}

// Testing if the right availbility status is returned for boolean values
function test_safety_check()
{
    //Inspected test
    $expected_result[0] = "Checked"; //expected result
    $test_case[0] = "1"; //test case input

    $actual_result[0] = safety_check($test_case[0]); //actual result produced in testing
    $result[0] = assert_match($expected_result[0],$actual_result[0]); //comparing using the custom assert_match function

    //Printing test results
    echo "Test 1 - Inspected Safety Status || Actual: $actual_result[0] || Expected: $expected_result[0] || Result:  $result[0]";

    //Not Inspected test
    $expected_result[1] = "Not checked";
    $test_case[1] = "0";

    $actual_result[1] = safety_check($test_case[1]);
    $result[1] = assert_match($expected_result[1],$actual_result[1]);

    echo "<br>"."Test 2 - Not Inspected Safety Status || Actual: $actual_result[1] || Expected: $expected_result[1] || Result:  $result[1]";
}

// Testing if the right availbility status colour hex is returned based on status
function test_availabilty_colour()
{
    //Available - Green colour
    $expected_result[2] = "#8DEF6E";
    $test_case[2] = "Available";

    $actual_result[2] = availabilityStatusColour($test_case[2]);
    $result[2] = assert_match($expected_result[2],$actual_result[2]);

    echo "<br>"."Test 3 - Availability Status Colour - Green || Actual: $actual_result[2] || Expected: $expected_result[2] || Result:  $result[2]";

    //Not Available - Orange colour
    $expected_result[3] = "#EFAC6E";
    $test_case[3] = "Not Available";

    $actual_result[3] = availabilityStatusColour($test_case[3]);
    $result[3] = assert_match($expected_result[3],$actual_result[3]);

    echo "<br>"."Test 4 - Availability Status Colour - Orange || Actual: $actual_result[3] || Expected: $expected_result[3] || Result:  $result[3]";

    //Damaged - Red colour
    $expected_result[4] = "#EF6E6E";
    $test_case[4] = "Damaged";

    $actual_result[4] = availabilityStatusColour($test_case[4]);
    $result[4] = assert_match($expected_result[4],$actual_result[4]);

    echo "<br>"."Test 5 - Availability Status Colour - Red || Actual: $actual_result[4] || Expected: $expected_result[4] || Result:  $result[4]";
}

// Testing if the right availbility status colour hex is returned based on status
function test_safety_colour()
{
    //Inspected - Green colour
    $expected_result[5] = "#8DEF6E";
    $test_case[5] = "Checked";

    $actual_result[5] = safetyStatusColour($test_case[5]);
    $result[5] = assert_match($expected_result[5],$actual_result[5]);

    echo "<br>"."Test 6 - Safety Status Colour - Green || Actual: $actual_result[5] || Expected: $expected_result[5] || Result:  $result[5]";

    //Not Insepected - Orange colour
    $expected_result[6] = "#EFAC6E";
    $test_case[6] = "Not checked";

    $actual_result[6] = safetyStatusColour($test_case[6]);
    $result[6] = assert_match($expected_result[6],$actual_result[6]);

    echo "<br>"."Test 7 - Safety Status Colour - Orange || Actual: $actual_result[6] || Expected: $expected_result[6] || Result:  $result[6]";

    //Damaged - Red colour
    $expected_result[7] = "#EF6E6E";
    $test_case[7] = "Damaged";

    $actual_result[7] = safetyStatusColour($test_case[7]);
    $result[7] = assert_match($expected_result[7],$actual_result[7]);

    echo "<br>"."Test 8 - Safety Status Colour - Red || Actual: $actual_result[7] || Expected: $expected_result[7] || Result:  $result[7]";
}

// Testing if the right availbility status colour hex is returned based on status
function test_availability_status()
{
    //Establishing database connection using mysqli()
    $conn = new mysqli("localhost", "root", "", "bike_hiring_system");
    
    // ID of test bike
    $test_case[8] = 15; 

    //Adding test bike to bike inventory for testing
    $cols = "`bike_id`, `name`, `bike_type_id`, `helmet_id`, `price_ph`, `safety_inspect`, `description`";
    $data = "'15', 'Test-Bike', '57', '2', '30', '1', 'Test Bike 1'";
    
    $query = "INSERT INTO `bike_inventory_table` ($cols) VALUES ($data)"; 
    $results = mysqli_query($conn,$query);

    //Test case for checking bike availability with no booking made
    $expected_result[8] = "Available";
    $expected_result[9] = "Not Available";

    $actual_result[8] = bike_availability_check($test_case[8]);
    $result[8] = assert_match($expected_result[8],$actual_result[8]);

    echo "<br>"."Test 9 - Bike Availbility Check - No booking || Actual: $actual_result[8] || Expected: $expected_result[8] || Result:  $result[8]";

    // ID of the booking in booking table
    $test_case[9] = 1;
    // ID of the booking in booking bike
    $test_case[10] = 1;

    //Adding test booking to bookings table for testing    
    $query = "INSERT INTO `booking_table` (`booking_id`, `user_name`, `start_date`, `end_date`, `start_time`, `expected_end_time`, `duration_of_booking`, `pick_up_location`, `drop_off_location`, `booking_fee`) VALUES ('1', 'CU-Jackson25', '2022-10-16', '2022-10-18', '09:00:00', '17:00:00', '56', '100', '100', '1000');"; 
    mysqli_query($conn,$query);
    $query = "INSERT INTO `booking_bike_table` (`booking_bike_id`, `booking_id`, `bike_id`) VALUES ('1', '1', '15')"; 
    mysqli_query($conn,$query);

    //Deleting all test records 
    $query = "DELETE FROM bike_inventory_table WHERE bike_id=$test_case[8]";
    mysqli_query($conn, $query);
    $query = "DELETE FROM `booking_table` WHERE `booking_table`.`booking_id` = $test_case[9]";
    mysqli_query($conn, $query);
    $query = "DELETE FROM `booking_bike_table` WHERE `booking_bike_table`.`booking_bike_id` = $test_case[10]";
    mysqli_query($conn, $query);
}

/*Testing availability status function with all possibilities*/

// Testing if the right availbility status is returned when there no booking associated with the bike
function test_availability_status_1()
{
    //Establishing database connection using mysqli()
    $conn = new mysqli("localhost", "root", "", "bike_hiring_system");
    
    // ID of test bike
    $test_case[8] = 15; 

    //Adding test bike to bike inventory for testing
    $cols = "`bike_id`, `name`, `bike_type_id`, `helmet_id`, `price_ph`, `safety_inspect`, `description`";
    $data = "'14', 'Test-Bike', '57', '2', '30', '1', 'Test Bike 1'";
    
    $query = "INSERT INTO `bike_inventory_table` ($cols) VALUES ($data)"; 
    $results = mysqli_query($conn,$query);

    //Test case for checking bike availability with no booking made
    $expected_result[8] = "Available";

    $actual_result[8] = bike_availability_check($test_case[8]);
    $result[8] = assert_match($expected_result[8],$actual_result[8]);

    echo "<br>"."Test 9 - Bike/Accessory Availbility Check - No booking || Actual: $actual_result[8] || Expected: $expected_result[8] || Result:  $result[8]";
    
    //Deleting all test records 
    $query = "DELETE FROM bike_inventory_table WHERE bike_id=$test_case[8]";
    mysqli_query($conn, $query);
}

// Testing if the right availbility status is returned when there is an ongoing booking associated with the bike 
function test_availability_status_2()
{
    //Establishing database connection using mysqli()
    $conn = new mysqli("localhost", "root", "", "bike_hiring_system");
    
    // ID of test bike
    $test_case[9] = 14; 

    //Adding test booking to bookings table for testing    
    $query = "INSERT INTO `booking_table` (`booking_id`, `user_name`, `start_date`, `end_date`, `start_time`, `expected_end_time`, `duration_of_booking`, `pick_up_location`, `drop_off_location`, `booking_fee`) VALUES ('1', 'CU-Jackson25', '2022-10-16', '2022-10-18', '09:00:00', '17:00:00', '56', '100', '100', '1000');"; 
    mysqli_query($conn,$query);
    $query = "INSERT INTO `booking_bike_table` (`booking_bike_id`, `booking_id`, `bike_id`) VALUES ('1', '1', '14')"; 
    mysqli_query($conn,$query);

    //Test case for checking bike availability with an ongoing
    $expected_result[9] = "Not Available";

    $actual_result[9] = bike_availability_check($test_case[9]);
    $result[9] = assert_match($expected_result[9],$actual_result[9]);

    echo "<br>"."Test 10 - Bike/Accessory Availbility Check - In-between booking || Actual: $actual_result[9] || Expected: $expected_result[9] || Result:  $result[9]";

    //Deleting test records
    delete_booking_test_records();
}

// Testing if the right availbility status is returned when the booking associated with the bike has ended
function test_availability_status_3()
{
    //Establishing database connection using mysqli()
    $conn = new mysqli("localhost", "root", "", "bike_hiring_system");

    // ID of test bike
    $test_case[9] = 14;

    //Adding test booking to bookings table for testing    
    $query = "INSERT INTO `booking_table` (`booking_id`, `user_name`, `start_date`, `end_date`, `start_time`, `expected_end_time`, `duration_of_booking`, `pick_up_location`, `drop_off_location`, `booking_fee`) VALUES ('1', 'CU-Jackson25', '2022-10-16', '2022-10-16', '09:00:00', '17:00:00', '56', '100', '100', '1000');"; 
    mysqli_query($conn,$query);
    $query = "INSERT INTO `booking_bike_table` (`booking_bike_id`, `booking_id`, `bike_id`) VALUES ('1', '1', '14')"; 
    mysqli_query($conn,$query);

    //Test case for checking bike availability with the booking completed
    $expected_result[9] = "Available";

    $actual_result[9] = bike_availability_check($test_case[9]);
    $result[9] = assert_match($expected_result[9],$actual_result[9]);

    echo "<br>"."Test 11 - Bike/Accessory Availbility Check - Ended Booking || Actual: $actual_result[9] || Expected: $expected_result[9] || Result:  $result[9]";

    //Deleting test records
    delete_booking_test_records();
}

// Testing if the right availbility status is returned when there are multiple bookings associated (to ensure latest booking data is used)
function test_availability_status_4()
{
    //Establishing database connection using mysqli()
    $conn = new mysqli("localhost", "root", "", "bike_hiring_system");

    // ID of test bike
    $test_case[9] = 14;

    //Adding test booking to bookings table for testing (already completed)   
    $query = "INSERT INTO `booking_table` (`booking_id`, `user_name`, `start_date`, `end_date`, `start_time`, `expected_end_time`, `duration_of_booking`, `pick_up_location`, `drop_off_location`, `booking_fee`) VALUES ('1', 'CU-Jackson25', '2022-10-16', '2022-10-16', '09:00:00', '17:00:00', '56', '100', '100', '1000');"; 
    mysqli_query($conn,$query);
    $query = "INSERT INTO `booking_bike_table` (`booking_bike_id`, `booking_id`, `bike_id`) VALUES ('1', '1', '14')"; 
    mysqli_query($conn,$query);

    //Adding test booking to bookings table for testing (ongoing)  
    $query = "INSERT INTO `booking_table` (`booking_id`, `user_name`, `start_date`, `end_date`, `start_time`, `expected_end_time`, `duration_of_booking`, `pick_up_location`, `drop_off_location`, `booking_fee`) VALUES ('2', 'CU-Jackson25', '2022-10-18', '2022-10-19', '17:00:00', '17:00:00', '56', '100', '100', '1000');"; 
    mysqli_query($conn,$query);
    $query = "INSERT INTO `booking_bike_table` (`booking_bike_id`, `booking_id`, `bike_id`) VALUES ('2', '2', '14')"; 
    mysqli_query($conn,$query);

    //Test case for checking bike availability with no booking made
    $expected_result[9] = "Not Available";

    $actual_result[9] = bike_availability_check($test_case[9]);
    $result[9] = assert_match($expected_result[9],$actual_result[9]);

    echo "<br>"."Test 12 - Bike/Accessory Availbility Check - Multiple Bookings || Actual: $actual_result[9] || Expected: $expected_result[9] || Result:  $result[9]";

    //Deleting test records
    delete_booking_test_records();
    delete_bike_test_records();
}

// Testing if the right availbility status is returned when a bike coming off a booking is added to the damaged items table
function test_availability_status_5()
{
    //Establishing database connection using mysqli()
    $conn = new mysqli("localhost", "root", "", "bike_hiring_system");

    // ID of test bike
    $test_case[9] = 14;

    //Adding test bike to bike inventory for testing
    $cols = "`bike_id`, `name`, `bike_type_id`, `helmet_id`, `price_ph`, `safety_inspect`, `description`";
    $data = "'14', 'Test-Bike', '57', '2', '30', '1', 'Test Bike 1'";
    
    $query = "INSERT INTO `bike_inventory_table` ($cols) VALUES ($data)"; 
    mysqli_query($conn,$query);

    //Adding test booking to bookings table for testing    
    $query = "INSERT INTO `booking_table` (`booking_id`, `user_name`, `start_date`, `end_date`, `start_time`, `expected_end_time`, `duration_of_booking`, `pick_up_location`, `drop_off_location`, `booking_fee`) VALUES ('1', 'CU-Jackson25', '2022-10-16', '2022-10-16', '09:00:00', '17:00:00', '56', '100', '100', '1000');"; 
    mysqli_query($conn,$query);
    $query = "INSERT INTO `booking_bike_table` (`booking_bike_id`, `booking_id`, `bike_id`) VALUES ('1', '1', '14')"; 
    mysqli_query($conn,$query);

    //Adding bike to damaged items table
    $query = "INSERT INTO `damaged_items_table` (`damaged_id`, `booking_id`, `bike_id`, `accessory_id`, `damage_fee`) VALUES ('1', '1', '14', NULL, '50');";
    mysqli_query($conn,$query);

    //Test case for checking bike availability with Broken Status
    $expected_result[9] = "Broken";

    $actual_result[9] = bike_availability_check($test_case[9]);
    $result[9] = assert_match($expected_result[9],$actual_result[9]);

    echo "<br>"."Test 13 - Bike/Accessory Availbility Check - Damaged items || Actual: $actual_result[9] || Expected: $expected_result[9] || Result:  $result[9]";

    //Deleting test records
    delete_bike_test_records();
    delete_booking_test_records();
    delete_bike_test_records();
}

/*Functions responsible of clearing all test data entered for the bikes and bookings*/
function delete_bike_test_records()
{
    //Establishing database connection using mysqli()
    $conn = new mysqli("localhost", "root", "", "bike_hiring_system");

    //Deleting all test records 
    $query = "DELETE FROM bike_inventory_table WHERE bike_id=14";
    mysqli_query($conn, $query);
    $query = "DELETE FROM damaged_items_table WHERE bike_id=1";
    mysqli_query($conn, $query);
}

function delete_booking_test_records()
{
    //Establishing database connection using mysqli()
    $conn = new mysqli("localhost", "root", "", "bike_hiring_system");

    //Deleting all test records 
    $query = "DELETE FROM `booking_bike_table` WHERE `booking_bike_table`.`booking_bike_id` = 1";
    mysqli_query($conn, $query);
    $query = "DELETE FROM `booking_bike_table` WHERE `booking_bike_table`.`booking_bike_id` = 2";
    mysqli_query($conn, $query);
    $query = "DELETE FROM `booking_table` WHERE `booking_table`.`booking_id` = 1";
    mysqli_query($conn, $query);  
    $query = "DELETE FROM `booking_table` WHERE `booking_table`.`booking_id` = 2";
    mysqli_query($conn, $query);  
}

?>