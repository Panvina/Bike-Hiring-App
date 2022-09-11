<?php
    session_start();
    include 'php-scripts/backend-connection.php';
    $conn = new mysqli("localhost", "root", "", "bike_hiring_system");

    $bikeId = $_POST["accessoryId"];
    $name = $_POST["name"];
    $description = $_POST["description"];

    if(!$conn)
    {
        echo "<p>Failure</p>";
    }
    else
    {
        $cols = "`accessory_type_id`, `name`, `description`";
        $data = "'$bikeId', '$name', '$description'";
        
        $query = "INSERT INTO `accessory_type_table` ($cols) VALUES ($data)";
        $results = mysqli_query($conn,$query);
        
        header("Location: AccessoryTypes.php?insert=true");
    
        mysqli_close($conn);
    }

?>