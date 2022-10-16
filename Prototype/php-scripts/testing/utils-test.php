<!--
Project Name: Inverloch Bike Hire
Project Description: A website for hiring bikes. Front-end accompanied
	   by an admin dashboard.
File Description: Utility functions for the project
Contributor(s):
	- Dabin Lee @ icelasersparr@gmail.com
	- Jake Hipworth @ 102090870@student.swin.edu.au
-->

<?php
	// Check if any values within array are empty
	// Returns true if any variables are empty
	function checkEmptyVariables($arr)
	{
		$ret = true;

		for($i = 0; $i < count($arr) && $ret; $i++)
		{
			$ret &= !empty($arr[$i]);
		}

		return !$ret;
	}

	/**
	 * Combine data with columns into single array of pairs
	 * e.g. [0, 1, 2, 3], [col1, col2, col3, col4] => ['col1=0, col2=1, col3=2, col4=3']
	 * Dabin Lee
	 */
	function joinDataAndCols($data, $cols)
	{
		$ret = array();
		$lenData = count($data);

		// incorrect length check
		if ($lenData != count($cols))
		{
			$ret = null;
		}
		else
		{
			// reformat each corresponding data value and column to: "col=data"
			for($i = 0; $i < $lenData; $i++)
			{
				$col = $cols[$i];
				$dat = $data[$i];

				$str = "";
				$str .= "$col";
				$str .= "=";
				$str .= "'$dat'";

				// append to array
				array_push($ret, $str);
			}
		}

		return $ret;
	}

	/**
	 * Dabin Lee
	 * Adapted from https://stackoverflow.com/questions/12030810/php-date-validation
	 * Validate that $date is a date in the $format provided
	 */
	function validDate($date, $format)
	{
		$tmpDate = DateTime::createFromFormat($format, $date);
		$validDate = $tmpDate && $tmpDate->format($format) === $date;

		return $validDate;
	}

	/**
	 * Dabin Lee
	 * Adapted from https://stackoverflow.com/questions/470617/how-do-i-get-the-current-date-and-time-in-php
	 * Retrieve current date from server. If locale is specified, uses the datetime for given locale instead.
	 */
	function getCurrentDate($locale=null) {
		if ($locale != null)
		{
			date_default_timezone_set($locale);
		}

		$datetime = date('d-m-Y');
		return $datetime;
	}

	/**
	 * Convert integer from 0 to 6 to date of week text
	 * Dabin Lee
	 */
	function intToDayOfWeek($day)
	{
		$ret = "";
		switch($day)
		{
			case 1:
				$ret = "Monday";
				break;
			case 2:
				$ret = "Tuesday";
				break;
			case 3:
				$ret = "Wednesday";
				break;
			case 4:
				$ret = "Thursday";
				break;
			case 5:
				$ret = "Friday";
				break;
			case 6:
				$ret = "Saturday";
				break;
			case 0:
				$ret = "Sunday";
				break;
			default:
				$ret = "ERROR $day ERROR: ";
				break;
		}

		return $ret;
	}

	/*
	 * Returns a query to get conflicting bookings
	 * Dabin Lee
	 */
	function getConflictingBookingsQuery($startDate, $startTime, $endDate, $endTime)
	{
		// DATE FILTER
		// Non-overlapping dates are those with both the start date and end date either before or after. Reverse for overlapping dates
		$dateFilterQuery = "NOT ((start_date < '$startDate' AND end_date < '$startDate') OR (start_date > '$endDate' AND end_date > '$endDate'))";

		// TIME FILTER
		// Quite complex. Time filter matters if this.start_date == other.end_date or this.end_date == other.start_date
		// if this.start_date == other.end_date, this.start_time must be greater than other.end_time.
		// Additionally, if this.end_date == other.start_date, this.end_time must be greater than other.start_time
		// i.e. overlapping = ((this.end_date == other.start_date) AND (this.end_time < other.start_time)) OR ((this.start_date == other.end_date) AND (this.start_time > other.end_date ))
		$timeCondition1 = "('$endDate' = start_date AND CAST( '$endTime' AS TIME) >= start_time)";
		$timeCondition2 = "('$startDate' = end_date AND CAST('$startTime' AS TIME) <= expected_end_time)";
		// $timeCondition3 = "('$startDate' = start_date AND '$endDate' = end_date AND '$startTime' = start_time AND '$endTime' = expected_end_time)";
		$timeFilterQuery = "($timeCondition1 AND $timeCondition2)";
		// $timeFilterQuery = "($timeCondition1 OR $timeCondition2 OR $timeCondition3)";

		$filterQuery = "$timeFilterQuery OR $dateFilterQuery";

		return $filterQuery;
	}
?>
