<!--
Project Name: Inverloch Bike Hire
Project Description: A website for hiring bikes. Front-end accompanied
	   by an admin dashboard.
File Description: reusable functions for the project
Contributor:
	- Clement Cheung @ 103076376@student.swin.edu.au
-->
<!-- This page is completely done by Clement -->

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
  if ($value == "1") {
    $results = "checked";
  }
  return $results;
}
?>