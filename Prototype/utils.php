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
	// Returns false if any variables are empty
	function checkForEmptyVariables($arr)
	{
		$ret = true;

		for($i = 0; $i < count($arr) && $ret; $i++)
		{
			$ret &= !empty($arr[$i]);
			echo "<script></script>"
		}

		return $ret;
	}
?>
