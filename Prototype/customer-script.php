<?php
    session_start();
    include("backend-connection.php");
    $conn = new DBConnection("customer_table");

    $name = $_GET["name"];
    $phoneNumber = $_GET["phoneNumber"];
    $email = $_GET["email"];
    $streetAddress = $_GET["streetAddress"];
    $suburb = $_GET["suburb"];
    $postCode = $_GET["postCode"];
    $licenceNumber = $_GET["licenceNumber"];

    $cols = "name, phone_number, email, street_address, suburb, post_code, licence_number";
    $data = "'$name', '$phoneNumber', '$email', '$streetAddress', '$suburb', '$postCode', '$licenceNumber'";
    if ($conn->insert($cols , $data) == true)
    {
        //$ret = $_POST["true"];
        $_SESSION["ret"] = "true";
        header("Location: Customer.php?insert=true");
    }
    else
    {
        $_SESSION["ret"] = "false";
        header("Location: Customer.php?insert=false");
    }
?>
