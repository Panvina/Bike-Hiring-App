<?php
	function getDelim()
	{
		$delim = '';
		$os = strtoupper(substr(PHP_OS_FAMILY, 0, 3));

		// delimiters for each OS
		if ($os == "WIN")       // Windows (listed as Windows)
		{
			$delim = '\\';
		}
		elseif ($os == "LIN")   // Linux distros (listed as Linux)
		{
			$delim = '/';
		}
		elseif($os == "DAR")    // macOS (listed as Darwin)
		{
			$delim = ':';
		}
		else
		{
			// default to windows backslash
			echo "Failure";
			$delim = '\\';
		}

		return $delim;
	}
?>
