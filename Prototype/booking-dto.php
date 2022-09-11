<?php 
    class BookingDTO{
        private $username="";
        private $bookingid=array();
        private $bikeid=array();
        private $bikeName=array();
        private $accessory= array();
        private $startT = array();
        private $endT=array();
        private $duration=array();
        private $pickupLoc=array();
        private $dropOffLoc=array();
        private $fee=array();

        function __construct($login){
            $this->username=$login;
        }

        function getUsername(){
            return $this->username;
        }
        function getBookingID(){
            return $this->bookingid;
        }
        function getBikeID(){
            return $this->bikeID;
        }
        function getBikeName(){
            return $this->bikename;
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

        function cancelBooking($bookingID){

        }

        function printDetails($array){
            
            if (count($array)< 1){
                echo "<p>No current booking/s.</p>";
            }else{
                for ($i =0; $i<count($array); $i++){  
                    $bookingid =$this->bookingid[$i];
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
                            <p><b>Bike ID:</b> sad</p>
                            <p><b>Bike Name:</b> sad</p>
                            <p><b>Bike Accessory:</b></p>
                            <p>sad</p><br>
                            <p><b>Start Date and Time:</b> $startT</p>
                            <p><b>End Date and time:</b> $endT</p>
                            <p><b>Duration:</b> $dur</p></div>
                        <div class='text-col'>
                            <p><b>Pick-up Location:</b> $puLoc</p>
                            <p><b>Drop-off Location:</b> $doLoc</p><br>
                            <p><b>Booking Fee:</b> $fee</p></div>
                    </div>
                    <p>------------</p>       
                 ";
                }
            }
           
        }

    }
?>