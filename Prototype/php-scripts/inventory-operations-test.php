<?php
/* Code completed by Aadesh Jagannathan - 102072344*/
/* This file carries out the unit testing for CRUD operation functions associated with Inventory bikes/accessories */

// Linking utility functions associated with inventory
include("inventory-util.php");

//Initialising results and test case variables
$actual_result = array("");
$expected_result = array("");
$test_case = array("");
$result = array("");

//Calling to test functions
test_insert();
test_update();
test_delete();

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

/*Testing insert operations for all inventory tables by inserting records with predefined
    details and comparing their names to identify a record match */
function test_insert()
{
     //Establishing database connection using mysqli()
    $conn = new mysqli("localhost", "root", "", "bike_hiring_system");

    // ID of the test bike being inserted
    $test_case[0] = 1;

    /*Test 1 - Bike Inventory*/

    //Adding test bike to bike inventory for testing
    $cols = "`bike_id`, `name`, `bike_type_id`, `helmet_id`, `price_ph`, `safety_inspect`, `description`";
    $data = "'1', 'Test-Bike', '57', '2', '30', '1', 'Test Bike 1'";
    $query = "INSERT INTO `bike_inventory_table` ($cols) VALUES ($data)"; 
    mysqli_query($conn,$query);

    //retreiving data of the newly inserted record
    $query = "SELECT * FROM bike_inventory_table WHERE bike_id= $test_case[0]";
    $row = $conn->query($query);
    $fetch = $row->fetch_assoc();

    // actual and expected result
    $actual_result[0] = $fetch["name"];
    $expected_result[0] = "Test-Bike"; // name of the bike from inserted record

    //Comparing results to identify if they match
    $result[0] = assert_match($expected_result[0],$actual_result[0]);

    echo "Test 1 - Insert Bike || Actual: $actual_result[0] || Expected: $expected_result[0] || Result:  $result[0]";

    /*Test 2 - Accessory Inventory*/
    // ID of the test bike being inserted
    $test_case[1] = 1;

    //Adding test bike to bike inventory for testing
    $query = "INSERT INTO `accessory_inventory_table` (`accessory_id`, `name`, `accessory_type_id`, `price_ph`, `safety_inspect`) VALUES ('1', 'Test-Accessory', '1', '50', '1');"; 
    mysqli_query($conn,$query);

    //retreiving data of the newly inserted record
    $query = "SELECT * FROM accessory_inventory_table WHERE accessory_id= $test_case[1]";
    $row = $conn->query($query);
    $fetch = $row->fetch_assoc();

    // actual and expected result
    $actual_result[1] = $fetch["name"];
    $expected_result[1] = "Test-Accessory"; // name of the bike from inserted record

    //Comparing results to identify if they match
    $result[1] = assert_match($expected_result[1],$actual_result[1]);

    echo "<br>"."Test 2 - Insert Accessory || Actual: $actual_result[1] || Expected: $expected_result[1] || Result:  $result[1]";

    /*Test 3 - Accessory Type Inventory*/
    // ID of the test bike being inserted
    $test_case[2] = 3;

    //Adding test bike to bike inventory for testing
    $query = "INSERT INTO `accessory_type_table` (`accessory_type_id`, `name`, `description`) VALUES ('3', 'Test-Accessory-Type', 'Test-Accessory-Type');"; 
    mysqli_query($conn,$query);

    //retreiving data of the newly inserted record
    $query = "SELECT * FROM accessory_type_table WHERE accessory_type_id= $test_case[2]";
    $row = $conn->query($query);
    $fetch = $row->fetch_assoc();

    // actual and expected result
    $actual_result[2] = $fetch["name"];
    $expected_result[2] = "Test-Accessory-Type"; // name of the bike from inserted record

    //Comparing results to identify if they match
    $result[2] = assert_match($expected_result[2],$actual_result[2]);

    echo "<br>"."Test 3 - Insert Accessory Type || Actual: $actual_result[2] || Expected: $expected_result[2] || Result:  $result[2]";

    /*Test 4 - Bike Type Inventory*/
    // ID of the test bike being inserted
    $test_case[3] = 3;

    //Adding test bike to bike inventory for testing
    $query = "INSERT INTO `bike_type_table` (`bike_type_id`, `name`, `picture_id`, `description`) VALUES ('3', 'Test-Bike-Type', '1', 'Test-Bike-Type');"; 
    mysqli_query($conn,$query);

    //retreiving data of the newly inserted record
    $query = "SELECT * FROM bike_type_table WHERE bike_type_id= $test_case[3]";
    $row = $conn->query($query);
    $fetch = $row->fetch_assoc();

    // actual and expected result
    $actual_result[3] = $fetch["name"];
    $expected_result[3] = "Test-Bike-Type"; // name of the bike from inserted record

    //Comparing results to identify if they match
    $result[3] = assert_match($expected_result[3],$actual_result[3]);

    echo "<br>"."Test 4 - Insert Bike Type || Actual: $actual_result[3] || Expected: $expected_result[3] || Result:  $result[3]";
}

/*Testing update operations from all inventory tables by updating names of records 
    previously created and then comparing the new name to expected name values */
function test_update()
{
    
    //Establishing database connection using mysqli()
    $conn = new mysqli("localhost", "root", "", "bike_hiring_system");

    /*Test 5 - Bike Inventory*/
    /*--------------------------------- */
    // ID of the test bike being inserted
    /*--------------------------------- */
    $test_case[0] = 1;
    $expected_result[0] = "New-Test-Bike"; // name of the bike from inserted record
    
    //Updating test bike to bike inventory for testing
    $query = "UPDATE bike_inventory_table SET `name`='$expected_result[0]' WHERE bike_id= $test_case[0]"; 
    mysqli_query($conn,$query);

    //retreiving data of the newly inserted record
    $query = "SELECT * FROM bike_inventory_table WHERE bike_id= $test_case[0]";
    $row = $conn->query($query);
    $fetch = $row->fetch_assoc();

    // actual and expected result
    $actual_result[0] = $fetch["name"];
    
    //Comparing results to identify if they match
    $result[0] = assert_match($expected_result[0],$actual_result[0]);

    echo "<br>"."Test 5 - Update Bike || Actual: $actual_result[0] || Expected: $expected_result[0] || Result:  $result[0]";

    /*--------------------------------- */
    /*Test 6 - Accessory Inventory*/
    /*--------------------------------- */

    // ID of the test bike being inserted
    $test_case[1] = 1;
    $expected_result[1] = "New-Test-Accessory"; // name of the accessory from updated record
    
    //Updating test accessory to accessory inventory for testing
    $query = "UPDATE accessory_inventory_table SET `name`='$expected_result[1]' WHERE accessory_id= $test_case[0]"; 
    mysqli_query($conn,$query);

    //retreiving data of the newly inserted record
    $query = "SELECT * FROM accessory_inventory_table WHERE accessory_id= $test_case[1]";
    $row = $conn->query($query);
    $fetch = $row->fetch_assoc();

    // actual and expected result
    $actual_result[1] = $fetch["name"];

    //Comparing results to identify if they match
    $result[1] = assert_match($expected_result[1],$actual_result[1]);

    echo "<br>"."Test 6 - Update Accessory || Actual: $actual_result[1] || Expected: $expected_result[1] || Result:  $result[1]";

    /*--------------------------------- */
    /*Test 7 - Accessory Type Inventory*/
    /*--------------------------------- */

    // ID of the test bike being inserted
    $test_case[2] = 3;
    $expected_result[2] = "New-Test-Accessory-Type"; // name of the accessory type from updated record

    //Updating test accessory type to accessory types for testing
    $query = "UPDATE accessory_type_table SET `name`='$expected_result[2]' WHERE accessory_type_id= $test_case[2]"; 
    mysqli_query($conn,$query);

    //retreiving data of the newly inserted record
    $query = "SELECT * FROM accessory_type_table WHERE accessory_type_id= $test_case[2]";
    $row = $conn->query($query);
    $fetch = $row->fetch_assoc();

    // actual and expected result
    $actual_result[2] = $fetch["name"];

    //Comparing results to identify if they match
    $result[2] = assert_match($expected_result[2],$actual_result[2]);

    echo "<br>"."Test 7 - Update Accessory Type || Actual: $actual_result[2] || Expected: $expected_result[2] || Result:  $result[2]";

    /*--------------------------------- */
    /*Test 8 - Bike Type Inventory*/
    /*--------------------------------- */

    // ID of the test bike being inserted
    $test_case[3] = 3;
    $expected_result[3] = "New-Test-Bike-Type"; // name of the bike type from updated record

    //Updating test bike type to bike types for testing
    $query = "UPDATE bike_type_table SET `name`='$expected_result[3]' WHERE bike_type_id= $test_case[2]"; 
    mysqli_query($conn,$query);

    //retreiving data of the newly inserted record
    $query = "SELECT * FROM bike_type_table WHERE bike_type_id= $test_case[3]";
    $row = $conn->query($query);
    $fetch = $row->fetch_assoc();

    // actual and expected result
    $actual_result[3] = $fetch["name"];

    //Comparing results to identify if they match
    $result[3] = assert_match($expected_result[3],$actual_result[3]);

    echo "<br>"."Test 8 - Update Bike Type || Actual: $actual_result[3] || Expected: $expected_result[3] || Result:  $result[3]";
    //delete_test_data();
}

/*Testing delete operations from all inventory tables by deleting records previously
    created and then counting number of rows with same ID value which should be 0 */
function test_delete()
{
    
    //Establishing database connection using mysqli()
    $conn = new mysqli("localhost", "root", "", "bike_hiring_system");

    
    /*--------------------------------- */
    /*Test 9 - Bike Inventory*/
    /*--------------------------------- */

    // ID of the test bike being deleted
    $test_case[0] = 1;
    $expected_result[0] = "0"; // count of bike record with same id
    
    //Deleting test bike from bike inventory for testing
    $query = "DELETE FROM bike_inventory_table WHERE bike_id=$test_case[0]"; 
    mysqli_query($conn,$query);

    //retreiving data of the newly inserted record
    $query = "SELECT * FROM bike_inventory_table WHERE bike_id= $test_case[0]";
    $row = $conn->query($query); 

    // actual and expected result
    $actual_result[0] = $row->num_rows;
    
    //Comparing results to identify if they match
    $result[0] = assert_match($expected_result[0],$actual_result[0]);

    echo "<br>"."Test 9 - Delete Bike || Actual: $actual_result[0] || Expected: $expected_result[0] || Result:  $result[0]";

    /*--------------------------------- */
    /*Test 10 - Accessory Inventory*/
    /*--------------------------------- */
    
    // ID of the test accessory being deleted
    $test_case[1] = 1;
    $expected_result[1] = "0"; // count of accessory record with same id
    
    //Deleting test accessory from accessory inventory for testing
    $query = "DELETE FROM accessory_inventory_table WHERE accessory_id=$test_case[1]"; 
    mysqli_query($conn,$query);

    //retreiving data of the newly inserted record
    $query = "SELECT * FROM accessory_inventory_table WHERE accessory_id= $test_case[1]";
    $row = $conn->query($query); 

    // actual and expected result
    $actual_result[1] = $row->num_rows;
    
    //Comparing results to identify if they match
    $result[1] = assert_match($expected_result[1],$actual_result[1]);

    echo "<br>"."Test 10 - Delete Accessory || Actual: $actual_result[1] || Expected: $expected_result[1] || Result:  $result[1]";

    /*--------------------------------- */
    /*Test 11 - Accessory Type Inventory*/
    /*--------------------------------- */
    
    // ID of the test accessory being deleted
    $test_case[2] = 3;
    $expected_result[2] = "0"; // count of accessory type record with same id
    
    //Deleting test accessory type from accessory type for testing
    $query = "DELETE FROM accessory_type_table WHERE accessory_type_id=$test_case[2]"; 
    mysqli_query($conn,$query);

    //retreiving data of the newly inserted record
    $query = "SELECT * FROM accessory_type_table WHERE accessory_type_id= $test_case[2]";
    $row = $conn->query($query); 

    // actual and expected result
    $actual_result[2] = $row->num_rows;
    
    //Comparing results to identify if they match
    $result[2] = assert_match($expected_result[2],$actual_result[2]);

    echo "<br>"."Test 11 - Delete Accessory Type || Actual: $actual_result[2] || Expected: $expected_result[2] || Result:  $result[2]";
    
    /*--------------------------------- */
    /*Test 12 - Bike Type Inventory*/
    /*--------------------------------- */
    
    // ID of the test bike being deleted
    $test_case[2] = 3;
    $expected_result[2] = "0"; // count of bike type record with same id
    
    //Deleting test accessory type from accessory type for testing
    $query = "DELETE FROM bike_type_table WHERE bike_type_id=$test_case[2]"; 
    mysqli_query($conn,$query);

    //retreiving data of the newly inserted record
    $query = "SELECT * FROM bike_type_table WHERE bike_type_id= $test_case[2]";
    $row = $conn->query($query); 

    // actual and expected result
    $actual_result[2] = $row->num_rows;
    
    //Comparing results to identify if they match
    $result[2] = assert_match($expected_result[2],$actual_result[2]);

    echo "<br>"."Test 11 - Delete Bike Type || Actual: $actual_result[2] || Expected: $expected_result[2] || Result:  $result[2]";
}

function delete_test_data()
{
    //Establishing database connection using mysqli()
    $conn = new mysqli("localhost", "root", "", "bike_hiring_system");

    //Deleting all test records 
    $query = "DELETE FROM bike_inventory_table WHERE bike_id=1";
    mysqli_query($conn, $query);
    $query = "DELETE FROM accessory_inventory_table WHERE accessory_id=1";
    mysqli_query($conn, $query);
    $query = "DELETE FROM accessory_type_table WHERE accessory_type_id=3";
    mysqli_query($conn, $query);
    $query = "DELETE FROM bike_type_table WHERE bike_type_id=3";
    mysqli_query($conn, $query);

}
?>