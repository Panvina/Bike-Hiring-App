<?php
/* Code completed by Aadesh Jagannathan - 102072344*/
/* This file carries out the unit testing for form validation functions associated with Inventory bikes/accessories */

// Linking utility functions associated with inventory
include("inventory-util.php");

//Initialising results and test case variables
$actual_result = array("");
$expected_result = array("");
$test_case = array("");
$result = array("");

//Calling to all test functions
test_name_validation(); //Testing name validation
test_price_validation(); //Testing price validation
test_input_validation(); //Testing sanitise input

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

//Testing the name validation regex function
function test_name_validation()
{
    //Incorrect value test
    $expected_result[0] = 0; //expected result
    $test_case[0] = "./231a"; //test case input

    $actual_result[0] = validName($test_case[0]);
    $result[0] = assert_match($expected_result[0],$actual_result[0]); //comparing using the custom assert_match function
    
    //printing results
    echo "Test 1 - Name Validation || Actual: $actual_result[0] || Expected: $expected_result[0] || Result:  $result[0]";

    //Correct value test
    $expected_result[1] = 1;
    $test_case[1] = "Mountain Bike - 1";

    $actual_result[1] = validName($test_case[1]);
    $result[1] = assert_match($expected_result[1],$actual_result[1]);

    echo "<br>"."Test 2 - Name Validation || Actual: $actual_result[1] || Expected: $expected_result[1] || Result:  $result[1]";
}

//Testing the price validation regex function
function test_price_validation()
{
    //Incorrect value test
    $expected_result[2] = 0;
    $test_case[2] = "twenty-four";

    $actual_result[2] = validPrice($test_case[2]);

    $result[2] = assert_match($expected_result[2],$actual_result[2]);


    echo "<br>"."Test 3 - Price Validation || Actual: $actual_result[2] || Expected: $expected_result[2] || Result:  $result[2]";

    //Correct value test
    $expected_result[3] = 1;
    $test_case[3] = "24.00";

    $actual_result[3] = validPrice($test_case[3]);

    $result[3] = assert_match($expected_result[3],$actual_result[3]);

    echo "<br>"."Test 4 - Price Validation || Actual: $actual_result[3] || Expected: $expected_result[3] || Result:  $result[3]";
}

//Testing the sanitise input function
function test_input_validation()
{
    //Incorrect value test
    $expected_result[4] = "twenty-four";
    $test_case[4] = "   twenty-f\our  "; // test case with additional spaces and backslashes that will have to be trimmed

    $actual_result[4] = test_input($test_case[4]);

    $result[4] = assert_match($expected_result[4],$actual_result[4]);


    echo "<br>"."Test 5 - Sanitise Input || Actual: $actual_result[4] || Expected: $expected_result[4] || Result:  $result[4]";
}
?>