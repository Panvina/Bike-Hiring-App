<?php
	// Convert a PHP array to HTML select box options (combo boxes)
	// - arr : PHP array
	// - primaryKey : array key of id for combo box id
	function arrayToComboBoxOptions($arr, $primaryKey=0)
	{
		// Get keys for array
		$keys = array_keys($arr[0]);
		for($i = 0; $i < count($arr); $i++)
		{
			$row = $arr[$i];
			$option = array();
			$id = $i;

			for($j = 0; $j < count($keys); $j++)
			{
				$key = $keys[$j];
				if ($key == $primaryKey)
				{
					$id = $key;
				}
				// echo "<br>val = $row[$key]<br>";
				array_push($option, $row[$key]);
			}
			$option = implode(": ", $option);
			echo "<option value='$id,$option'>$option</option>";
		}
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
?>
