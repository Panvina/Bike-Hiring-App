<!-- All code on this page has been completed by Jake.H 102090870 -->
<?php
    //start the session with the database
    session_start();
    //include database functions
    include_once("backend-connection.php");
    include_once "utils.php";
    //create the connection with the database
    $conn = new DBConnection("employee_table");

    //created a empty array to hold the fetched data
    $ret = array();
    //fetch the primary key from the displayed data
    $pk = $_POST['UpdateButton'];
 
    //establish the columns of the database for querying
    $cols = "user_name, name, phone_number, email, address, suburb, post_code, state";
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
        $_SESSION["name"] = $fetchData["name"];
        $_SESSION["phone_number"] = $fetchData["phone_number"];
        $_SESSION["email"] = $fetchData["email"];
        $_SESSION["street_address"] = $fetchData["address"];
        $_SESSION["suburb"] = $fetchData["suburb"];
        $_SESSION["post_code"] = $fetchData["post_code"];
        $_SESSION["state"] = $fetchData["state"];

        //create variables for the session variables due to string errors when querying
        $name = $_SESSION["name"];
        $phoneNumber = $_SESSION["phone_number"];
        $email = $_SESSION["email"];
        $streetAddress = $_SESSION["street_address"];
        $suburb =  $_SESSION["suburb"];
        $postCode = $_SESSION["post_code"];
        $state = $_SESSION["state"];

        //checks to see if any of the variables is empty then redirects back based on the result
        if (!checkEmptyVariables([$name, $phoneNumber, $email, $streetAddress, $suburb , $postCode, $state]))
        {
            header("Location: staff.php?update=notEmpty");
            exit();
        }
        else
        {
            header("Location: staff.php?update=empty");
            exit();
        }
   }
   
   //checks to see if the submit button in the update form has been pressed
   if (isset($_POST["submitUpdateStaff"]))
   {
    //REASSIGN VARIABLES with post
        $pk = $_POST["userName"];
        $name = $_POST["name"];
        $phoneNumber = $_POST["phoneNumber"];
        $email = $_POST["email"];
        $streetAddress = $_POST["streetAddress"];
        $suburb = $_POST["suburb"];
        $postCode = $_POST["postCode"];
        $state = $_POST["state"];

        //------------------------------------------------------
        //Name input validation
        //checks to see if input is empty
        if (empty($_POST["name"])) 
        {
           header("Location: staff.php?update=nameEmptyErr");
        }
        //checks to see if the name is valid and matches the pattern
        else if (!validName($_POST["name"])) 
        {
            header("Location: staff.php?update=nameValidErr");
        } 
        else 
        {
            //cleans the input and assigns the variable for inserting
            $name = test_input($_POST["name"]);
        }
        //------------------------------------------------------
        //Phone number input validation
        //checks to see if input is empty
        if (empty($_POST["phoneNumber"]))
        {
            header("Location: staff.php?update=phoneNumberEmptyErr");
        } 
        //checks to see if the mobile number is valid and matches the pattern
        else if (!validMobileNumber($_POST["phoneNumber"])) 
        {
            header("Location: staff.php?update=phoneValidErr");
        } 
        else 
        {
            //cleans the input and assigns the variable for inserting
            $phoneNumber = test_input($_POST["phoneNumber"]);
        }
        //------------------------------------------------------
        //Email input validation
        //checks to see if input is empty
        if (empty($_POST["email"])) {
            header("Location: staff.php?update=emailEmptyErr");
        }
        //checks to see if the email is valid and matches the pattern
        else if (!validEmail($_POST["email"])) 
        {
            header("Location: staff.php?update=emailValidErr");
        }
        else 
        {
            //cleans the input and assigns the variable for inserting
            $email = test_input($_POST["email"]);
        }
        //------------------------------------------------------
        //Street address input validation
        //checks to see if input is empty
        if (empty($_POST["streetAddress"])) 
        {
            header("Location: staff.php?update=streetAddressEmptyErr");
        }
        //checks to see if the address is valid and matches the pattern
        else if (!validAddress($_POST["streetAddress"])) 
        {
            //cleans the input and assigns the variable for inserting
            header("Location: staff.php?update=streetAddressValidErr");
        } 
        else 
        {
            //cleans the input and assigns the variable for inserting
            $streetAddress = test_input($_POST["streetAddress"]);
        }
        //------------------------------------------------------
        //Suburb input validation
        //checks to see if input is empty
        if (empty($_POST["suburb"])) 
        {
            header("Location: staff.php?update=suburbEmptyErr");
        }
        //checks to see if the suburb is valid and matches the pattern
        else if (!validName($_POST["suburb"])) 
        {
            header("Location: staff.php?update=suburbValidErr");
        } 
        else 
        {
            //cleans the input and assigns the variable for inserting
            $suburb = test_input($_POST["suburb"]);
        }
        //------------------------------------------------------
        //Postcode input validation
        //checks to see if input is empty
        if (empty($_POST["postCode"])) 
        {
            header("Location: staff.php?update=postCodeEmptyErr");
        }
        //checks to see if the postcode is valid and matches the pattern
        else if (!validPostCode($_POST["postCode"])) 
        {
            header("Location: staff.php?update=postCodeValidErr");
        }  
        else 
        {
            //cleans the input and assigns the variable for inserting
            $postCode = test_input($_POST["postCode"]);
        }
        //------------------------------------------------------
        //State input validation
        //checks to see if input is empty
        if (empty($_POST["state"])) 
        {
            header("Location: staff.php?update=stateEmptyErr");
        } 
        //checks to see if the state is valid and matches the pattern
        else if (!validState($_POST["state"])) 
        {
            header("Location: staff.php?update=stateValidErr");
        }  
        else 
        {
            //cleans the input and assigns the variable for inserting
            $state = test_input($_POST["state"]);
        }

        //double checks to ensure all variables are not empty then parses the data to be updated. Returns back to the customer page based on the result
        if(!empty($name) && !empty($phoneNumber) && !empty($email) && !empty($streetAddress) && !empty($suburb) && !empty($postCode) && !empty($state))
        {
            if ($conn->update("user_name", "'$pk'", "name, phone_number, email, address, suburb, post_code, state",
            "$name, $phoneNumber, $email, $streetAddress, $suburb, $postCode, $state") == true)
            {
                
                header("Location: staff.php?update=true");
                exit();
            }
            else
            {
                header("Location: staff.php?update=false");
                exit();
            }
        }   
   }
        
?>