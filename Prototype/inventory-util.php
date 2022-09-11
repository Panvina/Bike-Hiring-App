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
        //Establishing connection to the db
        $conn = new mysqli("localhost", "root", "", "bike_hiring_system");
        //Checking if the bike's id is not present in the booking table
        $booking = $conn->query("SELECT * FROM booking_bike_table WHERE bike_id= $id");
        if($booking->num_rows == 0){
            return "Available";
        }
        else{
            //Retrieving the bike's allocated booking id from the booking table
            $query = "SELECT booking_id FROM booking_bike_table WHERE bike_id= $id";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_assoc($result);
            if(isset($row['booking_id'])){
            $bookingId = $row['booking_id'];}
            //Retrieving the booking details based on allocated booking id for the bike from the booking table
            $bookingDT = $conn->query("SELECT * FROM booking_table WHERE booking_id= $bookingId") ->fetch_assoc();
                    //Checking if the start date of the booking is after today
                    if(strtotime($bookingDT["start_date"]) > strtotime(date("Y-m-d"))){
                        return "Available";
                    }
                    //Checking if the end date of the booking is before today
                    elseif(strtotime(date("Y-m-d")) > strtotime($bookingDT["end_date"]))
                    {
                        return "Available";
                    }
                    else {
                        //Checking if the end time of booking has passed
                        if(time() > strtotime($bookingDT["expected_end_time"])){
                            $var = time();
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
        //Establishing connection to the db
        $conn = new mysqli("localhost", "root", "", "bike_hiring_system");
        //Checking if the bike's id is not present in the booking table
        $booking = $conn->query("SELECT * FROM booking_accessory_table WHERE accessory_id= $id");
        if($booking->num_rows == 0){
            return "Available";
        }
        else{
            //Retrieving the bike's allocated booking id from the booking table
            $query = "SELECT booking_id FROM booking_accessory_table WHERE accessory_id= $id";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_assoc($result);
            if(isset($row['booking_id'])){
            $bookingId = $row['booking_id'];}
            //Retrieving the booking details based on allocated booking id for the bike from the booking table
            $bookingDT = $conn->query("SELECT * FROM booking_table WHERE booking_id= $bookingId") ->fetch_assoc();
                    //Checking if the start date of the booking is after today
                    if(strtotime($bookingDT["start_date"]) > strtotime(date("Y-m-d"))){
                        return "Available";
                    }
                    //Checking if the end date of the booking is before today
                    elseif(strtotime(date("Y-m-d")) > strtotime($bookingDT["end_date"]))
                    {
                        return "Available";
                    }
                    else {
                        //Checking if the end time of booking has passed
                        if(time() > strtotime($bookingDT["expected_end_time"])){
                            $var = time();
                            return "Available";
                        }
                        else {
                            return "Not Available";
                        }
                    }        
        }

    }
