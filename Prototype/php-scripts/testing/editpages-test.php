<?php

$conn = new mysqli("localhost", "root", "", "bike_hiring_system");

//Add Test Edit
$editQuery = "INSERT INTO content_editing_table (edit_id, edit_name, edit_content, edit_is_text, edit_is_image) VALUES ('999', '999', '999', '1', '0')";
$conn->query($editQuery);

try {
	//Get Edit Variables
	$editTest = $conn->query("SELECT * FROM content_editing_table WHERE edit_id='999'");
    while ($row = $editTest->fetch_assoc()) {
    	$edit_id = $row["edit_id"];  
    	$edit_content = $row["edit_content"];    
    }
   // Get Edit ID Test
	if ($edit_id == '999')
	{
		echo "Success: Edit Recieved.<br>";
	}
	else
	{
		echo "Failure: Edit Not Recieved.<br>";
	}
	if ($edit_content == '999')
	{
		echo "Success: Edit Content Recieved.<br>";
	}
	else
	{
		echo "Failure: Edit Content Not Recieved.<br>";
	}
	// Change Edit Content Status
	$editsChangeQuery = "UPDATE content_editing_table SET edit_content = '888' WHERE edit_id = '999'";
	$conn->query($editsChangeQuery);

	$editTest2 = $conn->query("SELECT * FROM content_editing_table WHERE edit_id='999'");
    while ($row = $editTest2->fetch_assoc()) { 
    	$edit_content2 = $row["edit_content"];    
    }
    // Get New Edit Content Test
	if ($edit_content2 == '888')
	{
		echo "Success: Edit Content Successfully Changed.<br>";
	}
	else
	{
		echo "Failure: Edit Content Unsuccessfully Changed.<br>";
	}

}
catch (Exception $e) {
	//Catch Exceptions
	$msg = $e->getMessage();
	echo "<br>$msg";
}
finally {
	// Clean Up
	$conn = new mysqli("localhost", "root", "", "bike_hiring_system");
	$conn->query("DELETE FROM content_editing_table WHERE edit_id='999'");
}
?>