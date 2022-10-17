<!--
Project Name: Inverloch Bike Hire
Project Description: A website for hiring bikes. Front-end accompanied
	   by an admin dashboard.
File Description: Server-side dashboard php scripts
Contributor(s):
	- Dabin Lee @ icelasersparr@gmail.com
-->

<?php
	include_once "backend-connection.php";
	include_once "utils.php";

	function getFormattedDate($date)
	{
		$ret = "";

		// validate date
		if (validDate($date, "d-m-Y"))
		{
			// echo $date;

			// get day, month, and year
			$datetime = new DateTime($date);
			$dayWeek = intToDayOfWeek(date("w", strtotime($date)));
			$day = date("d", strtotime($date));
			$month = date("F", strtotime($date));
			$year = date("Y", strtotime($date));

			// $ret = "$dayWeek ";

			// add day string
			$dayLastDigit = $day % 10;
			if ("$day"[0] == '0') {
				$day = "$day[1]";
			}
			
			switch($dayLastDigit)
			{
				case 1:
					$ret .= "{$day}st ";
					break;
				case 2:
					$ret .= "{$day}nd ";
					break;
				case 3:
					$ret .= "{$day}rd ";
					break;
				default:
					$ret .= "{$day}th ";
					break;
			}



			// add month and year
			$ret .= "$month $year";
		}
		else
		{
			$ret = "error";
		}

		return $ret;
	}
?>
