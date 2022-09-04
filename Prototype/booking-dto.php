<?php 
    class BookingDTO{
        private $username="";
        private $bikeid="";
        private $bikeName="";
        private $accessory= array();
        private $startT = "";
        private $endT="";
        private $duration="";
        private $pickupLoc="";
        private $dropOffLoc="";
        private $fee="";

        function __construct($login){
            $this->username=$login;
        }

        function getUsername(){
            return $this->username;
        }
        function getBikeID(){
            return $this->bikeid;
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
            $dbCon = new DBConnection();
            $detail = $dbCon->get('booking_table','*',("user_name = '$login'"));

            $oneDiArray = array_reduce($detail, 'array_merge', array());

            print_r($oneDiArray);

        }

    }
?>