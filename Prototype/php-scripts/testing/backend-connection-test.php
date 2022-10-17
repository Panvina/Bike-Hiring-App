<?php
	/**
	 * Testing for backend-connection.php
	 * By Dabin Lee
	 */

	include_once "../backend-connection.php";

	// setup
	$testTable = "accessory_type_table";
	$testCols = ["name", "description"];
	$testPKeyName = "accessory_type_id";
	$conn = new DBConnection("accessory_type_table");
	$sqlTestOracle = new mysqli("localhost", "root", "", "bike_hiring_system");

	// data for testing
	$testName = "name1126491";
	$testDesc = "description1126491";
	$testDescModified = "description1126491modified";
	$id = "-1";		// placeholder

	try {
		// test: INSERT
		{
			$conn->insert(implode(", ", $testCols), "'$testName', '$testDesc'");

			// verify INSERT success
			$query = "SELECT * FROM $testTable WHERE name='$testName' AND description='$testDesc'";
			$res = $sqlTestOracle->query($query);
			if ($res->num_rows == 1) {
				$row = $res->fetch_assoc();
				$nameActual = $row[$testCols[0]];
				$descActual = $row[$testCols[1]];
				if ($nameActual == $testName && $descActual == $testDesc) {
					echo "INSERT success<br>";
					$id = $row[$testPKeyName];
				}
				else {
					echo "INSERT failed. name=$nameActual, desc=$descActual<br>";
					cleanup();
					exit();
				}
			}
			else {
				echo "INSERT failed. num_rows=$res->num_rows.<br>";
				cleanup();
				exit();
			}
		}

		// test: UPDATE - assuming INSERT success
		{
			$res = $conn->update($testPKeyName, $id, "description", "$testDescModified");
			if ($res) {
				// verify result from DBConnection.update is correct
				$query = "SELECT * FROM $testTable WHERE name='$testName' AND description='$testDescModified'";
				$res = $sqlTestOracle->query($query);
				if ($res->num_rows == 1) {
					$row = $res->fetch_assoc();
					$nameActual = $row[$testCols[0]];
					$descActual = $row[$testCols[1]];

					if ($nameActual == $testName && $descActual == $testDescModified) {
						echo "UPDATE succes.<br>";
					}
					else {
						echo "UPDATE failed. name=$nameActual, desc=$descActual<br>";
						cleanup();
						exit();
					}
				}
				else {
					echo "UPDATE failed. num_rows = $res->num_rows<br>";
					cleanup();
					exit();
				}
			}
			else {
				echo "UPDATE failed. res is false.<br>";
				cleanup();
				exit();
			}
		}

		// test: GET
		{
			$rows = $conn->get("*", "name='$testName'");
			$num_rows = count($rows);
			if ($num_rows == 1) {
				$row = $rows[0];

				$nameActual = $row[$testCols[0]];
				$descActual = $row[$testCols[1]];

				if ($nameActual == $testName && $descActual == $testDescModified) {
					echo "GET success.<br>";
				}
				else {
					 echo "GET failed. name=$nameActual, desc=$descActual<br>";
					 cleanup();
				}
			}
			else {
				echo "GET failed. count = $num_rows<br>";
				cleanup();
			}
		}

		// test: DELETE
		{
			$res = $conn->delete($testPKeyName, $id);
			if ($res) {
				// verify res from DBConnection.delete is true
				$query = "SELECT * FROM $testTable WHERE 'name'='$testName'";
				$delRes = $sqlTestOracle->query($query);

				// confirm data is gone
				if ($delRes->num_rows == 0) {
					echo "DELETE success<br>";
				}
				else {
					echo "DELETE failed. num_rows = $delRes->num_rows<br>";
					cleanup();
					exit();
				}
			}
			else {
				echo "DELETE failed. res is false.<br>";
				cleanup();
				exit();
			}
		}
	}
	catch (exception $e) {
		echo "Failed: $e->message";
	}
	finally {
		cleanup();
	}

	function cleanup() {
		$sql = new mysqli("localhost", "root", "", "bike_hiring_system");
		$sql->query("DELETE FROM accessory_type_table WHERE name='name1126491' AND description='description1126491'");
		$sql->query("DELETE FROM accessory_type_table WHERE name='name1126491' AND description='description1126491modified'");

		echo "<br>Performed cleanup";
		exit();
	}
?>
