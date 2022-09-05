<?php
    date_default_timezone_set('Australia/Melbourne');
    // Print Safety Inspection based on 0 or 1 values  
    function safety_check($val){
        if($val == 1 ){
            return "Checked";
        }
        else{
            return "Not checked";
        }
    }

    // Checks the booking status of bikes based on current time and available bookings
    function bike_availability_check($id){
        $conn = new mysqli("localhost", "root", "", "bike_hiring_system");
        $booking = $conn->query("SELECT * FROM booking_table WHERE booking_bike_id= $id");
        $bookingDT = $conn->query("SELECT * FROM booking_table WHERE booking_bike_id= $id") ->fetch_assoc();

                if($booking->num_rows == 0)
                {
                    return "Available";
                }
                else
                {
                    if(strtotime($bookingDT["start_date"]) > strtotime(date("Y-m-d"))){
                        return "Available";
                    }
                    elseif(strtotime(date("Y-m-d")) > strtotime($bookingDT["end_date"]))
                    {
                        return "Available";
                    }
                    else {
                        if(time() > strtotime($bookingDT["expected_end_time"])){
                            return "Available";
                        }
                        else {
                            return "Not Available";
                        }
                    }
                }
    } 

    // Checks the booking status of bikes based on current time and available bookings
    function accessory_availability_check($id){
        $conn = new mysqli("localhost", "root", "", "bike_hiring_system");
        $booking = $conn->query("SELECT * FROM booking_table WHERE booking_accessory_id= $id");
        $bookingDT = $conn->query("SELECT * FROM booking_table WHERE booking_accessory_id= $id") ->fetch_assoc();

                if($booking->num_rows == 0)
                {
                    return "Available";
                }
                else
                {
                    if(strtotime($bookingDT["start_date"]) > strtotime(date("Y-m-d"))){
                        return "Available";
                    }
                    elseif(strtotime(date("Y-m-d")) > strtotime($bookingDT["end_date"]))
                    {
                        return "Available";
                    }
                    else {
                        if(time() > strtotime($bookingDT["expected_end_time"])){
                            return "Available";
                        }
                        else {
                            return "Not Available";
                        }
                    }
                }
    } 



?>