<?php
	// Convert a PHP array to HTML select box options (combo boxes)
	// - arr : PHP array
	// - primaryKey : array key of id for combo box id
	//
	// Used in Alex's modals
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

	// Performs empty() OR operations for each variable in $arr
	function emptyArr($arr)
	{
		$ret = true;

		for($i = 0; $i < count($arr) && !$ret; $i++)
		{
			$ret |= empty($arr[$i]);
		}

		return $ret;
	}

	// Combine data with columns into single array of pairs
	function joinDataAndCols($data, $cols)
	{
		$ret = array();
		$lenData = count($data);

		echo "<br><br>TEST ";
		print_r($data);
		echo "<br><br>TEST 2";
		print_r($cols);
		echo "<br><br>";

		if ($lenData != count($cols))
		{
			$ret = null;
		}
		else
		{
			for($i = 0; $i < $lenData; $i++)
			{
				$col = $cols[$i];
				$dat = $data[$i];

				$str = "";
				$str .= "$col";
				$str .= "=";
				$str .= "'$dat'";

				array_push($ret, $str);
			}
		}

		return $ret;
	}
?>
