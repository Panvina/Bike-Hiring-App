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


?>