<?php
    session_start();
    include("backend-connection.php");
    $conn = new DBConnection("customer_table");

    $ret = array();
    //$primaryKey =  $_SESSION["primaryKey"];
    $pk = $_POST["updateCustomer"];

    //'<script>alert("Welcome to Geeks for Geeks")</script>'
    //echo $pk;
    $cols = "user_name, name, phone_number, email, street_address, suburb, post_code, licence_number, state";
    $condition = "user_name='$pk'";
    $ret = $conn->get($cols, $condition);
    $ret = $ret[0];
        
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

    //echo "<p> $name </p>";
   // echo "$phoneNumber";
    
    // if ($conn->insert($cols , $data) == true)
    // {
        //$ret = $_POST["true"];
//     if (count($ret) > 0)
//     {
//         header("Location: Customer.php?update=true");
//         exit();
//     }   
//     //}
//     //else
//    // {
//     else
//     {
//         header("Location: Customer.php?update=false");
//         exit();
//     }  
    // if ($conn->update("user_name", "$_SESSION['user_name']", "name, phone_number, email, street_address, suburb, post_code, licence_number, state", 
    // "$_SESSION['name'], $_SESSION['phone_number'], $_SESSION['email'], $_SESSION['street_address'], $_SESSION['suburb'], $_SESSION['post_code'], $_SESSION['licence_number'], $_SESSION['state']")
    // == true)
    // if ($conn->update("user_name", "Jake", "name, phone_number, email, street_address, suburb, post_code, licence_number, state", 
    // "New Jake, new phone number, new email, new address, new suburb, new post code, new licence number, new state")
    // == true)
   echo $name;
   echo $phoneNumber;
    if ($conn->update("user_name", "'$pk'", "name, phone_number, email, street_address, suburb, post_code, licence_number, state",
     "$name, $phoneNumber, $email, $streetAddress, $suburb, $postCode, $licenceNumber, $state") == true)
    //$conn->update("BikeTypeID", $toUpdateId, "Description, Name", "New Description, Updated-Hydro");
        {
            //$ret = $_POST["true"];
            header("Location: Customer.php?update=true");
            exit();
        }
        else
        {
            header("Location: Customer.php?update=false");
            exit();
        }
        
    
//}
    // $key="";
    // $key = $_POST[$primaryKey];
    
    // echo $key;
    
?>