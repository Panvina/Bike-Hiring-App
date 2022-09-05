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
