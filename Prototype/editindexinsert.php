<?php
session_start();

date_default_timezone_set('Australia/Melbourne');

include_once("php-scripts/backend-connection.php");

//Linking utility functions associated with inventory
include("php-scripts/utils.php");

//Establishing database connection using mysqli()
$conn = new mysqli("localhost", "root", "", "bike_hiring_system");

$edit_content_text =  $_REQUEST['edit_content_text'];


$sql = "UPDATE content_editing_table SET edit_content='$edit_content_text' WHERE edit_id=1";

if ($conn->query($sql) === TRUE) {
  echo "Record updated successfully";
} else {
  echo "Error updating record: " . $conn->error;
}

$conn->close();

header("Location: editpages.php");



?>

<!DOCTYPE html>
</script>
</body>
</html>
