<?php
    session_start();
    include 'backend-connection.php';
    $conn = new mysqli("localhost", "root", "", "bike_hiring_system");

    $accessoryId = $_POST["accessoryId"];
    $name = $_POST["name"];
    $accessoryTypeId = $_POST["accessoryTypeId"];
    $price = $_POST["price"];
    $safetyInspect = $_POST["safetyInspect"];


    $tempaccessoryTypeId = explode("-",$accessoryTypeId,2);
    

    if(!$conn)
    {
        echo "<p>Failure</p>";
    }
    else
    {
        $cols = "`accessory_id`, `name`, `accessory_type_id`, `price_ph`, `safety_inspect`";
        $data = "'$accessoryId', '$name', '$tempaccessoryTypeId[0]', '$price', '$safetyInspect'";
        
        $query = "INSERT INTO `accessory_inventory_table` ($cols) VALUES ($data)";
        $results = mysqli_query($conn,$query);
        
        header("Location: Accessory.php?insert=true");
    
        mysqli_close($conn);
    }
?>