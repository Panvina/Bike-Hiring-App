<!-- All code on this page has been completed by Jake.H 102090870 -->
<?php
    //start the session with the database
    session_start();
    //include database functions
    include("backend-connection.php");
    include_once "utils.php";
    //create the connection with the database
    $conn = new DBConnection("employee_table");

    //define the err variables
    $userNameErr = $nameErr = $phoneNumberErr = $emailErr = $streetAddressErr = $suburbErr = $postCodeErr = $stateErr = "";
    $_SESSION["userNameErr"] = "";

    //checks to see form has opened
    if (isset($_POST['SubmitStaff']))
    {
        //User name input validation
        //checks to see if input is empty
        if (empty($_POST["userName"])) 
        {
            header("Location: staff.php?insert=userNameEmptyErr");
        }
        //checks to see if the username is valid and matches the pattern
        else if (!validUserName($_POST["userName"])) 
        {
            header("Location: staff.php?insert=userNameValidErr");
        }  
        else 
        {
            //cleans the input and assigns the variable for inserting
            $userName = "EM-" + test_input($_POST["userName"]);

        }
        //------------------------------------------------------
        //Name input validation
        //checks to see if input is empty
        if (empty($_POST["name"])) 
        {
           header("Location: staff.php?insert=nameEmptyErr");
        }
        //checks to see if the name is valid and matches the pattern
        else if (!validName($_POST["name"])) 
        {
            header("Location: staff.php?insert=nameValidErr");
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
            header("Location: staff.php?insert=phoneNumberEmptyErr");
        } 
        //checks to see if the mobile number is valid and matches the pattern
        else if (!validMobileNumber($_POST["phoneNumber"])) 
        {
            header("Location: staff.php?insert=phoneValidErr");
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
            header("Location: staff.php?insert=emailEmptyErr");
        }
        //checks to see if the email is valid and matches the pattern
        else if (!validEmail($_POST["email"])) 
        {
            header("Location: staff.php?insert=emailValidErr");
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
            header("Location: staff.php?insert=streetAddressEmptyErr");
        }
        //checks to see if the address is valid and matches the pattern
        else if (!validAddress($_POST["streetAddress"])) 
        {
            //cleans the input and assigns the variable for inserting
            header("Location: staff.php?insert=streetAddressValidErr");
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
            header("Location: staff.php?insert=suburbEmptyErr");
        }
        //checks to see if the suburb is valid and matches the pattern
        else if (!validName($_POST["suburb"])) 
        {
            header("Location: staff.php?insert=suburbValidErr");
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
            header("Location: staff.php?insert=postCodeEmptyErr");
        }
        //checks to see if the postcode is valid and matches the pattern
        else if (!validPostCode($_POST["postCode"])) 
        {
            header("Location: staff.php?insert=postCodeValidErr");
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
            header("Location: staff.php?insert=stateEmptyErr");
        } 
        //checks to see if the state is valid and matches the pattern
        else if (!validState($_POST["state"])) 
        {
            header("Location: staff.php?insert=stateValidErr");
        }  
        else 
        {
            //cleans the input and assigns the variable for inserting
            $state = test_input($_POST["state"]);
        }
    
        //Double checks to ensure no field is empty
        if(!empty($userName) && !empty($name) && !empty($phoneNumber) && !empty($email) && !empty($streetAddress) && !empty($suburb) && !empty($postCode) && !empty($state))
        {
            //defines the SQL query
            $cols = "user_name, name, phone_number, email, address, suburb, post_code, state";
            $data = "'$userName', '$name', '$phoneNumber', '$email', '$streetAddress', '$suburb', '$postCode', '$state'";

            //Inserts the data into the database and checks if it was successful
            //If successful, redirects back to the customer page 
            if ($conn->insert($cols , $data) == true)
            { 
                header("Location: staff.php?insert=true");
                exit();
            }
            //If unsuccessful, redirects back to the customer page with error
            else
            {
                header("Location: staff.php?insert=false");
                exit();
            }
        }
    }
?>
