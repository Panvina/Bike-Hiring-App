<!-- A class that stores data for transfer-->

<?php 
    include 'backend-connection.php';
?>
<?php 
    class PersonDTO{
        public $username="";
        public $name ="";
        public $phoneN="";
        public $email="";
        public $address="";
        public $license="";
        public $state="";
        public $role="";

        function __construct($name, $username=""){
            $this->name=$name;
            if ($username ==""){
                $this->username =$name;
            }else{
                $this->username=$username;
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

        function getDetails($name=""){
            $name = $this->getUsername();
            $dbCon = new DBConnection();
            $detail = $dbCon->get('customer_table','*',("user_name = '$name'"));
            for($i=0; $i< count($detail); $i++){ 
                echo $d[$i];
            }
        }
        function authenticateUser($pwd){
            $id = $this->getUsername();
            $dbCon= new DBConnection();           
            $userID =$dbCon->get('accounts_table', 'user_name');
            $auth = "no user found"; 
            for($i=0; $i< count($userID); $i++){        //loop through the result array
                $userToString = implode(" ",$userID[$i]);       //convert array to string
                $userPwd = $dbCon->get('accounts_table', 'password', ("user_name = '$userToString'"));        
                if ($userToString == $id &&  implode('',$userPwd[0]) == $pwd){      //allow access only if the userID and the password match the ones in the database
                    $roleID = $dbCon->get('accounts_table', 'role_id', ("user_name = '$userToString'"));   //fetch the role assigned to the user
                    if (implode('',$roleID[0]) == "3"){     //convert an array of array into string
                        return $auth = "3";
                    }else{
                        return $auth = "2"; 
                    }
                }
            }
            return $auth;
        }
    }
?>