<?php
    session_start();
    include_once("backend-connection.php");
    include_once "utils.php";
    $conn = new mysqli("localhost", "root", "", "bike_hiring_system") or die(mysqli_error($mysqli));

    if (isset($_POST['deleteItem']))
    {
        $primaryKey = $_POST['deleteItem'];
    
        $cols = "accessory_id, name, accessory_type_id, price_ph, safety_inspect";

        $query = "SELECT * FROM accessory_inventory_table WHERE accessory_id=$primaryKey";

        $result = mysqli_query($conn, $query);
        $fetchData = $result->fetch_array();
 
        $_SESSION["accessory_id"] = $fetchData["accessory_id"];
        $primaryKey = $_SESSION["accessory_id"];

        header("Location: ../Accessory.php?delete=$primaryKey");
        exit();
    }

    if (isset($_POST["submitDeleteItem"]))
    {
       
        $primaryKey = $_POST["submitDeleteItem"];
        $query = "DELETE FROM accessory_inventory_table WHERE accessory_id=$primaryKey";
        $results = mysqli_query($conn, $query);
        header("Location: ../Accessory.php?delete=true");
    }

    if (isset($_POST["cancelDeleteItem"]))
    {
     header("Location: ../Accessory.php");
     exit();
    }
?> 