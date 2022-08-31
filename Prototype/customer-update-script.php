<!-- All code on this page has been completed by Jake.H 102090870 -->
<?php
    session_start();
    include_once("backend-connection.php");
    include_once "utils.php";
    $conn = new DBConnection("customer_table");

    $ret = array();
    //$primaryKey =  $_SESSION["primaryKey"];
    $pk = $_POST['updateCustomer'];
    //$pk = "Jake";

    //'<script>alert("Welcome to Geeks for Geeks")</script>'
    //echo $pk;
    $cols = "user_name, name, phone_number, email, street_address, suburb, post_code, licence_number, state";
    $condition = "user_name='$pk'";
    $ret = $conn->get($cols, $condition);
    $ret = $ret[0];
    
    if (isset($_POST['updateCustomer']))
  {
        $_SESSION["user_name"] = $ret["user_name"];
        $_SESSION["name"] = $ret["name"];
        $_SESSION["phone_number"] = $ret["phone_number"];
        $_SESSION["email"] = $ret["email"];
        $_SESSION["street_address"] = $ret["street_address"];
        $_SESSION["suburb"] = $ret["suburb"];
        $_SESSION["post_code"] = $ret["post_code"];
        $_SESSION["licence_number"] = $ret["licence_number"];
        $_SESSION["state"] = $ret["state"];

        $name = $_SESSION["name"];
        $phoneNumber = $_SESSION["phone_number"];
        $email = $_SESSION["email"];
        $streetAddress = $_SESSION["street_address"];
        $suburb =  $_SESSION["suburb"];
        $postCode = $_SESSION["post_code"];
        $licenceNumber =  $_SESSION["licence_number"];
        $state = $_SESSION["state"];

        // if (!checkEmptyVariables([$name, $phoneNumber, $email, $streetAddress, $suburb , $postCode, $licenceNumber, $state]))
        // {
        //     header("Location: Customer.php?update=notEmpty");
        //     exit();
        // }
        // else
        // {
        //     header("Location: Customer.php?update=empty");
        //     exit();
        // }
   }
   
   if (isset($_POST["submitUpdateCustomer"]))
   {
    //REASSIGN VARIABLES with post
        $pk = $_POST["userName"];
        $name = $_POST["name"];
        $phoneNumber = $_POST["phoneNumber"];
        $email = $_POST["email"];
        $streetAddress = $_POST["streetAddress"];
        $suburb = $_POST["suburb"];
        $postCode = $_POST["postCode"];
        $licenceNumber = $_POST["licenceNumber"];
        $state = $_POST["state"];

        //------------------------------------------------------
        //Name input validation
        //checks to see if input is empty
        if (empty($_POST["name"])) 
        {
           header("Location: Customer.php?update=nameEmptyErr");
        }
        //checks to see if the name is valid and matches the pattern
        else if (!validName($_POST["name"])) 
        {
            header("Location: Customer.php?update=nameValidErr");
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
            header("Location: Customer.php?update=phoneNumberEmptyErr");
        } 
        //checks to see if the mobile number is valid and matches the pattern
        else if (!validMobileNumber($_POST["phoneNumber"])) 
        {
            header("Location: Customer.php?update=phoneValidErr");
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
            header("Location: Customer.php?update=emailEmptyErr");
        }
        //checks to see if the email is valid and matches the pattern
        else if (!validEmail($_POST["email"])) 
        {
            header("Location: Customer.php?update=emailValidErr");
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
            header("Location: Customer.php?update=streetAddressEmptyErr");
        }
        //checks to see if the address is valid and matches the pattern
        else if (!validAddress($_POST["streetAddress"])) 
        {
            //cleans the input and assigns the variable for inserting
            header("Location: Customer.php?update=streetAddressValidErr");
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
            header("Location: Customer.php?update=suburbEmptyErr");
        }
        //checks to see if the suburb is valid and matches the pattern
        else if (!validName($_POST["suburb"])) 
        {
            header("Location: Customer.php?update=suburbValidErr");
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
            header("Location: Customer.php?update=postCodeEmptyErr");
        }
        //checks to see if the postcode is valid and matches the pattern
        else if (!validPostCode($_POST["postCode"])) 
        {
            header("Location: Customer.php?update=postCodeValidErr");
        }  
        else 
        {
            //cleans the input and assigns the variable for inserting
            $postCode = test_input($_POST["postCode"]);
        }
        //------------------------------------------------------
        //Licence number input validation
        //checks to see if input is empty
        if (empty($_POST["licenceNumber"])) 
        {
            header("Location: Customer.php?update=licenceNumberEmptyErr");
        } 
        //checks to see if the licence number is valid and matches the pattern
        else if (!validLicenceNumber($_POST["licenceNumber"])) 
        {
            header("Location: Customer.php?update=licenceNumberValidErr");
        }  
        else 
        {
            //cleans the input and assigns the variable for inserting
            $licenceNumber = test_input($_POST["licenceNumber"]);
        }
        //------------------------------------------------------
        //State input validation
        //checks to see if input is empty
        if (empty($_POST["state"])) 
        {
            header("Location: Customer.php?update=stateEmptyErr");
        } 
        //checks to see if the state is valid and matches the pattern
        else if (!validState($_POST["state"])) 
        {
            header("Location: Customer.php?update=stateValidErr");
        }  
        else 
        {
            //cleans the input and assigns the variable for inserting
            $state = test_input($_POST["state"]);
        }

        if(!empty($name) && !empty($phoneNumber) && !empty($email) && !empty($streetAddress) && !empty($suburb) && !empty($postCode) && !empty($licenceNumber) && !empty($state))
        {
            if ($conn->update("user_name", "'$pk'", "name, phone_number, email, street_address, suburb, post_code, licence_number, state",
            "$name, $phoneNumber, $email, $streetAddress, $suburb, $postCode, $licenceNumber, $state") == true)
            {
                $ret = $_POST["true"];
                header("Location: Customer.php?update=true");
                exit();
            }
            else
            {
                header("Location: Customer.php?update=false");
                exit();
            }
        }   
   }
        
?>