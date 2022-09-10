<?php
    session_start();
    include_once("php-scripts\backend-connection.php");
    include ("php-scripts/utils.php");
    $conn = new mysqli("localhost", "root", "", "bike_hiring_system") or die(mysqli_error($mysqli));
    $ret = array();
  
    if (isset($_POST['updateItem']))
  {
        $primaryKey = $_POST['updateItem'];
    
        $cols = "accessory_id, name, accessory_type_id, price_ph, safety_inspect";

        $query = "SELECT * FROM accessory_inventory_table WHERE accessory_id=$primaryKey";

        $result = mysqli_query($conn, $query);
        $fetchData = $result->fetch_array();


        $_SESSION["accessory_id"] = $fetchData["accessory_id"];
        $_SESSION["name"] = $fetchData["name"];
        $_SESSION["accessory_type_id"] = $fetchData["accessory_type_id"];
        $_SESSION["price_ph"] = $fetchData["price_ph"];
        $_SESSION["safety_inspect"] = $fetchData["safety_inspect"];
        

        $name = $_SESSION['name'];
        $accessoryTypeId = $_SESSION['accessory_type_id'];       
        $price = $_SESSION['price_ph'];
        $safetyInspect = $_SESSION['safety_inspect'];

        header("location:Accessory.php?update=notEmpty");
        /* if (!checkEmptyVariables([$name, $accessoryTypeId, $price, $safetyInspect]))
        {
            header("Location: Accessory.php?update=notEmpty");
            exit();
        }
        else
        {
            header("Location: Accessory.php?update=empty");
            exit();
        }  */
   }
   
   if (isset($_POST["submitUpdateItem"]))
   {
        $accessoryId = $_POST['accessoryId'];
        $name = $_POST['name'];
        $accessoryTypeId = $_POST['accessoryTypeId'];
        $price = $_POST['price'];
        $safetyInspect = $_POST['safetyInspect'];

        $cols = "`accessory_id`, `name`, `accessory_type_id`, `price_ph`, `safety_inspect`";
        $data = "'$accessoryId', '$name', '$accessoryTypeId', '$helmetId', '$price', '$safetyInspect'";

        $conn->query("UPDATE accessory_inventory_table 
        SET name='$name', accessory_type_id = '$accessoryTypeId', `price_ph`='$price', `safety_inspect`='$safetyInspect'
        WHERE accessory_id=$accessoryId");

        header("location:Accessory.php?update=true");      
   }
        
?>