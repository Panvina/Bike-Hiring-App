<!-- All code on this page has been completed by Jake.H 102090870 -->
<?php
    //start the session with the database
    session_start();
    //include database functions
    include "backend-connection.php";
    include "customer-db.php";
    include_once "utils.php";
    //create the connection with the database
    $conn = new CustomerDBConnection("customer_table");

    //define the err variables
    $userNameErr = $nameErr = $phoneNumberErr = $emailErr = $streetAddressErr = $suburbErr = $postCodeErr = $licenceNumberErr = $stateErr = "";
    $_SESSION["userNameErr"] = "";
    //$customerPrefix = "CU"; 

    //checks to see form has opened
    if (isset($_POST['SubmitCustomer']))
    {
        //User name input validation
        //checks to see if input is empty
        if (empty($_POST["userName"])) 
        {
            header("Location: ../Customer.php?insert=userNameEmptyErr");
        }
        //checks to see if the username is valid and matches the pattern
        else if (!validUserName($_POST["userName"])) 
        {
            header("Location: ../Customer.php?insert=userNameValidErr");
        }  
        else 
        {
            //cleans the input and assigns the variable for inserting
            $userName =  "CU-" . test_input($_POST["userName"]);

        }
        //------------------------------------------------------
        //Name input validation
        //checks to see if input is empty
        if (empty($_POST["name"])) 
        {
           header("Location: ../Customer.php?insert=nameEmptyErr");
        }
        //checks to see if the name is valid and matches the pattern
        else if (!validName($_POST["name"])) 
        {
            header("Location: ../Customer.php?insert=nameValidErr");
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
            header("Location: ../Customer.php?insert=phoneNumberEmptyErr");
        } 
        //checks to see if the mobile number is valid and matches the pattern
        else if (!validMobileNumber($_POST["phoneNumber"])) 
        {
            header("Location: ../Customer.php?insert=phoneValidErr");
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
            header("Location: ../Customer.php?insert=emailEmptyErr");
        }
        //checks to see if the email is valid and matches the pattern
        else if (!validEmail($_POST["email"])) 
        {
            header("Location: ../Customer.php?insert=emailValidErr");
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
            header("Location: ../Customer.php?insert=streetAddressEmptyErr");
        }
        //checks to see if the address is valid and matches the pattern
        else if (!validAddress($_POST["streetAddress"])) 
        {
            //cleans the input and assigns the variable for inserting
            header("Location: ../Customer.php?insert=streetAddressValidErr");
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
            header("Location: ../Customer.php?insert=suburbEmptyErr");
        }
        //checks to see if the suburb is valid and matches the pattern
        else if (!validName($_POST["suburb"])) 
        {
            header("Location: ../Customer.php?insert=suburbValidErr");
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
            header("Location: ../Customer.php?insert=postCodeEmptyErr");
        }
        //checks to see if the postcode is valid and matches the pattern
        else if (!validPostCode($_POST["postCode"])) 
        {
            header("Location: ../Customer.php?insert=postCodeValidErr");
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
            header("Location: ../Customer.php?insert=licenceNumberEmptyErr");
        } 
        //checks to see if the licence number is valid and matches the pattern
        else if (!validLicenceNumber($_POST["licenceNumber"])) 
        {
            header("Location: ../Customer.php?insert=licenceNumberValidErr");
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
            header("Location: ../Customer.php?insert=stateEmptyErr");
        } 
        //checks to see if the state is valid and matches the pattern
        else if (!validState($_POST["state"])) 
        {
            header("Location: ../Customer.php?insert=stateValidErr");
        }  
        else 
        {
            //cleans the input and assigns the variable for inserting
            $state = test_input($_POST["state"]);
        }

        //Double checks to ensure no field is empty
        if(!empty($userName) && !empty($name) && !empty($phoneNumber) && !empty($email) && !empty($streetAddress) && !empty($suburb) && !empty($postCode) && !empty($licenceNumber) && !empty($state))
        {

            //defines the SQL query for the customer table
            $customerCols = "user_name, name, phone_number, email, street_address, suburb, post_code, licence_number, state";
            $customerData = "'$userName', '$name', '$phoneNumber', '$email', '$streetAddress', '$suburb', '$postCode', '$licenceNumber', '$state'";
            $customerQuery = "INSERT INTO customer_table ($customerCols) VALUES ($customerData)";

            $accountCols = "user_name, role_id, password";
            $accountPassword = randomPassword();
            //$hashedAccountPassword = sha1($accountPassword);
            $hashedAccountPassword = password_hash($accountPassword, PASSWORD_DEFAULT);
            $accountData = "'$userName', 3, '$hashedAccountPassword'";
            $accountQuery = "INSERT INTO accounts_table (user_name, role_id, password) VALUES ($accountData)";
            
        
            $conn->runQuery("START TRANSACTION;");
        
            //Inserts the data into the database and checks if it was successful

            if ($conn->runQuery($customerQuery) == false)
            {
                header("Location: ../Customer.php?insert=false");
                exit();
                //header("Location: Customer.php?insert=true");
            }
            else if ($conn->runQuery($accountQuery) == false)
            {
                header("Location: ../Customer.php?insert=false");
                exit();
            }
            else
            {
                // commit changes to database
                $conn->runQuery("COMMIT;");
                header("Location: ../Customer.php?insert=true");
                exit();
            }          
        
        }

    }

?>
