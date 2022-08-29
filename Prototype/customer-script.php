<?php
    session_start();
    include("backend-connection.php");
    $conn = new DBConnection("customer_table");

    $userNameErr = $nameErr = $phoneNumberErr = $emailErr = $streetAddressErr = $suburbErr = $postCodeErr = $licenceNumberErr = $stateErr = "";
    $_SESSION["userNameErr"] = "";

    function test_input($data)
    {
        $data = trim($data);
        $data = stripcslashes($data);
        $data = htmlspecialchars($data);

        return $data;
    }
    if (isset($_POST['SubmitCustomer']))
    {
        if (empty($_POST["userName"])) {
            header("Location: Customer.php?insert=userNameErr");
            exit();
        } 
        else {
            $userName = test_input($_POST["userName"]);

        }

        if (empty($_POST["name"])) {
           header("Location: Customer.php?insert=nameErr");
        } 
        else {
            $name = test_input($_POST["name"]);
        }

        if (empty($_POST["phoneNumber"])) {
            header("Location: Customer.php?insert=phoneNumberErr");
        } 
        else {
            $phoneNumber = test_input($_POST["phoneNumber"]);
        }

        if (empty($_POST["email"])) {
            header("Location: Customer.php?insert=emailErr");
        } 
        else {
            $email = test_input($_POST["email"]);
        }

        if (empty($_POST["streetAddress"])) {
            header("Location: Customer.php?insert=streetAddressErr");
        } 
        else {
            $streetAddress = test_input($_POST["streetAddress"]);
        }

        if (empty($_POST["suburb"])) {
            header("Location: Customer.php?insert=suburbErr");
        } 
        else {
            $suburb = test_input($_POST["suburb"]);
        }

        if (empty($_POST["postCode"])) {
            header("Location: Customer.php?insert=postCodeErr");
        } 
        else {
            $postCode = test_input($_POST["postCode"]);
        }

        if (empty($_POST["licenceNumber"])) {
            header("Location: Customer.php?insert=licenceNumberErr");
        } 
        else {
            $licenceNumber = test_input($_POST["licenceNumber"]);
        }

        if (empty($_POST["state"])) {
            header("Location: Customer.php?insert=stateErr");
        } 
        else {
            $state = test_input($_POST["state"]);
        }
    

        //$errorState = $_POST["SubmitCustomer"];
        //if ($errorState == "SubmitCustomer")
        if(!empty($userName) && !empty($name) && !empty($phoneNumber) && !empty($email) && !empty($streetAddress) && !empty($suburb) && !empty($postCode) && !empty($licenceNumber) && !empty($state))
        {
            $cols = "user_name, name, phone_number, email, street_address, suburb, post_code, licence_number, state";
            $data = "'$userName', '$name', '$phoneNumber', '$email', '$streetAddress', '$suburb', '$postCode', '$licenceNumber', '$state'";


            if ($conn->insert($cols , $data) == true)
            {
                //$ret = $_POST["true"];
                $_SESSION["ret"] = "true";
                header("Location: Customer.php?insert=true");
                exit();
            }
            else
            {
                $_SESSION["ret"] = "false";
                header("Location: Customer.php?insert=false");
                exit();
            }
        }
    }
?>
