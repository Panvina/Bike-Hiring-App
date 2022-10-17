<?php
	include_once "../utils.php";

	// setup

	// test : checkEmptyVariables
	{
		$case1 = array('1', '2', '3', '4', '5');

		if (checkEmptyVariables($case1)) {
			echo "checkEmptyVariables failed. case 1 has no empty variables, but returned true<br>";
		}

		$case2 = $case1;
		$case2[1] = null;
		if (checkEmptyVariables($case2)) {
			echo "checkEmptyVariables success.<br>";
		}
		else {
			echo "checkEmptyVariables failed. case 1 has an empty variable, but returned false.<br>";
		}
	}

	// test joinDataAndCols
	{
		$testcase = array(
			"cols" => array("col1", "col2", "col3", "col4"),
			"data" => array(1, 2, 3, 4)
		);

		$actualResult = joinDataAndCols($testcase["data"], $testcase["cols"]);
		$expectedResult = array("col1='1'", "col2='2'", "col3='3'", "col4='4'");

		if ($actualResult == $expectedResult) {
			echo "joinDataAndCols success.<br>";
		}
		else {
			echo "joinDataAndCols fail. Expected: ";
			print_r($expectedResult);
			echo " Got: ";
			print_r($actualResult);
			echo "<br>";
		}
	}

	// test : validDate
	{
		// only testing with this format, as it is the only one used.
		$format = "d-M-Y";

		$testcase1 = "15-02-2000";
		$testcase2 = "30-02-2000";
		$testcase3 = "2000-02-15";

		if (validDate($testcase2, $format)) {
			echo "validDate failed. $testcase2 is not in format 'd-m-Y'<br>";
		}
		else if (validDate($testcase3, $format)) {
			echo "validDate failed. $testcase3 is not in format 'd-m-Y'<br>";
		}
		else if (validDate($testcase1, $format)) {
			echo "validDate success.'<br>";
		}
	}

	// test : getCurrentDate
	{
		$actualResult = getCurrentDate();
		$expectedResult = date('d-m-Y');
		if ($actualResult == $expectedResult) {
			echo "getCurrentDate success.<br>";
		}
		else {
			echo "getCurrentDate failed. <br>";
		}
	}

	// test : intToDayOfWeek
	{
		$expectedResult = array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");
		$actualResult = array();
		for($i = 0; $i < count($expectedResult); $i++) {
			 array_push($actualResult, intToDayOfWeek($i));
		}

		if ($expectedResult == $actualResult) {
			echo "intToDayOfWeek success.<br>";
		}
		else {
			echo "intToDayOfWeek failed. Expected: ";
			print_r($expectedResult);
			echo " Got: ";
			print_r($actualResult);
			echo "<br>";
		}
	}

	// test : getConflictingBookingsQuery
	{
		// Untested. Not tested standalone. Just returns a WHERE condition for SQL queries.
	}
?>
