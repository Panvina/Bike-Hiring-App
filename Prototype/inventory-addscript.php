<?php
    session_start();
    include 'backend-connection.php';
    $conn = new mysqli("localhost", "root", "", "bike_hiring_system");

    $bikeId = $_POST["bikeId"];
    $name = $_POST["name"];
    $bikeTypeId = $_POST["bikeTypeId"];
    $helmetId = $_POST["helmetId"];
    $price = $_POST["price"];
    $safetyInspect = $_POST["safetyInspect"];
    $description = $_POST["description"];


    $tempHelmetId = explode("-",$helmetId,2);
    $tempBikeTypeId = explode("-",$bikeTypeId,2);
    

    if(!$conn)
    {
        echo "<p>Failure</p>";
    }
    else
    {
        $cols = "`bike_id`, `name`, `bike_type_id`, `helmet_id`, `price_ph`, `safety_inspect`, `description`";
        $data = "'$bikeId', '$name', '$tempBikeTypeId[0]', '$tempHelmetId[0]', '$price', '$safetyInspect', '$description'";
        
        $query = "INSERT INTO `bike_inventory_table` ($cols) VALUES ($data)";
        $results = mysqli_query($conn,$query);
        
        header("Location: Inventory.php?insert=true");
    
        mysqli_close($conn);
    }
?>