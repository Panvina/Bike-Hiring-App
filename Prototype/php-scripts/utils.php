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
			$row = $arr[$i];
			$option = array();
			$id = $i;

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
				// echo "<br>val = $row[$key]<br>";
			}
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
        for($i = 0; $i < count($arrays); $i++)
        {
            $arrays[$i] = explode(",", $arrays[$i])[0];
        }

		return $arrays;
    }

	/**
	 * Validate email. Uses PHP email filter
	 */
	function validEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

	/**
	 * Validate name argument with regex
	 * Ensures that name is alphabetical, has a dash,
	 * has an apostrophe, or a space
	 */
    function validName($name)
    {
        return preg_match("/^[a-zA-Z-' ]*$/",$name);
    }

	/**
	 * Performs empty() OR operations for each variable in $arr
	 */
	function emptyArr($arr)
	{
		$ret = false;

		for($i = 0; $i < count($arr) && !$ret; $i++)
		{
			$ret |= empty($arr[$i]);
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
