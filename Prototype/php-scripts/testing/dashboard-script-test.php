<!--
Project Name: Inverloch Bike Hire
Project Description: A website for hiring bikes. Front-end accompanied
	   by an admin dashboard.
File Description: Server-side dashboard php scripts
Contributor(s):
	- Dabin Lee @ icelasersparr@gmail.com
-->

<?php
	include_once "../dashboard-script.php";

	// test : getFormattedDate
	{
		$testinput1 = "01-01-2021";
		$testinput2 = "02-02-2022";
		$testinput3 = "03-03-2023";
		$testinput4 = "04-04-2024";

		$expectedResult1 = "01st January 2021";
		$actualResult1 = getFormattedDate($testinput1);
		if ($expectedResult1 != $actualResult1) {
			echo "getFormattedDate 1 failed. Expected $expectedResult1. Got $actualResult1.<br>";
			exit();
		}

		$expectedResult2 = "02nd February 2022";
		$actualResult2 = getFormattedDate($testinput2);
		if ($expectedResult2 != $actualResult2) {
			echo "getFormattedDate 2 failed. Expected $expectedResult2. Got $actualResult2.<br>";
			exit();
		}

		$expectedResult3 = "03rd March 2023";
		$actualResult3 = getFormattedDate($testinput3);
		if ($expectedResult3 != $actualResult3) {
			echo "getFormattedDate 3 failed. Expected $expectedResult3. Got $actualResult3.<br>";
			exit();
		}

		$expectedResult4 = "04th April 2024";
		$actualResult4 = getFormattedDate($testinput4);
		if ($expectedResult4 != $actualResult4) {
			echo "getFormattedDate 4 failed. Expected $expectedResult4. Got $actualResult4.<br>";
			exit();
		}

		echo "getFormattedDate success.";

	}
?>
