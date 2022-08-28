<?php 
    require '../prototype/backend-connection.php';
        function authUser($id, $pwd){
        
        $dbCon= new DBConnection();           
        $userID =$dbCon->get('accounts_table', 'user_name');
        $auth = "no user found"; 
        for($i=0; $i< count($userID); $i++){        //loop through the result array
            $userToString = implode(" ",$userID[$i]);       //convert array to string
            $userPwd = $dbCon->get('accounts_table', 'password', ("user_name = '$userToString'"));        
            if ($userToString == $id &&  implode('',$userPwd[0]) == $pwd){      //allow access only if the userID and the password match the ones in the database
                $roleID = $dbCon->get('accounts_table', 'role_id', ("user_name = '$userToString'"));   //fetch the role assigned to the user
                if (implode('',$roleID[0]) == "C"){     //convert an array of array into string
                    return $auth = "C";
                }else{
                    return $auth = "A"; 
                }
            }
        }
        return $auth;
    }
?>