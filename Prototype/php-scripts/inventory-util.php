<?php
/* Code entirely completed by Aadesh Jagannathan - 102072344*/
/* File contains all inventory page related utility functions*/
date_default_timezone_set('Australia/Melbourne');

// Print Safety Inspection based on 0 or 1 values  
function safety_check($val)
{
    if ($val == 1) {
        return "Checked";
    } else {
        return "Not checked";
    }
}

// Checks the booking status of bikes based on current time and available bookings
function bike_availability_check($id)
{
    //variable to set safety status to not checked
    $safetyStatus = 0;
    //Establishing connection to the db
    $conn = new mysqli("localhost", "root", "", "bike_hiring_system");
    //Checking if the bike's id is not present in the booking table
    $booking = $conn->query("SELECT * FROM booking_bike_table WHERE bike_id= $id");
    //Checking if bike id is present in the damaged items table
    $query = "SELECT * FROM damaged_items_table WHERE bike_id= $id";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    //Print broken status if item is damaged after booking
    if (isset($row['bike_id'])) 
    {
        // set item safety status to not inspected
        $query = ("UPDATE bike_inventory_table SET `safety_inspect`='$safetyStatus' WHERE bike_id= $id");
        $results = mysqli_query($conn,$query);
        return "Broken";
    }
    //Print available status if item is not present in the bookings table
    else if ($booking->num_rows == 0) {
        return "Available";
    } else {
        //Retrieving the bike's allocated booking id from the booking table
        $query = "SELECT booking_id FROM booking_bike_table WHERE bike_id= $id ORDER By booking_bike_id DESC";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        if (isset($row['booking_id'])) {
            $bookingId = $row['booking_id'];
        }
        //Retrieving the booking details based on allocated booking id for the bike from the booking table
        $bookingDT = $conn->query("SELECT * FROM booking_table WHERE booking_id= $bookingId")->fetch_assoc();
        //Checking if the start date of the booking is after today
        if (strtotime($bookingDT["start_date"]) > strtotime(date("Y-m-d"))) {
            return "Available";
        }
        //Checking if the end date of the booking is before today
        elseif (strtotime(date("Y-m-d")) > strtotime($bookingDT["end_date"])) {
            return "Available";} 
        else {
            //Checking if the end time of booking has passed
            if(strtotime($bookingDT["end_date"]) > strtotime(date("Y-m-d")))
            {
                $query = ("UPDATE bike_inventory_table SET `safety_inspect`='$safetyStatus' WHERE bike_id= $id");
                $results = mysqli_query($conn,$query);
                return "Not Available";
            }
            else if ((time() > strtotime($bookingDT["expected_end_time"]))) {
                $var = time();
                return "Available";
            } else {
                //updates safety status if the bike is in a booking
                $query = ("UPDATE bike_inventory_table SET `safety_inspect`='$safetyStatus' WHERE bike_id= $id");
                $results = mysqli_query($conn,$query);
                return "Not Available";
            }
        }
    }
}

// Checks the booking status of bikes based on current time and available bookings
function accessory_availability_check($id)
{   
    //variable to set safety status to not checked
    $safetyStatus = 0;
    //Establishing connection to the db
    $conn = new mysqli("localhost", "root", "", "bike_hiring_system");
    //Checking if the bike's id is not present in the booking table
    $booking = $conn->query("SELECT * FROM booking_accessory_table WHERE accessory_id= $id");
    //$damaged = $conn->query("SELECT * FROM damaged_items_table WHERE item_id= $id");

    //Checking if accessory id is present in the damaged items table
    $query = "SELECT * FROM damaged_items_table WHERE accessory_id= $id";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    //Print broken status if item is damaged after booking
    if (isset($row['accessory_id'])) 
    {
        // set item safety status to not inspected
        $query = ("UPDATE accessory_inventory_table SET `safety_inspect`='$safetyStatus' WHERE accessory_id= $id");
        $results = mysqli_query($conn,$query);
        return "Broken";
    }
    //Print available status if item is not present in the bookings table
    else if ($booking->num_rows == 0) 
    {
        return "Available";
    } 
    else 
    {
        //Retrieving the bike's allocated booking id from the booking table
        $query = "SELECT booking_id FROM booking_accessory_table WHERE accessory_id= $id ORDER By booking_accessory_id DESC";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        if (isset($row['booking_id'])) {
            $bookingId = $row['booking_id'];
        }
        //Retrieving the booking details based on allocated booking id for the bike from the booking table
        $bookingDT = $conn->query("SELECT * FROM booking_table WHERE booking_id= $bookingId")->fetch_assoc();
        //Checking if the start date of the booking is after today
        if (strtotime($bookingDT["start_date"]) > strtotime(date("Y-m-d"))) {
            return "Available";
        }
        //Checking if the end date of the booking is before today
        else if (strtotime(date("Y-m-d")) > strtotime($bookingDT["end_date"])) {
            return "Available";
        } else {
            //Checking if the end time of booking has passed
            if(strtotime($bookingDT["end_date"]) > strtotime(date("Y-m-d")))
            {
                //updates safety status if the bike is in a booking
                $query = ("UPDATE accessory_inventory_table SET `safety_inspect`='$safetyStatus' WHERE accessory_id= $id");
                $results = mysqli_query($conn,$query);
                return "Not Available";
            }
            //Checking if the end time of booking has passed
            else if ((time() > strtotime($bookingDT["expected_end_time"]))) {
                $var = time();
                return "Available";
            } else {
                //updates safety status if the bike is in a booking
                $query = ("UPDATE accessory_inventory_table SET `safety_inspect`='$safetyStatus' WHERE accessory_id= $id");
                $results = mysqli_query($conn,$query);
                return "Not Available";
            }
        }
    }
}

//Function sets availability status colour based on the status
function availabilityStatusColour($bookingStatus)
{
    // Green colour if available
    if ($bookingStatus == "Available") {
        return "#8DEF6E";
    }
    // Orange colour if not available
    else if ($bookingStatus == "Not Available") {
        return "#EFAC6E";
    }
    //Red colour in other cases
    else {
        return "#EF6E6E";
    }
}

//Function sets safety status colour based on the status
function safetyStatusColour($bookingStatus)
{
    // Green colour if checked
    if ($bookingStatus == "Checked") {
        return "#8DEF6E";
    }
    //Orange colour if not checked
    else if ($bookingStatus == "Not checked") {
        return "#EFAC6E";
    }
    //Red colour in other cases
    else {
        return "#EF6E6E";
    }
}

/* Regex functions for form validation - Pages: Inventory, Accessories, Accessory Types, Inventory Types */
function test_input($data)
{
    $data = trim($data);
    $data = stripcslashes($data);
    $data = htmlspecialchars($data);

    return $data;
}

// Valid Name -> Alphabets, Integers, Spaces, - and _
function validName($name)
{
    return preg_match("/^[a-zA-Z0-9-_' ]*$/", $name);
}
// Valid Price -> Only Integers or Decimals
function validPrice($price)
{
    return preg_match("/^\d{0,8}(\.\d{1,2})?$/", $price);
}
// Valid Price -> Only Integers
function validId($id)
{
    return preg_match("/^[0-9]{0,2}$/", $id);
}
// Check if array variable is empty
function checkEmptyVariables($arr)
{
    $ret = true;

    for ($i = 0; $i < count($arr) && $ret; $i++) {
        $ret &= !empty($arr[$i]);
    }

    return !$ret;
}
