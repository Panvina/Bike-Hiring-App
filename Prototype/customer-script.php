<?php
    session_start();
    include("backend-connection.php");
    $conn = new DBConnection("customer_table");

    // $userName = test_input($_GET["userName"]);
    // $name = test_input($_GET["name"]);
    // $phoneNumber = test_input($_GET["phoneNumber"]);
    // $email = test_input($_GET["email"]);
    // $streetAddress = test_input($_GET["streetAddress"]);
    // $suburb = test_input($_GET["suburb"]);
    // $postCode = test_input($_GET["postCode"]);
    // $licenceNumber = test_input($_GET["licenceNumber"]);
    // $state = test_input($_GET["state"]);

    $userNameErr = $nameErr = $phoneNumberErr = $emailErr = $streetAddressErr = $suburbErr = $postCodeErr = $licenceNumberErr = $stateErr = "";
    $_SESSION["userNameErr"] = "";

    function test_input($data)
    {
        $data = trim($data);
        $data = stripcslashes($data);
        $data = htmlspecialchars($data);

        return $data;
    }

    if (empty($_GET["userName"])) {
        //$userNameErr = "User Name is required";
        //$_SESSION["userNameErr"] = "User Name is required";
        header("Location: Customer.php?insert=userName");
        exit();
    } 
    else {
        $userName = test_input($_GET["userName"]);
    }

    if (empty($_GET["name"])) {
        $nameErr = "Name is required";
    } 
    else {
        $name = test_input($_GET["name"]);
    }

    if (empty($_GET["phoneNumber"])) {
        $phoneNumberErr = "Phone number is required";
    } 
    else {
        $phoneNumber = test_input($_GET["phoneNumber"]);
    }

    if (empty($_GET["email"])) {
        $emailErr = "Email is required";
    } 
    else {
        $email = test_input($_GET["email"]);
    }

    if (empty($_GET["streetAddress"])) {
        $streetAddressErr = "Street Address is required";
    } 
    else {
        $streetAddress = test_input($_GET["streetAddress"]);
    }

    if (empty($_GET["suburb"])) {
        $suburbErr = "Suburb is required";
    } 
    else {
        $suburb = test_input($_GET["suburb"]);
    }

    if (empty($_GET["postCode"])) {
        $postCodeErr = "Post code is required";
    } 
    else {
        $postCode = test_input($_GET["postCode"]);
    }

    if (empty($_GET["licenceNumber"])) {
        $licenceNumberErr = "Licence number is required";
    } 
    else {
        $licenceNumber = test_input($_GET["licenceNumber"]);
    }

    if (empty($_GET["state"])) {
        $stateErr = "State is required";
    } 
    else {
        $state = test_input($_GET["state"]);
    }

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
    
?>
