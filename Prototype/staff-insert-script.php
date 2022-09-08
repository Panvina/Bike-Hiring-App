<!-- All code on this page has been completed by Jake.H 102090870 -->
<?php
    //start the session with the database
    session_start();
    //include database functions
    include("php-scripts/backend-connection.php");
    include_once "php-scripts/utils.php";
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
            $userName = "EM-" . test_input($_POST["userName"]);

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
            //defines the SQL query for the customer table
            $staffCols = "user_name, name, phone_number, email, address, suburb, post_code, state";
            $staffData = "'$userName', '$name', '$phoneNumber', '$email', '$streetAddress', '$suburb', '$postCode', '$state'";
            $staffQuery = "INSERT INTO employee_table ($staffCols) VALUES ($staffData)";

            $accountCols = "user_name, role_id, password";
            $accountPassword = randomPassword();
            $accountData = "'$userName', 3, '$accountPassword'";
            $accountQuery = "INSERT INTO accounts_table (user_name, role_id, password) VALUES ($accountData)";
            
            //creates a transaction to run multiple queries to insert data into the staff and account table. Then commits.
            $conn->runQuery("START TRANSACTION;");
        
            if ($conn->runQuery($staffQuery) == false)
            {
                header("Location: staff.php?insert=false");
                exit();
            }
            else if ($conn->runQuery($accountQuery) == false)
            {
                header("Location: staff.php?insert=false");
                exit();
            }
            else
            {
                // commit changes to database
                $conn->runQuery("COMMIT;");
                header("Location: staff.php?insert=true");
                exit();
            }          
        }
    }
?>
