<?php
    /* Code completed by Aadesh Jagannathan - 102072344*/
    /* Script responsible for deleting records in inventory table*/
    session_start();
    include_once("backend-connection.php");
    include_once "utils.php";
    $conn = new mysqli("localhost", "root", "", "bike_hiring_system") or die(mysqli_error($mysqli));

    // Check to retreive record ID when delete record button has been clicked
    if (isset($_POST['deleteItem']))
    {
        $primaryKey = $_POST['deleteItem'];
    
        $cols = "bike_id, name, bike_type_id, helmet_id, price_ph, safety_inspect, description";

        $query = "SELECT * FROM bike_inventory_table WHERE bike_id=$primaryKey";

        $result = mysqli_query($conn, $query);
        $fetchData = $result->fetch_array();

        $_SESSION["bike_id"] = $fetchData["bike_id"];
        $primaryKey = $_SESSION["bike_id"];
        header("Location:../Inventory.php?delete=$primaryKey");
        exit();
    }

    // Check to delete item if the yes button has been clicked
    if (isset($_POST["submitDeleteItem"]))
    {

        $primaryKey = $_POST["submitDeleteItem"];
        $query = "DELETE FROM bike_inventory_table WHERE bike_id=$primaryKey";
        $results = mysqli_query($conn, $query);


        //Check if the record has been deleted successfully
        if(mysqli_affected_rows($conn) == 1)
        {
            header("Location: ../Inventory.php?delete=true");
            exit();

        }
        else
        {
            header("Location: ../Inventory.php?delete=false");
            exit();
        }
    }

    // Check to not delete item if the no button has been clicked
    if (isset($_POST["cancelDeleteItem"]))
    {
     header("Location:../Inventory.php?delete=false");
     exit();
    }
?> 