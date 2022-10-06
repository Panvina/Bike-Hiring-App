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
    
    //creates session variables to be used to populate the form once an error has occured
    $_SESSION["customerInsertUserName"] = $_POST["userName"];
    $_SESSION["customerInsertName"] = $_POST["name"];
    $_SESSION["customerInsertPhoneNumber"] = $_POST["phoneNumber"];
    $_SESSION["customerInsertEmail"] = $_POST["email"];
    $_SESSION["customerInsertStreetAddress"] = $_POST["streetAddress"];
    $_SESSION["customerInsertSuburb"] = $_POST["suburb"];
    $_SESSION["customerInsertPostCode"] = $_POST["postCode"];
    $_SESSION["customerInsertLicenceNumber"] = $_POST["licenceNumber"];
    $_SESSION["customerInsertState"] = $_POST["state"];

    //checks to see form has opened
    if (isset($_POST['SubmitCustomer']))
    {
        if (empty($_POST["userName"]) && empty($_POST["name"]) && empty($_POST["phoneNumber"]) && empty($_POST["email"]) && empty($_POST["streetAddress"]) && empty($_POST["suburb"]) && empty($_POST["postCode"]) && empty($_POST["licenceNumber"]))
        {
            header("Location: ../Customer.php?insert=empty");
            exit();
        }

        //User name input validation
        //checks to see if input is empty
        if (empty($_POST["userName"])) 
        {
            header("Location: ../Customer.php?insert=userNameEmptyErr");
            exit();
        }
        //checks to see if the username is valid and matches the pattern
        else if (!validUserName($_POST["userName"])) 
        {
            header("Location: ../Customer.php?insert=userNameValidErr");
            exit();
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
           exit();
        }
        //checks to see if the name is valid and matches the pattern
        else if (!validName($_POST["name"])) 
        {
            header("Location: ../Customer.php?insert=nameValidErr");
            exit();
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
            exit();
        } 
        //checks to see if the mobile number is valid and matches the pattern
        else if (!validMobileNumber($_POST["phoneNumber"])) 
        {
            header("Location: ../Customer.php?insert=phoneValidErr");
            exit();
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
            exit();
        }
        //checks to see if the email is valid and matches the pattern
        else if (!validEmail($_POST["email"])) 
        {
            header("Location: ../Customer.php?insert=emailValidErr");
            exit();
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
            exit();
        }
        //checks to see if the address is valid and matches the pattern
        else if (!validAddress($_POST["streetAddress"])) 
        {
            //cleans the input and assigns the variable for inserting
            header("Location: ../Customer.php?insert=streetAddressValidErr");
            exit();
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
            exit();
        }
        //checks to see if the suburb is valid and matches the pattern
        else if (!validName($_POST["suburb"])) 
        {
            header("Location: ../Customer.php?insert=suburbValidErr");
            exit();
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
            exit();
        }
        //checks to see if the postcode is valid and matches the pattern
        else if (!validPostCode($_POST["postCode"])) 
        {
            header("Location: ../Customer.php?insert=postCodeValidErr");
            exit();
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
            exit();
        } 
        //checks to see if the licence number is valid and matches the pattern
        else if (!validLicenceNumber($_POST["licenceNumber"])) 
        {
            header("Location: ../Customer.php?insert=licenceNumberValidErr");
            exit();
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
            exit();
        } 
        //checks to see if the state is valid and matches the pattern
        else if (!validState($_POST["state"])) 
        {
            header("Location: ../Customer.php?insert=stateValidErr");
            exit();
        }  
        else 
        {
            //cleans the input and assigns the variable for inserting
            $state = test_input($_POST["state"]);
        }

        //Double checks to ensure no field is empty
        if(!empty($userName) && !empty($name) && !empty($phoneNumber) && !empty($email) && !empty($streetAddress) && !empty($suburb) && !empty($postCode) && !empty($licenceNumber))
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
                //unsets all session variables
                unset($_SESSION["customerInsertUserName"]);
                unset($_SESSION["customerInsertName"]);
                unset($_SESSION["customerInsertPhoneNumber"]);
                unset($_SESSION["customerInsertEmail"]);
                unset($_SESSION["customerInsertStreetAddress"]);
                unset($_SESSION["customerInsertSuburb"]);
                unset( $_SESSION["customerInsertPostCode"]);
                unset($_SESSION["customerInsertLicenceNumber"]);
                unset($_SESSION["customerInsertState"]);

                // commit changes to database
                $conn->runQuery("COMMIT;");
                header("Location: ../Customer.php?insert=true");
                exit();
            }          
        
        }
    }

?>
