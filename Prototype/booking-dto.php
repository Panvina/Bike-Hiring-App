<?php /* This file as a whole is written by Vina Touch 101928802 */
    include_once 'person-dto.php';
    include_once 'php-scripts/bookings-db.php';    //to retrieve a function
    class BookingDTO{
        private $username="";
        private $bookingid=array();
        private $accessory= array();
        private $startT = array();
        private $endT=array();
        private $duration=array();
        private $pickupLoc=array();
        private $dropOffLoc=array();
        private $fee=array();

        function __construct($login){
            $this->username=$login;
            if (str_contains($login, '@')){
                $user= new PersonDTO($login);
                $this->username= $user->getUsername();
            }
        }
        function getUsername(){
            return $this->username;
        }
        function getBookingID(){
            return $this->bookingid;
        }
        function getAccessory(){
            return $this->accessory;
        }
        function getStartT(){
            return $this->startT;
        }
        function getEndT(){
            return $this->endT;
        }
        function getDuration(){
            return $this->duration;
        }
        function getPickupLoc(){
            return $this->pickupLoc;
        }
        function getDropOffLoc(){
            return $this->dropOffLoc;
        }
        function getFee(){
            return $this->fee;
        }

        function getBookingBikeID($booking_id){
            $dbCon = new DBConnection('booking_bike_table');
            $bike = $dbCon->get('bike_id',("booking_id = '$booking_id'"));
            $bike = $bike[0]['bike_id'];
            return $bike;
        }

        function getBikeName($bikeid){
            $dbCon = new DBConnection('bike_inventory_table');
            $name = $dbCon->get('name',("bike_id = '$bikeid'"));
            $name = $name[0]['name'];
            return $name;
        }

        function getBikeAccessory($bookingid){
            $getID = new DBConnection('booking_accessory_table');
            $getName = new DBConnection('accessory_inventory_table');
            $accessoryID = $getID->get('accessory_id',("booking_id = '$bookingid'"));
            $accessoryName = array();
            foreach ($accessoryID as $row){
                $row = implode("",$row);
                $name = $getName->get('name',("accessory_id = '$row'"));
                array_push($accessoryName, $name[0]['name']);
            }
            return $accessoryName;
        }
        function getDetails($login=""){
            $login = $this->getUsername();
            $dbCon = new DBConnection('booking_table');
            $detail = $dbCon->get('*',("user_name = '$login'"));
            for ($i =0; $i<count($detail); $i++){            
                $oneDiArray = $detail[$i];
                array_push($this->bookingid,$oneDiArray['booking_id']);
                array_push($this->startT,$oneDiArray['start_date'] .": ". $oneDiArray['start_time']);
                array_push($this->endT,$oneDiArray['end_date'].": ". $oneDiArray['expected_end_time']);
                array_push($this->duration,$oneDiArray['duration_of_booking']);
                array_push($this->pickupLoc,$oneDiArray['pick_up_location']);
                array_push($this->dropOffLoc,$oneDiArray['drop_off_location']);
                array_push($this->fee,$oneDiArray['booking_fee']);
            }
            $this->printDetails($detail);
        }


        function printDetails($array){
            
            if (count($array)< 1){
                echo "<p>No current booking/s.</p>";
            }else{
                for ($i =0; $i<count($array); $i++){  
                    $bookingid =$this->bookingid[$i];                   
                    $bikeid = $this->getBookingBikeID($bookingid);
                    $bikeName = $this->getBikeName($bikeid);
                    $bikeAccessory = $this->getBikeAccessory($bookingid);
                    $bikeAccessory = implode(", ",$bikeAccessory);
                    $startT= $this->startT[$i];
                    $endT=$this->endT[$i];
                    $dur=$this->duration[$i];
                    $puLoc=$this->pickupLoc[$i];
                    $doLoc=$this->dropOffLoc[$i];
                    $fee=$this->fee[$i];
                    echo "
                    <h3>Booking ID: $bookingid</h3> 
                    <div class='text'>
                        <div class='text-col'>
                            <p><b>Bike ID:</b> $bikeid</p>
                            <p><b>Bike Name:</b> $bikeName</p>
                            <p><b>Bike Accessory:</b> $bikeAccessory</p><br>
                            <p><b>Start Date and Time:</b> $startT</p>
                            <p><b>End Date and time:</b> $endT</p>
                            <p><b>Duration:</b> $dur</p></div>
                        <div class='text-col'>
                            <p><b>Pick-up Location:</b> $puLoc</p>
                            <p><b>Drop-off Location:</b> $doLoc</p><br>
                            <p><b>Booking Fee:</b> $$fee</p></div>
                    </div>
                    <form method='post' action='booking-summary.php' class='confirm'>
                        <input type='hidden' name='cancelBookingID' value='$bookingid'>
                        <input type='submit' name='cancelBooking'
                        class='button' value='Cancel this Booking' />
                    </form>
                    <hr>     
                 ";
                }
            }
        }
    }
?>