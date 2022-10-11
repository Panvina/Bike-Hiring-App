<!--
Project Name: Inverloch Bike Hire
Project Description: A website for hiring bikes. Front-end accompanied
	   by an admin dashboard.
File Description: reusable functions for the project
Contributor:
	- Clement Cheung @ 103076376@student.swin.edu.au
-->
<!-- This page is completely done by Clement-->

<?php //This page is where if there is PHP code shared 2 or more pages, it will be stored here
//this is to santise the code so it can avoid any attacks from outside sources and make it easier for data to be send to database
function sanitise_input($data)
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  $data = str_replace("'", "`", $data);
  return ($data);
}

//this is to check if the checkbox is null or not and change it into a numeric function
function isItNull($checkbox)
{
  $result = "0";
  if (!is_null($checkbox)) {
    $result = "1";
  }
  return ($result);
}

//this is to transfer from database numeric to checkbox value.
function checkValue($value)
{
  $results = "";
  if ($value >= "1") {
    $results = "checked";
  }
  return $results;
}

//this is checking if the item is empty or not
function isempty($item)
{
  if ($item == "") {
    return true;
  }
  return false;
}

//This is mainly checking the postcode size to be 4 digits
function postCodeSize($postcode)
{
  $regex = '/^\d{4}$/';
  return preg_match($regex, $postcode);
}

//This is checking if the location of the bike located in a Victorian Postcode since the buisness is located and serve in Victoria
function validVicPostCode($postCode)
{
  return (substr($postCode, -4, 1) == 3);
}

//This validates if the suburb is AlphaNumeric
function suburbValidate($suburb)
{
  $regex = "/^[a-zA-Z',.\s-]{1,25}$/";
  return preg_match($regex, $suburb);
}

//validates addresses
//ref: https://stackoverflow.com/questions/21264194/simple-regex-for-street-address
function validHomeAddress($address)
{
  $regex = '/^\s*\S+(?:\s+\S+){2}/';
  return preg_match($regex, $address);
}
?>