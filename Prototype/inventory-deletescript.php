<?php
    session_start();
    include_once("backend-connection.php");
    include_once "utils.php";
    $conn = new mysqli("localhost", "root", "", "bike_hiring_system") or die(mysqli_error($mysqli));

    
    if (isset($_POST['deleteItem']))
    {
        $primaryKey = $_POST['deleteItem'];
    
        $cols = "bike_id, name, bike_type_id, helmet_id, price_ph, safety_inspect, description";

        $query = "SELECT * FROM bike_inventory_table WHERE bike_id=$primaryKey";

        $result = mysqli_query($conn, $query);
        $fetchData = $result->fetch_array();

        $_SESSION["bike_id"] = $fetchData["bike_id"];
        $primaryKey = $_SESSION["bike_id"];
        header("Location: Inventory.php?delete=$primaryKey");
        exit();
    }

    if (isset($_POST["submitDeleteItem"]))
    {

        $primaryKey = $_POST["submitDeleteItem"];
        $query = "DELETE FROM bike_inventory_table WHERE bike_id=$primaryKey";
        $results = mysqli_query($conn, $query);


        header("Location: Inventory.php?delete=true");
    }

    if (isset($_POST["cancelDeleteItem"]))
    {
     header("Location: Inventory.php?");
     exit();
    }
?> 