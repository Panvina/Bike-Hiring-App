<!-- A class that stores data for transfer-->
<!-- written by Vina Touch-->

<?php 
    include_once 'php-scripts/backend-connection.php';
    class PersonDTO{
        private $username="";
        private $name ="";
        private $phoneN="";
        private $email="";
        private $address="";
        private $license="";
        private $state="";
        private $role="";

        //if the login is an email, calls authByEmail function.
        function __construct($login){
            if (str_contains($login, '@')){
                $this->authByEmail($login);
            }else{
                $this->username=$login;
            }
        }

        function getUsername(){
            return $this->username;
        }
        function getName(){
            return $this->name;
        }
        function getPhoneN(){
            return $this->phoneN;
        }
        function getEmail(){
            return $this->email;
        }
        function getAddress(){
            return $this->address;
        }
        function getLicense(){
            return $this->license;
        }
        function getState(){
            return $this->state;
        }
        function getRole(){
            return $this->role;
        }

        //get details of the user logging in
        function getDetails($login=""){
            $login = $this->getUsername();
            $dbCon = new DBConnection('customer_table');
            $detail = $dbCon->get('*',("user_name = '$login'"));
            
            //converting multidimensional array into a 1D array. 
            $oneDiArray = array_reduce($detail, 'array_merge', array());

            //assign values from the array to the class variables appropriately.
            $this->name = $oneDiArray['name'];
            $this->phoneN= $oneDiArray['phone_number'];
            $this->email = $oneDiArray['email'];
            $this->address= $oneDiArray['street_address'] ." ". $oneDiArray ['suburb'] ." ". $oneDiArray ['post_code'] ." ". $oneDiArray ['state'];
            $this->license = $oneDiArray['licence_number'];
        }

        //authenticate the user when they log in through the popup on the website. 
        function authenticateUser($pwd){
            $id = $this->getUsername();
            $dbCon= new DBConnection('accounts_table');           
            $userID =$dbCon->get('user_name');
            $auth = "no user found"; 
            for($i=0; $i< count($userID); $i++){        //loop through the result array
                $userToString = implode(" ",$userID[$i]);       //convert array to string
                $userPwd = $dbCon->get('password', ("user_name = '$userToString'"));     
                $hashed_password= implode('',$userPwd[0]);  
                if ($userToString == $id && ($pwd == $hashed_password ||password_verify($pwd, $hashed_password))){      //allow access only if the userID and the password match the ones in the database
                    $roleID = $dbCon->get('role_id', ("user_name = '$userToString'"));   //fetch the role assigned to the user
                    if (implode('',$roleID[0]) == "3"){     //convert an array of array into string
                        return $auth = "3";
                    }else if (implode('',$roleID[0]) == "2"){
                        return $auth = "2"; 
                    }else{
                        return $auth = "1";
                    }
                }
            }
            return $auth;
        }

        //if the user input their email instead of the user ID
        function authByEmail($email){
            $dbCon= new DBConnection('customer_table');           
            $data =$dbCon->get('email');
            for($i=0; $i< count($data); $i++){        //loop through the result array
                $dataToString = implode(" ",$data[$i]);       //convert array to string
                if ($email == $dataToString){      //if the input email matches the one found in customer_table in the database
                    $username =$dbCon->get('user_name', ("email = '$dataToString'"));     //get the user_name where the email is
                    $this->username = implode("",$username[0]);
                }
            }

        }
    }
?>