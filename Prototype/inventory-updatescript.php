<?php
    session_start();
    include_once("backend-connection.php");
    include_once "utils.php";
    //$conn = new DBConnection("bike_inventory_table");
    $conn = new mysqli("localhost", "root", "", "bike_hiring_system") or die(mysqli_error($mysqli));
    $ret = array();
    
    //$fetchData = $fetchData[0];
    

    if (isset($_POST['updateItem']))
  {
        $pk = $_POST['updateItem'];
    
        $cols = "bike_id, name, bike_type_id, helmet_id, price_ph, safety_inspect, description";

        //$condition = "bike_id='$pk'";

        $query = "SELECT * FROM bike_inventory_table WHERE bike_id=$pk";

        $result = mysqli_query($conn, $query);
        $fetchData = $result->fetch_array();


        $_SESSION["bike_id"] = $fetchData["bike_id"];
        $_SESSION["name"] = $fetchData["name"];
        $_SESSION["bike_type_id"] = $fetchData["bike_type_id"];
        $_SESSION["helmet_id"] = $fetchData["helmet_id"];
        $_SESSION["price_ph"] = $fetchData["price_ph"];
        $_SESSION["safety_inspect"] = $fetchData["safety_inspect"];
        $_SESSION["description"] = $fetchData["description"];
        

        $name = $_SESSION['name'];
        $bikeTypeId = $_SESSION['bike_type_id'];
        $helmetId = $_SESSION['helmet_id'];
        $price = $_SESSION['price_ph'];
        $safetyInspect = $_SESSION['safety_inspect'];
        $description = $_SESSION['description'];

        if (!checkEmptyVariables([$name, $bikeTypeId, $helmetId, $price, $safetyInspect , $description]))
        {
            header("Location: Inventory.php?update=notEmpty");
            exit();
        }
        else
        {
            header("Location: Inventory.php?update=empty");
            exit();
        } 
   }
   
   if (isset($_POST["submitUpdateItem"]))
   {
        $bikeId = $_POST['bikeId'];
        $name = $_POST['name'];
        $bikeTypeId = $_POST['bikeTypeId'];
        $helmetId = $_POST['helmetId'];
        $price = $_POST['price'];
        $safetyInspect = $_POST['safetyInspect'];
        $description = $_POST['description'];

        $cols = "`bike_id`, `name`, `bike_type_id`, `helmet_id`, `price_ph`, `safety_inspect`, `description`";
        $data = "'$bikeId', '$name', '$bikeTypeId', '$helmetId', '$price', '$safetyInspect', '$description'";

        $conn->query("UPDATE bike_inventory_table 
        SET name='$name', bike_type_id = '$bikeTypeId', helmet_id='$helmetId', description='$description', `price_ph`='$price', `safety_inspect`='$safetyInspect'
        WHERE bike_id=$bikeId");

        header("location:Inventory.php?update=true");
       
   }
        
?>