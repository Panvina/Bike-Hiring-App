<?php

// Edit Index Page Insert - Created by Eamon Kearney 102093549 //

session_start();

date_default_timezone_set('Australia/Melbourne');

include_once("php-scripts/backend-connection.php");

//Linking utility functions associated with inventory
include("php-scripts/utils.php");

//Establishing database connection using mysqli()
$conn = new mysqli("localhost", "root", "", "bike_hiring_system");

//Get value from submitted text
$edit_content_text =  $_REQUEST['edit_content_text'];

//Update query to change text
$sql = "UPDATE content_editing_table SET edit_content='$edit_content_text' WHERE edit_id=1";

//Check if successful
if ($conn->query($sql) === TRUE) {
  echo "Updated successfully";
} else {
  echo "Error: " . $conn->error;
}

//Close connection
$conn->close();

//Redirect to edit pages 
header("Location: editpages.php");



?>

<!DOCTYPE html>
</script>
</body>
</html>
