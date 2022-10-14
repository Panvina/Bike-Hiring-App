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
	/**
	 * Takes in an array of items, and returns indices of items that are empty
	 */
	function returnEmptyVariables($arr)
	{
		$ret = array();

		for($i = 0; $i < count($arr); $i++)
		{
			if (empty($arr[$i]))
			{
				array_push($ret, $i);
			}
		}

		return $ret;
	}

	function printTimeComboBoxOptions($selectedTime=-1, $startHour=9, $endHour=17)
	{
		if ($selectedTime != -1)
		{
			$selectedTime = strtotime($selectedTime);
		}
		for($i = $startHour; $i <= $endHour; $i++)
		{
			$value = "$i:00";
			$valTime = strtotime($value);

			if ($selectedTime == $valTime)
			{
				echo "<option value='$value' selected='selected'>$value</option>";
			}
			else
			{
				echo "<option value='$value'>$value</option>";
			}
		}
	}

	/**
	 * Convert a PHP array to HTML select box options (combo boxes)
	 * - arr : PHP array
	 * - primaryKey : array key of id for combo box id
	 *
	 * Used in Alex's modals
	 */
	function arrayToComboBoxOptions($arr, $primaryKey=0, $selectedId=null)
	{
		// Get keys for array
		$keys = array_keys($arr[0]);
		for($i = 0; $i < count($arr); $i++)
		{
			$row = $arr[$i];	// get row
			$option = array();	// reset option to construct combobox option
			$id = $i;

			// retrieve data from rows and put into options
			for($j = 0; $j < count($keys); $j++)
			{
				$key = $keys[$j];
				if ($key == $primaryKey)
				{
					$id = $row[$key];
				}
				else
				{
					array_push($option, $row[$key]);
				}
			}

			// construct combo box option details
			$option = implode(": ", $option);
			if ($id != $selectedId)
			{
				echo "<option value='$id,$option'>$id: $option</option>";
			}
			else
			{
				echo "<option value='$id,$option' selected='selected'>$id: $option</option>";
			}
		}
	}

	/**
     * Convert combobox option to item id
     * Removes describing strings
     *
	 * Used in Alex's modals
     */
    function comboboxArrayToItemIdArray($arrays)
    {
		if (empty($arrays))
		{
			$arrays = array();
		}
		else
	    {
			for($i = 0; $i < count($arrays); $i++)
	        {
	            $arrays[$i] = explode(",", $arrays[$i])[0];
	        }
		}

		return $arrays;
    }

	// Validate email
	// Return true if valid email
	function validEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

	// Validate name
	// Return true if it is a valid name
    function validName($name)
    {
        return preg_match("/^[a-zA-Z-' ]*$/",$name);
    }

	// Check if any values within array are empty
	// Returns true if any variables are empty
	function checkEmptyVariables($arr)
	{
		$ret = true;

		for($i = 0; $i < count($arr) && $ret; $i++)
		{
			$ret &= !empty($arr[$i]);
			// echo "<script></script>";
		}

		return !$ret;
	}

	//ref: https://stackoverflow.com/questions/12018245/regular-expression-to-validate-username
	//Validates user name and returns true if its valid
		//Checks to see if username has the following criteria:
		//1. Only contains alphanumeric characters excluding underscore and dots
		//2. A underscore and dot cannot be used at the start, end or used together
		//3. The underscore and dots cannot be used multple times
		//4. Number of characters must be between 8 and 20 characters
	function validUserName($userName)
	{
		//return preg_match("/[a-z0-9_\-A-Z]{3,16}/",$userName);
		return preg_match("/^(?=.{8,20}$)(?![_.])(?!.*[_.]{2})[a-zA-Z0-9._]+(?<![_.])$/",$userName);
	}

	//Jake.H
	//takes in data and removes white spaces and removes special characters
	//ref: https://www.w3schools.com/php/php_form_validation.asp
	function test_input($data)
    {
        $sanitised = trim($data);
        $sanitised = stripcslashes($data);
        $sanitised = htmlspecialchars($data);

		echo "$data<br>$sanitised";

		// exit();
        return $sanitised;
    }

	//Jake.H
	//validates australian numbers
	//ref: https://regex101.com/library/SUjpie?orderBy=RELEVANCE&search=Australia+phone+number
	function validMobileNumber($phoneNumber)
	{
		return preg_match("(^\({0,1}((0|\+61)(2|4|3|7|8)){0,1}\){0,1}(\ |-){0,1}[0-9]{2}(\ |-){0,1}[0-9]{2}(\ |-){0,1}[0-9]{1}(\ |-){0,1}[0-9]{3}$)",$phoneNumber);
	}

	//Jake.H
	//validates addresses
	//ref: https://stackoverflow.com/questions/21264194/simple-regex-for-street-address
	function validAddress($address)
	{
		$pattern = '/^\d+(\s+\w+){1,}\s+((street|st)|(drive|dr)|(place|pl)|(avenue|av)|(rd|road)|(lane|ln)|(drive|way)|(court|ct)|(plaza|plz)|(square|sq)|run|parkway|point|pike|square|
		driveway|trace|park|(terrace|tce)|blvd|(ally|alley)|(circuit|cct)|(crescent|cr)|(esplanade|esp)|(grove|gr)|(heights|hts)|(highway|hwy)|(parade|pde))$/';
		$address = strtolower($address);
		$match = preg_match($pattern ,$address);

		// echo $pattern;
		// echo "\n";
		echo $address;
		echo "\n";
		if ($match) {
			echo "true";
		}
		else
		{
			echo "false";
		}
		// exit();

		return $match;
	}

	//Jake.H
	//validates post code to ensure there is only 4 numbers
	function validPostCode($postCode)
	{
		return preg_match("/^\d{4}$/",$postCode);
	}

	//Jake.H
	//validates Licence number to ensure there is only 9 numbers
	function validLicenceNumber($licenceNumber)
	{
		return preg_match("/^\d{9}$/",$licenceNumber);
	}

	//Jake.H
	//validates state to ensure its only a australian state
	function validState($state)
	{
		return preg_match("/\b(ACT|NSW|NT|QLD|SA|VIC|TAS|WA|Australian Capital Territory|New South Wales|Northern Territory|Queensland|South Australia|Victoria|Tasmania|Western Australia)\b/i",$state);
	}

	/**
	 * Performs empty() OR operations for each variable in $arr
	 * Returns true if anything in the array is empty.
	 */
	function emptyArr($arr)
	{
		$ret = false;

		for($i = 0; $i < count($arr); $i++)
		{
			$ret |= (empty($arr[$i]) || $arr[$i] == "");
		}

		return $ret;
	}

	/**
	 * Combine data with columns into single array of pairs
	 * e.g. [0, 1, 2, 3], [col1, col2, col3, col4] => ['col1=0, col2=1, col3=2, col4=3']
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
	 * Dabin
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
	 * Dabin
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

	//Jake.H reference: https://stackoverflow.com/questions/6101956/generating-a-random-password-in-php
	//creates a randomPassword with the length of 8 for the accounts table
	function randomPassword() {
		$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
		$pass = array(); //remember to declare $pass as an array
		$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
		for ($i = 0; $i < 8; $i++) {
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
		return implode($pass); //turn the array into a string
	}

	//Jake.H Prints out and assigned selected box based on states
	function printStates($state)
	{
		echo "<select name='state' id='state'>;";
		//checks to see if the state is VIC then make it selected
		if ($state == "VIC")
		{
			echo "<option value='VIC' selected>VIC</option>;";
		}
		else
		{
			echo "<option value='VIC'>VIC</option>;";
		}

		//checks to see if the state is NSW then make it selected
		if ($state == "NSW")
		{
			echo "<option value='NSW' Selected>NSW</option>;";
		}
		else
		{
			echo "<option value='NSW'>NSW</option>;";
		}

		//checks to see if the state is NT then make it selected
		if ($state == "NT")
		{
			echo "<option value='NT' Selected>NT</option>;";
		}
		else
		{
			echo "<option value='NT'>NT</option>;";
		}

		//checks to see if the state is QLD then make it selected
		if ($state == "QLD")
		{
			echo "<option value='QLD' Selected>QLD</option>;";
		}
		else
		{
			echo "<option value='QLD'>QLD</option>;";
		}

		//checks to see if the state is SA then make it selected
		if ($state == "SA")
		{
			echo "<option value='SA' Selected>SA</option>;";
		}
		else
		{
			echo "<option value='SA'>SA</option>;";
		}

		//checks to see if the state is WA then make it selected
		if ($state == "WA")
		{
			echo "<option value='WA' Selected>WA</option>;";
		}
		else
		{
			echo "<option value='WA'>WA</option>;";
		}

		//checks to see if the state is TAS then make it selected
		if ($state == "TAS")
		{
			echo "<option value='TAS' Selected>TAS</option>;";
		}
		else
		{
			echo "<option value='TAS'>TAS</option>;";
		}

		echo "</select>";
	}

	/*
	 * Returns a query to get conflicting bookings
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
