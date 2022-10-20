<!--
Project Name: Inverloch Bike Hire
Project Description: A website for hiring bikes. Front-end accompanied
	   by an admin dashboard.
File Description: interface for interacting with the customer table and related operations.
Contributor(s) : Jake Hipworth @ 102090870@student.swin.edu.au
-->
<?php
include_once "../utils.php";

//Test User_name
//Only contains alphanumeric characters excluding underscore and dots
$userNameTest1 = "$5532%2sd";
//A underscore and dot cannot be used at the start, end or used together
$userNameTest2 = "_asdasdd";
$userNameTest3 = ".asdasdd";
$userNameTest4 = "asdd_.asd";
//The underscore and dots cannot be used multple times
$userNameTest5 = "asdd__asd";
$userNameTest6 = "asdd..asd";
//Number of characters must be between 8 and 20 characters
$userNameTest7 = "asd";
$userNameTest8 = "asdassdfgdasdffdsadfasdasdasd";

if(validUserName($userNameTest1) || validUserName($userNameTest2) || validUserName($userNameTest3) || validUserName($userNameTest4) || validUserName($userNameTest5) || validUserName($userNameTest6) 
|| validUserName($userNameTest7) || validUserName($userNameTest8)) 
{
    echo "Test Fail: User_name incorrect format.<br>";
}
else
{
    echo "Test success: User_name correct format.<br>";
}

//Test Name
//Only allows alphabetical characters
$name = "1523546520";
$name2 = "asdd2132";

if (validName($name) || validName($name2))
{
    echo "Test Fail: name incorrect format.<br>";
}
else
{
    echo "Test success: name correct format.<br>";
}


//Test Phone number
//Must be a australian number
$phoneNumber1 = "0123456789";
$phoneNumber2 = "02";
$phoneNumber3 = "02456899456312048";

if(validMobileNumber($phoneNumber1) || validMobileNumber($phoneNumber2) || validMobileNumber($phoneNumber3)) 
{
    echo "Test Fail: Mobile incorrect format.<br>";
}
else
{
    echo "Test success: Mobile correct format.<br>";
}

//Test Email
$email1 = "asdasd";
$email2 = "asdad@asddsad";

if(validEmail($email1) || validEmail($email2)) 
{
    echo "Test Fail: Email incorrect format.<br>";
}
else
{
    echo "Test success: Email correct format.<br>";
}

//Test residential address
//Must contain a number, street name, then a typical street type or its appreviation
$address1 = "asdasdads";
$address2 = "23 asdasdasd";
$address3 = "34/5#45";
$address4 = "23 test moon";

if(validAddress($address1) || validAddress($address2) || validAddress($address3) || validAddress($address4)) 
{
    echo "Test Fail: Address incorrect format.<br>";
}
else
{
    echo "Test success: Address correct format.<br>";
}

//Test Suburb
//Only allows alphabetical characters
$suburb1 = "45454654";
$suburb2 = "asdads56453";
$suburb3 = "Aasdaa#$%f^";

if (validName($suburb1) || validName($suburb2) || validName($suburb3))
{
    echo "Test Fail: Suburb incorrect format.<br>";
}
else
{
    echo "Test success: Suburb correct format.<br>";
}

//Test Post code
//must be 4 numbers
$postcode1 = "asdddasdad";
$postcode2 = "asddsa#$%^";
$postcode3 = "0";
$postcode4 = "0123456789";

if (validPostCode($postcode1) || validPostCode($postcode2) || validPostCode($postcode3) || validPostCode($postcode4))
{
    echo "Test Fail: Post code incorrect format.<br>";
}
else
{
    echo "Test success: Post code correct format.<br>";
}

//Test Drivers license Number
//must be 9 numbers
$driverslicense1 = "asdddasdad";
$driverslicense2 = "asddsa#$%^";
$driverslicense3 = "0";
$driverslicense4 = "012345678921321321";
$driverslicense5 = "042354";

if (validLicenceNumber($driverslicense1) || validLicenceNumber($driverslicense2) || validLicenceNumber($driverslicense3) || validLicenceNumber($driverslicense4) || validLicenceNumber($driverslicense5))
{
    echo "Test Fail: Drivers license incorrect format.<br>";
}
else
{
    echo "Test success: Drivers license correct format.<br>";
}
?>