<?php

// Block Out Date Block Function - Created by Eamon Kearney 102093549 //

session_start();

date_default_timezone_set('Australia/Melbourne');

include_once("php-scripts/backend-connection.php");

//Linking utility functions associated with inventory
include("php-scripts/utils.php");

//Establishing database connection using mysqli()
$conn = new mysqli("localhost", "root", "", "bike_hiring_system");
?>
<?php 
    //Get submitted block out date from form 
    $blockOutDate =  $_REQUEST['blockOutDate'];
    //Update sql statement to block date in database
    $sql = "UPDATE block_out_dates SET date_blockout = 1 WHERE date_id = $blockOutDate";
  if(mysqli_query($conn, $sql)){
  } else{
  // Echo error if failed query fails
      echo "ERROR: $sql. " 
          . mysqli_error($conn);
  }
  // Close connection
  mysqli_close($conn);
  // Redirect to block out date page
  header("Location: Block_Out_Date.php");

?>
