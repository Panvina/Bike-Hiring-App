<?php /* This file as a whole is written by Vina Touch 101928802 */
    include_once 'person-dto.php';
    include_once 'php-scripts/bookings-db.php';    //to retrieve a function
    class BookingDTO{
        private $username="";
        private $bookingid=array();
        private $accessory= array();
        private $startT = array();
        private $endT=array();        
        private $startD = array();
        private $endD=array();
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
        function getStartD(){
            return $this->startD;
        }
        function getEndD(){
            return $this->endD;
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

        function getPickUpLocNameAddress($pickupID){
            $dbCon = new DBConnection('location_table');
            $pickupLoc = $dbCon->get('name, address, suburb, post_code',("location_id = '$pickupID'"));
            $pickupLoc = $pickupLoc[0]['name'] . ", " . $pickupLoc[0]['address'] . " " . $pickupLoc[0]['suburb'] . " " . $pickupLoc[0]['post_code'];

            return $pickupLoc;
        }

        function getDropOffLocNameAddress($dropOffID){
            $dbCon = new DBConnection('location_table');
            $dropOffLoc = $dbCon->get('name, address, suburb, post_code',("location_id = '$dropOffID'"));
            $dropOffLoc =  $dropOffLoc[0]['name'] . ", " . $dropOffLoc[0]['address'] . " " . $dropOffLoc[0]['suburb'] . " " . $dropOffLoc[0]['post_code'];

            return $dropOffLoc;
        }

        function getBookingBikeID($booking_id){
            $dbCon = new DBConnection('booking_bike_table');
            $bike = $dbCon->get('bike_id',("booking_id = '$booking_id'"));
            $bikeList = array();
            foreach ($bike as $row){
                $row = implode("",$row);
                array_push($bikeList, $row);
            }
            return $bikeList;
        }

        function getBikeName($bikeid){
            $dbCon = new DBConnection('bike_inventory_table');
            $bikeName = array();
            foreach ($bikeid as $row){
                $name = $dbCon->get('name',("bike_id = '$row'"));
                array_push($bikeName, $row . " ".$name[0]['name']);
            }
            return $bikeName;
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
                array_push($this->startD,$oneDiArray['start_date']);
                array_push($this->startT,$oneDiArray['start_time']);
                array_push($this->endD,$oneDiArray['end_date']);
                array_push($this->endT,$oneDiArray['expected_end_time']);
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
                    //$bikeid = implode(", ",$bikeid);
                    $bikeName = implode(", ",$bikeName);
                    $bikeAccessory = $this->getBikeAccessory($bookingid);
                    $bikeAccessory = implode(", ",$bikeAccessory);
                    $startT= $this->startT[$i];
                    $endT=$this->endT[$i];
                    $startD= $this->startD[$i];
                    $endD=$this->endD[$i];
                    $dur=$this->duration[$i];
                    $puLoc=$this->getPickUpLocNameAddress($this->pickupLoc[$i]);
                    $doLoc=$this->getDropOffLocNameAddress($this->dropOffLoc[$i]);
                    $fee=$this->fee[$i];

                    echo "
                    <h3>Booking ID: $bookingid</h3>
                    <div class='text'>
                        <div class='text-col'>
                            <p><b>Bike Name:</b> $bikeName</p>
                            <p><b>Bike Accessory:</b> $bikeAccessory</p><br>
                            <p><b>Start Date:</b> $startD</p>
                            <p><b>Start Time:</b> $startT</p>
                            <p><b>End Date:</b> $endD</p>   
                            <p><b>End time:</b> $endT</p>
                            <p><b>Duration:</b> $dur hour/s</p></div>
                        <div class='text-col'>
                            <p><b>Pick-up Location:</b> $puLoc</p>
                            <p><b>Drop-off Location:</b> $doLoc</p>
                            <hr>
                            <p><b>Booking Fee:</b> $$fee</p></div>
                    </div>
                    <form method='post' action='booking-summary.php' class='confirm'>
                        <input type='hidden' name='cancelBookingID' value='$bookingid'>
                        <input type='submit' name='cancelBooking'
                        class='acc-button cancel-booking-button' value='Cancel this Booking' />
                    </form><br>
                    <hr>
                 ";
                }
            }
        }
    }
?>
