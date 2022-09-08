<!-- All code on this page has been completed by Jake.H 102090870 -->
<?php
    //start the session with the database
    session_start();
    //include database functions
    include_once "php-scripts\bike-inventory-db.php";
    include_once "php-scripts\utils.php";
    //create the connection with the database
    $conn = new DBConnection("accounts_table");

    //created a empty array to hold the fetched data
    $ret = array();
    //fetch the primary key from the displayed data
    $pk = $_POST['UpdateButton'];
 
    //establish the columns of the database for querying
    $cols = "user_name, role_id, password";
    //establish the where condition for the query
    $condition = "user_name='$pk'";
    //fetch the data and assign it to the array
    $fetchData = $conn->get($cols, $condition);
    $fetchData = $fetchData[0];
    
    //checks to see if the first button is pressed
    if (isset($_POST['UpdateButton']))
  {
        //assigns session variables to the fetched array to be used to transfer data between forms
        $_SESSION["user_name"] = $fetchData["user_name"];
        $_SESSION["role_id"] = $fetchData["role_id"];
        $_SESSION["password"] = $fetchData["password"];
        //create variables for the session variables due to string errors when querying
        $roleID = $_SESSION["role_id"];
        $password = $_SESSION["password"];
  
        //checks to see if any of the variables is empty then redirects back based on the result
        if (!checkEmptyVariables([$roleID, $password]))
        {
            header("Location: accounts.php?update=notEmpty");
            exit();
        }
        else
        {
            header("Location: accounts.php?update=empty");
            exit();
        }

        // //checks to see if the username is valid and matches the pattern
        // if (!validUserName($password) )
        // {
        //     header("Location: accounts.php?update=passwordValidErr");
        //     exit();
        // }  
        // else 
        // {
        //     //cleans the input and assigns the variable for inserting
        //     $password =  test_input($password);

        // }
   }
   
   //checks to see if the submit button in the update form has been pressed
   if (isset($_POST["submitUpdateCustomer"]))
   {
    //REASSIGN VARIABLES with post
        $pk = $_POST["userName"];
        $roleID = $_POST["role_id"];
        $password = $_POST["password"];

        if (empty($password)) 
        {
            header("Location: accounts.php?update=passwordEmptyErr");
            exit();
        }
        //checks to see if the username is valid and matches the pattern
        else if (!validUserName($password)) 
        {
            header("Location: accounts.php?update=passwordValidErr");
            exit();
        }  
        else 
        {
           //cleans the input and assigns the variable for inserting. Then hashes the password for security purposes
           $password = test_input($password);
           $hashedAccountPassword = sha1($password);
        }
       
        //double checks to ensure all variables are not empty then parses the data to be updated. Returns back to the account page based on the result
        if(!empty($roleID) && !empty($password))
        {
            if ($conn->update("user_name", "'$pk'", "role_id, password","$roleID, $hashedAccountPassword") == true)
            {
                header("Location: accounts.php?update=true");
                exit();
            }
            else
            {
                header("Location: accounts.php?update=false");
                exit();
            }
        }   
   }
        
?>