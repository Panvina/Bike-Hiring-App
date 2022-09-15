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
        $data = trim($data);
        $data = stripcslashes($data);
        $data = htmlspecialchars($data);

        return $data;
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
		return preg_match("/\d+(\s+\w+){1,}\s+(?:st(?:\.|reet)?|dr(?:\.|ive)?|pl(?:\.|ace)?|ave(?:\.|nue)?|rd|road|lane|drive|way|court|plaza|square|run|parkway|point|pike|square|driveway|trace|park|terrace|blvd)/",$address);
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
?>
