<?php
    session_start();
    include("backend-connection.php");
    $conn = new DBConnection("customer_table");

    $userName = $_GET["userName"];
    $name = $_GET["name"];
    $phoneNumber = $_GET["phoneNumber"];
    $email = $_GET["email"];
    $streetAddress = $_GET["streetAddress"];
    $suburb = $_GET["suburb"];
    $postCode = $_GET["postCode"];
    $licenceNumber = $_GET["licenceNumber"];
    $state = $_GET["state"];

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
