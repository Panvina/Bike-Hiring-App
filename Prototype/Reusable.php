<?php //This page is where if there is PHP code shared 2 or more pages, it will be stored here
function sanitise_input($data)
{
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return($data);
}

function isItNull($checkbox)//this is to check if the checkbox is null or not
{
	$result = "0";
	if(!is_null($checkbox))
	{
		$result = "1";
	}
	return($result);
}

function checkValue($value)//this is to transfer from database value to display value
{
	$results = "";
	if($value=="1")
	{
		$results = "checked";
	}
	return $results;
}
?>