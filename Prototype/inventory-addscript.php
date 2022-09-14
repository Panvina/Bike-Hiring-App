<?php
    session_start();
    include 'php-scripts/backend-connection.php';
    include("inventory-util.php");
    $conn = new mysqli("localhost", "root", "", "bike_hiring_system");

    $bikeId = $_POST["bikeId"];
    //$name = $_POST["name"];
    //$bikeTypeId = $_POST["bikeTypeId"];
    //$helmetId = $_POST["helmetId"];
    //$price = $_POST["price"];
    $safetyInspect = $_POST["safetyInspect"];
    //$description = $_POST["description"];


    //$tempHelmetId = explode("-",$helmetId,2);
    //$tempBikeTypeId = explode("-",$bikeTypeId,2);
    
    
    if(isset($_POST['AddItem'])){
        /* Form validation for adding records*/
        //Check if all the fields are empty
       if(empty($_POST["name"]) && empty($_POST["bikeTypeId"]) && empty($_POST["helmetId"]) && empty($_POST["price"]) && empty($_POST["description"]))
        {
            header("Location: Inventory.php?insert=empty");
        }
        //Check if the name field is empty
        else if(empty($_POST["name"]))
        {
            header("Location: Inventory.php?insert=emptyName");
        }
        //Check if the bike type id is empty
        else if (empty($_POST["bikeTypeId"]))
        {
            header("Location: Inventory.php?insert=emptyType");
        }
        //Check if the helmet id is empty
        else if (empty($_POST["helmetId"]))
        {
            header("Location: Inventory.php?insert=emptyHelmet");
        }
        //Check if the price field is empty
        else if (empty($_POST["price"]))
        {
            header("Location: Inventory.php?insert=emptyPrice");
        }
        //Check if only the description field is empty
        else if (empty($_POST["description"])) 
        {
           header("Location: Inventory.php?insert=emptyDescription");
        }
        //Check if the name field has only alphabets
        else if (!validName($_POST["name"])) 
        {
           header("Location: Inventory.php?insert=invalidName");
        }
        //Check if the price field has only integers and decimals
        else if (!validPrice($_POST["price"]))
        {
            header("Location: Inventory.php?insert=invalidPrice");
        }
        else 
        {
            //Cleaning the inputs before assigning to variables 
            $name = test_input($_POST["name"]);
            $bikeTypeId = test_input($_POST["bikeTypeId"]);
            $helmetId = test_input($_POST["helmetId"]);
            $tempHelmetId = explode("-",$helmetId,2);
            $tempBikeTypeId = explode("-",$bikeTypeId,2);
            $price = test_input($_POST["price"]);
            $description = test_input($_POST["description"]);
        }
    //Final check to ensure variables are not empty
    if(empty($name) && empty($bikeTypeId) && empty($price))
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
}
?>